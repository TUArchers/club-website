<?php
namespace TuaWebsite\Http\ViewComposers;

use Illuminate\View\View;
use TuaWebsite\Domain\Identity\User;

/**
 * Admin Layout Composer
 *
 * @package TuaWebsite\Http\ViewComposers
 * @author  James Drew <jdrew9@hotmail.co.uk>
 * @version 0.1.0
 * @since   0.1.0
 */
class AdminLayoutComposer
{
    // Properties ----
    /**
     * @var User
     */
    protected $user;

    // Setup ----
    /**
     * AdminComposer constructor.
     */
    public function __construct()
    {
        $this->user = \Auth::user();
    }

    // Methods ----
    /**
     * @param View $view
     */
    public function compose(View $view)
    {
        $view->with('user', $this->user);
    }
}