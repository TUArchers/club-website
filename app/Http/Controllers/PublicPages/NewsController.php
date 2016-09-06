<?php
namespace TuaWebsite\Http\Controllers\PublicPages;

use TuaWebsite\Http\Controllers\Controller;
use View;

/**
 * News Controller
 *
 * @package TuaWebsite\Http\Controllers\PublicPages
 * @author
 * @version 0.1.0
 * @since   0.1.0
 */
class NewsController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function home()
    {
        return View::make('public.home');
    }
}