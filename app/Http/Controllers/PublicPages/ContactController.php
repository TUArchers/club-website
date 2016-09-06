<?php
namespace TuaWebsite\Http\Controllers\PublicPages;

use TuaWebsite\Http\Controllers\Controller;
use View;

/**
 * Contact Controller
 *
 * @package TuaWebsite\Http\Controllers\PublicPages
 * @author
 * @version 0.1.0
 * @since   0.1.0
 */
class ContactController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function contact()
    {
        return View::make('public.contact');
    }
}