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
        $change_log = 'https://trello.com/b/8olcGjLH/club-website';
        $message    = "This system is still being developed. There are some features that do not do anything yet. Please let James know about anything that actually breaks. <br/><br/> 18-09-2018: Version 0.4.2 has been released. Changes can be seen <a class='alert-link' target='_blank' href='${change_log}'>here</a>";
        $events     = Event::nextSevenDays()->take(6)->get();
        $scores     = Score::orderBy('shot_at', 'desc')->take(6)->get();
        $users      = User::orderBy('updated_at', 'desc')->take(6)->get();

        return \View::make('admin.dashboard', compact('message', 'events', 'scores', 'users'));
    }
}