<?php

namespace TuaWebsite\Http\Controllers\Kiosk;

use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Collection;
use TuaWebsite\Domain\Event\Event;
use TuaWebsite\Domain\Event\EventType;
use TuaWebsite\Domain\Event\Reservation;
use TuaWebsite\Domain\Identity\Demographic;
use TuaWebsite\Domain\Identity\Gender;
use TuaWebsite\Domain\Identity\Role;
use TuaWebsite\Domain\Identity\User;
use TuaWebsite\Http\Controllers\Controller;
use TuaWebsite\Mail\EventReservationConfirmed;
use TuaWebsite\Mail\EventReservationReminder;

/**
 * Tasters Controller
 *
 * @package TuaWebsite\Http\Controllers\Kiosk
 * @author
 * @version 0.1.0
 * @since   0.1.0
 */
class TastersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $event_days = $this->getTasterEventsGroupedByDay();

        $genders = Gender::all();

        $schools        = $this->arrayToCollection([
            'SCM'   => 'School of Computing, Media & the Arts',
            'SOH'   => 'School of Health & Social Care',
            'SSE'   => 'School of Science, Engineering & Design',
            'SSSHL' => 'School of Social Sciences, Humanities and Law',
            'TUBS'  => 'Teesside University Business School',
            'STAFF' => 'University Staff',
            'ASSOC' => 'University Associates and Alumni',
            'O'     => 'Other'
        ]);
        $subjects       = $this->arrayToCollection([
            'Sc'  => 'Science',
            'A'   => 'Art',
            'Ed'  => 'Education',
            'Eng' => 'Engineering',
            'Ph'  => 'Philosophy',
            'BA'  => 'Business Administration',
            'O'   => 'Other',
            'NA'  => 'Not Applicable'
        ]);
        $qualifications = $this->arrayToCollection([
            'Dip' => 'Diploma',
            'Fd'  => 'Foundation Degree',
            'B'   => 'Bachelor\'s Degree',
            'M'   => 'Master\'s Degree',
            'D'   => 'Doctorate',
            'O'   => 'Other',
            'NA'  => 'Not Applicable'
        ]);
        $years          = $this->arrayToCollection([
            '1' => '1',
            '2' => '2',
            '3' => '3',
            '4' => '4',
            '5' => '5',
            '6' => '6',
            '7' => '7+',
            'NA' => 'Not Applicable'
        ]);

        return view('kiosk.tasters', compact('event_days', 'genders', 'schools', 'subjects', 'qualifications', 'years'));
    }

    // API Actions ----
    /**
     * @param Request $request
     * @param int     $eventId
     *
     * @return JsonResponse
     */
    public function storeReservation(Request $request, $eventId)
    {
        if($request->has('reservation_id')){
            Reservation::destroy($request->get('reservation_id'));
        }

        /** @var Event $event */
        $event       = Event::find($eventId);
        $reservation = $event->reserveSpace();

        $reservation->save();

        return response()->json($reservation->toArray());
    }

    /**
     * @param Request $request
     * @param int $eventId
     * @param int $reservationId
     *
     * @return JsonResponse
     */
    public function updateReservation(Request $request, $eventId, $reservationId)
    {
        /** @var Reservation $reservation */
        $reservation = Reservation::find($reservationId);
        /** @var Event $event */
        $event       = Event::find($eventId);

        // Check reservation is good
        if($reservation->has_expired){
            return response()->json(['message' => 'That reservation has expired'], 408);
        }

        // Make a user account
        $user = $this->makeUserAccount(
            array_filter($request->get('attendee'))
        );

        // If demographics were provided, store them too
        if($request->has('demographics') && !empty($request->get('demographics'))){
            $demographic_data            = $request->get('demographics');
            $demographic_data['user_id'] = $user->id;

            Demographic::create($demographic_data);
        }

        // Confirm the reservation
        $reservation->confirm($user);
        $reservation->save();

        // Queue up emails
        $this->queueEmail(new EventReservationConfirmed($reservation), $user);
        $this->queueEmail(new EventReservationReminder($reservation), $user, $event->starts_at->subDays(1));

        return response()->json($reservation->toArray());
    }

    // Internals ----
    private function getTasterEventsGroupedByDay()
    {
        $type   = EventType::where('name', 'Taster Session')->first();
        $events = Event::where('type_id', $type->id)
            ->where('starts_at', '>=', new \DateTime())
            ->orderBy('starts_at', 'asc')
            ->get();

        $eventDays = [];
        foreach($events as $event){
            $day = $event->starts_at->format('l jS F');

            if(!isset($eventDays[$day])){
                $eventDays[$day] = [];
            }

            $eventDays[$day][] = $event;
        }

        return new Collection($eventDays);
    }
    
    /**
     * @param array $array
     *
     * @return Collection|\stdClass[]
     */
    private function arrayToCollection(array $array)
    {
        $objects = [];
        foreach($array as $key => $value){
            $obj = new \stdClass();
            $obj->id   = $key;
            $obj->name = $value;

            $objects[] = $obj;
        }

        return new Collection($objects);
    }

    /**
     * @param array $user_data
     *
     * @return User
     */
    private function makeUserAccount(array $user_data)
    {
        $role = Role::where('slug', 'guest')->first();

        $user_data['password_hash'] = \Hash::make(str_random(12));
        $user_data['registered_at'] = Carbon::now();

        $user = new User($user_data);
        $user->role()->associate($role);

        $user->save();

        return $user;
    }

    /**
     * @param Mailable $email
     * @param User $recipient
     * @param Carbon|null $sendDate
     */
    private function queueEmail(Mailable $email, User $recipient, Carbon $sendDate = null)
    {
        if($sendDate && method_exists($email, 'delay')){
            $delay = $sendDate->diffInSeconds(Carbon::now());
            $email->delay($delay);
        }

        \Mail::to($recipient)->queue($email);
    }
}
