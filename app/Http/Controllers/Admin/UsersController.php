<?php
namespace TuaWebsite\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use TuaWebsite\Domain\Identity\ExperienceLevel;
use TuaWebsite\Domain\Identity\Gender;
use TuaWebsite\Domain\Identity\Membership;
use TuaWebsite\Domain\Identity\Organisation;
use TuaWebsite\Domain\Identity\Role;
use TuaWebsite\Domain\Identity\User;
use TuaWebsite\Domain\Records\Score;
use TuaWebsite\Http\Controllers\Controller;
use TuaWebsite\Notifications\WelcomeNotification;

/**
 * Users Controller (Admin)
 *
 * @package TuaWebsite\Http\Controllers\Admin
 * @author  James Drew <jdrew9@hotmail.co.uk>
 * @version 0.2.0
 * @since   0.1.0 Introduced this class
 * @since   0.2.0 Improved the way scores and memberships are queried/added
 * @since   0.3.0 Added flash messages to feedback to user
 */
class UsersController extends Controller
{
    // Setup ----
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Actions ----
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        // Get users
        $users = User::all();

        // Return view
        return \View::make('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $action            = route('admin.users.store');

        $roles             = Role::all();
        $genders           = Gender::all();
        $experience_levels = ExperienceLevel::all();

        return view('admin.users.create', compact('action', 'roles', 'genders', 'experience_levels'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        // Collect user data
        $user_data               = array_filter($request->only(['email', 'phone', 'first_name', 'last_name', 'gender', 'birth_date', 'role_id', 'experience_level']));
        $user_data['is_student'] = $request->has('is_student');

        // Generate or use a specified password
        $password = $request->get('password', str_random(12));

        // Hash up the password and set the registration date
        $user_data['password_hash'] = \Hash::make($password);
        $user_data['registered_at'] = Carbon::now();

        // Add profile image, if specified
        if($request->has('picture')){
            $user_data['picture_url'] = $this->storeUserPhoto($request->get('picture'));
        }

        // Register the user
        $user = User::create($user_data);

        // Send a welcome notification
        $user->notify(
            new WelcomeNotification($password)
        );

        // Show on-screen confirmation
        $this->flash('Done!', $user->first_name . ' has been registered', 'green');

        return redirect(
            route('admin.users.show', $user->id)
        );
    }

    /**
     * Display the specified resource.
     *
     * @param int  $id
     *
     * @return Response
     */
    public function show($id)
    {
        $user              = User::findOrFail($id);
        $emergency_contact = $user->emergencyContact;
        $memberships       = $this->getCurrentMembershipsForUser($id);
        $recent_scores     = $this->getRecentScoresForUser($id);
        $personal_bests    = $this->getPersonalBestsForUser($id);

        return view(
            'admin.users.show',
            compact('user', 'emergency_contact', 'memberships', 'recent_scores', 'personal_bests')
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int  $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $is_self           = \Auth::id() == $id;
        $action            = route('admin.users.update', $id);

        /** @var User $user */
        $user              = User::findOrFail($id);
        $emergency_contact = $user->emergencyContact;
        $memberships       = $user->memberships;

        $roles             = Role::all();
        $genders           = Gender::all();
        $experience_levels = ExperienceLevel::all();
        $organisations     = Organisation::all();

        return view(
            'admin.users.edit',
            compact('action', 'is_self', 'user', 'emergency_contact', 'memberships', 'roles', 'genders', 'experience_levels', 'organisations')
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @TODO Refactor this to reduce the complexity
     *
     * @param Request $request
     * @param int     $id
     *
     * @return Response
     */
    public function update(Request $request, $id)
    {
        /** @var User $user */
        $user = User::findOrFail($id);

        // Based on the content of the request, update the user details
        if($request->has('emergencyContact')){
            // Handle emergency contact card only
            $this->updateEmergencyContact($user, $request->get('emergencyContact'));
            $this->flash('Done!', $user->first_name . "'s emergency contact details have been updated", 'green');
        }
        elseif($request->has('account')){
            // Handle account details card only
            $passwordChanged = false;
            if($request->has('password') && $request->has('password_confirm')){
                $user_data['password_hash'] = \Hash::make($request->get('password'));
                $passwordChanged = true;
            }

            $user_data = $request->get('account');
            $user->update($user_data);

            if($passwordChanged){
                $user->sendPasswordChangedNotification();
            }

            $this->flash('Done!', $user->first_name . "'s account details have been updated", 'green');
        }
        elseif($request->has('memberships')){
            // Handle memberships card only
            $this->synchroniseMemberships($user, $request->get('memberships'));
            $this->flash('Done!', $user->first_name . "'s membership history has been updated", 'green');
        }
        else{
            // Handle user profile only
            $user_data               = array_filter($request->only(['phone', 'first_name', 'last_name', 'gender', 'birth_date', 'experience_level']));
            $user_data['is_student'] = $request->has('is_student');

            // Handle a new profile picture
            if($request->has('picture')){
                $user_data['picture_url'] = $this->storeUserPhoto($request->get('picture'), $user->picture_url);
            }

            $user->update($user_data);
            $this->flash('Done!', $user->first_name . "'s profile has been updated", 'green');
        }

        return redirect(
            route('admin.users.edit', $id)
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int  $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var User $user */
        $user = User::findOrFail($id);

        $user->delete();
        $this->flash('Done!', $user->first_name . "'s account has been removed", 'green');

        return redirect('/admin/users');
    }

    // Internals ----
    /**
     * @param string $imageData
     * @param string $existing
     *
     * @return string
     */
    private function storeUserPhoto($imageData, $existing = null)
    {
        $storage = \Storage::disk('public');

        // Make and store the file
        $fileName = sprintf('uploads/users/%s.jpg', md5(str_random()));
        $image     = \Image::make($imageData);

        $storage->put($fileName, $image->encode('jpg'));

        // Remove the old one, if specified
        if(is_string($existing)){
            $url  = parse_url($existing);
            $path = preg_replace('/storage\//', '', $url['path']);

            $storage->delete($path);
        }

        return asset('storage/' . $fileName);
    }

    /**
     * @param User $user
     * @param array $contactDetails
     */
    private function updateEmergencyContact(User $user, array $contactDetails)
    {
        $contact = $user->emergencyContact;

        if(!$contact){
            $user->emergencyContact()->create($contactDetails);
        }
        else{
            $contact->update($contactDetails);
        }
    }

    /**
     * @param User $user
     * @param array $memberships
     */
    private function synchroniseMemberships(User $user, array $memberships)
    {
        // Clear membership list
        $user->memberships()->delete();

        // Add new membership list
        $memberships = array_map(function(array $m){
            return new Membership($m);
        }, $memberships);

        $user->memberships()->saveMany($memberships);
    }

    /**
     * @param int $id
     *
     * @return Collection|Membership[]
     */
    private function getCurrentMembershipsForUser($id)
    {
        $subQuery = \DB::table('memberships')
            ->selectRaw('MAX(expires_at) AS exp, organisation')
            ->where('user_id', $id)
            ->groupBy('organisation');

        return Membership::from('memberships as m')
            ->where('m.user_id', $id)
            ->join(\DB::raw('(' . $subQuery->toSql() . ') as max'), function(JoinClause $join){
                $join->on('max.organisation', '=', 'm.organisation');
                $join->on('max.exp', '=', 'm.expires_at');
            })
            ->mergeBindings($subQuery)
            ->get();

    }

    /**
     * @param int $id
     *
     * @return Collection|Score[]
     */
    private function getRecentScoresForUser($id)
    {
        return Score::where('archer_id', $id)
            ->orderBy('shot_at', 'desc')
            ->take(5)
            ->get();
    }

    /**
     * @param int $id
     *
     * @return Collection
     */
    private function getPersonalBestsForUser($id)
    {
        $subQuery = \DB::table('scores')
            ->select(\DB::raw('archer_id, MAX(total_score) as total_score, round_id, bow_class'))
            ->where('archer_id', '=', $id)
            ->groupBy('round_id', 'archer_id', 'bow_class');

        return Score::from('scores as s')
            ->select(\DB::raw('s.round_id, s.archer_id, s.bow_class, s.total_score, MIN(s.shot_at) AS shot_at'))
            ->join('rounds as r', 's.round_id', '=', 'r.id')
            ->join('users as u', 's.archer_id', '=', 'u.id')
            ->join(\DB::raw('(' . $subQuery->toSql() . ') as pbs'), function(JoinClause $join){
                $join->on('pbs.archer_id', '=', 's.archer_id');
                $join->on('pbs.round_id', '=', 's.round_id');
                $join->on('pbs.bow_class', '=', 's.bow_class');
                $join->on('pbs.total_score', '=', 's.total_score');
            })
            ->groupBy('s.round_id', 's.archer_id', 's.bow_class', 's.total_score', 'r.name')
            ->orderBy('r.name', 'asc')
            ->mergeBindings($subQuery)
            ->get();
    }
}
