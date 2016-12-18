<?php

namespace TuaWebsite\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    // Internals ----
    /**
     * Add notification data to a flash message
     *
     * @param string $title
     * @param string $message
     * @param string $colour
     */
    protected function flash($title, $message, $colour = null)
    {
        \Session::flash('flash.notification.title', $title);
        \Session::flash('flash.notification.message', $message);
        \Session::flash('flash.notification.colour', $colour);
    }
}
