<?php
namespace TuaWebsite\Http\Controllers\Admin;

use TuaWebsite\Domain\Event\Event;
use TuaWebsite\Domain\Identity\User;
use TuaWebsite\Domain\Records\Score;
use TuaWebsite\Http\Controllers\Controller;

/**
 * Dashboard Controller
 *
 * @package TuaWebsite\Http\Controllers\Admin
 * @author
 * @version 0.1.0
 * @since   0.1.0
 */
class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function showDashboard()
    {
        $message = 'This system is still being developed. There are some features that do not do anything yet. Please let James know about anything that actually breaks. A summary of updates will be shown here periodically.';
        $events  = Event::nextSevenDays()->take(6)->get();
        $scores  = Score::orderBy('shot_at', 'desc')->take(6)->get();
        $users   = User::orderBy('updated_at', 'desc')->take(6)->get();

        return \View::make('admin.dashboard', compact('message', 'events', 'scores', 'users'));
    }
}