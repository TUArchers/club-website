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
 * @since   0.2.0 Improved the way scores and memberships are queried
 */
class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

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
        $roles             = Role::all();
        $genders           = Gender::all();
        $experience_levels = ExperienceLevel::all();

        return view('admin.users.create', compact('roles', 'genders', 'experience_levels'));
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
        $user_data               = array_filter($request->only(['email', 'phone', 'first_name', 'last_name', 'gender', 'birth_date', 'role_id', 'tusc_id', 'agb_id', 'experience_level']));
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

        return redirect('/admin/users');
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
        $user           = User::findOrFail($id);
        $memberships    = $this->getMembershipsForUser($id);
        $recent_scores  = $this->getRecentScoresForUser($id);
        $personal_bests = $this->getPersonalBestsForUser($id);

        return view('admin.users.show', compact('user', 'memberships', 'recent_scores', 'personal_bests'));
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
        $user              = User::findOrFail($id);
        $memberships       = $user->memberships()->orderBy('valid_from', 'asc')->get();
        $roles             = Role::all();
        $genders           = Gender::all();
        $experience_levels = ExperienceLevel::all();
        $organisations     = Organisation::all();

        return view('admin.users.edit', compact('user', 'memberships', 'roles', 'genders', 'experience_levels', 'organisations'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int     $id
     *
     * @return Response
     */
    public function update(Request $request, $id)
    {
        dd($request->all());

        /** @var User $user */
        $user = User::find($id);

        // Get the user data
        $user_data               = array_filter($request->only(['email', 'phone', 'first_name', 'last_name', 'gender', 'birth_date', 'role_id', 'tusc_id', 'agb_id', 'experience_level']));
        $user_data['is_student'] = $request->has('is_student');

        // Handle a new profile picture
        if($request->has('picture')){
            $user_data['picture_url'] = $this->storeUserPhoto($request->get('picture'), $user->picture_url);
        }

        // Store the updates
        $user->update($user_data);

        return redirect('/admin/users');
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
        User::destroy($id);

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
     * @param int $id
     *
     * @return Collection|Membership[]
     */
    private function getMembershipsForUser($id)
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
            ->select(\DB::raw('MAX(total_score) as pb, round_id, bow_class'))
            ->where('archer_id', $id)
            ->groupBy('round_id', 'bow_class');

        return Score::from('scores as s')
            ->where('archer_id', $id)
            ->join(\DB::raw('(' . $subQuery->toSql() . ') as pbs'), function(JoinClause $join){
                $join->on('pbs.round_id', '=', 's.round_id');
                $join->on('pbs.bow_class', '=', 's.bow_class');
                $join->on('pbs.pb', '=', 's.total_score');
            })
            ->join('rounds as r', 's.round_id', '=', 'r.id')
            ->mergeBindings($subQuery)
            ->get();
    }
}
