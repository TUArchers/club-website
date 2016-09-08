<?php

namespace TuaWebsite\Http\Controllers\PublicPages;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Mail\Mailable;
use TuaWebsite\Domain\Event\EventRepositoryInterface;
use TuaWebsite\Domain\Event\ReservationRepositoryInterface;
use TuaWebsite\Domain\Identity\RoleRepositoryInterface;
use TuaWebsite\Domain\Identity\User;
use TuaWebsite\Domain\Identity\UserRepositoryInterface;
use TuaWebsite\Http\Controllers\Controller;
use TuaWebsite\Mail\EventReservationConfirmed;
use TuaWebsite\Mail\EventReservationReminder;
use View;

/**
 * Join Controller
 *
 * @package TuaWebsite\Http\Controllers\PublicPages
 * @author
 * @version 0.1.0
 * @since   0.1.0
 */
class JoinController extends Controller
{
    /** @var EventRepositoryInterface */
    private $events;
    /** @var ReservationRepositoryInterface */
    private $reservations;
    /** @var UserRepositoryInterface */
    private $users;
    /** @var RoleRepositoryInterface */
    private $roles;

    /**
     * JoinController constructor.
     *
     * @param EventRepositoryInterface $eventRepository
     * @param ReservationRepositoryInterface $reservationRepository
     * @param UserRepositoryInterface $userRepository
     * @param RoleRepositoryInterface $roleRepository
     */
    public function __construct(EventRepositoryInterface $eventRepository, ReservationRepositoryInterface $reservationRepository, UserRepositoryInterface $userRepository, RoleRepositoryInterface $roleRepository)
    {
        $this->events       = $eventRepository;
        $this->reservations = $reservationRepository;
        $this->users        = $userRepository;
        $this->roles        = $roleRepository;
    }

    // Actions ----
    public function showJoin()
    {
        return View::make('public.join');
    }

    public function showChooseTaster()
    {
        $events = $this->events->findPublicEvents();
        
        return View::make('public.taster.choose', compact('events'));
    }

    public function postCreateReservation(Request $request)
    {
        // Grab the event and make a reservation
        $event       = $this->events->get($request->get('event_id'));
        $reservation = $event->reserveSpace();

        // Store the new reservation
        $this->reservations->add($reservation);

        // Show the view
        return View::make('public.taster.reserve', [
            'event_id'       => $reservation->event->id,
            'event_name'     => $reservation->event->name,
            'reservation_id' => $reservation->id,
            'expires_at'     => $reservation->expires_at,
        ]);
    }

    public function postConfirmReservation(Request $request)
    {
        // Grab the reservation and a user role
        $reservation = $this->reservations->get($request->get('reservation_id'));
        $role        = $this->roles->withSlug('guest');

        // Make a basic user account
        $user_data = $request->only(['email_address', 'phone_number', 'first_name', 'last_name']);
        $user_data['password_hash'] = \Hash::make(str_random(12));
        $user_data['registered_at'] = Carbon::now();

        $user = new User($user_data);
        $user->role()->associate($role);

        $this->users->add($user);

        // Confirm the reservation
        $reservation->confirm($user);
        $this->reservations->update($reservation);

        // Queue up emails
        $this->queueEmail(new EventReservationConfirmed($reservation), $user);
        $this->queueEmail(new EventReservationReminder($reservation), $user, $reservation->event->starts_at->subHours(2));

        // Show the view
        return View::make('public.taster.confirm', [
            'event_name' => $reservation->event->name
        ]);
    }

    public function showTasterBookingChangeForm()
    {
        //
    }

    public function postConfirmTasterBookingChange()
    {
        //
    }

    /**
     * @param Mailable $email
     * @param User     $recipient
     * @param Carbon   $sendDate
     */
    private function queueEmail(Mailable $email, User $recipient, Carbon $sendDate = null)
    {
        if(!$sendDate){
            \Mail::to($recipient)->queue($email);
        }
        else{
            \Mail::to($recipient)->later($sendDate, $email);
        }
    }
}
