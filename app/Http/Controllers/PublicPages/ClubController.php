<?php
namespace TuaWebsite\Http\Controllers\PublicPages;

use TuaWebsite\Http\Controllers\Controller;
use View;

/**
 * Club Controller
 *
 * @package TuaWebsite\Http\Controllers\PublicPages
 * @author
 * @version 0.1.0
 * @since   0.1.0
 */
class ClubController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function about()
    {
        return View::make('public.about');
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function committee()
    {
        return View::make('public.committee');
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function team()
    {
        return View::make('public.team');
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function history()
    {
        return View::make('public.history');
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function records()
    {
        return View::make('public.records');
    }
}