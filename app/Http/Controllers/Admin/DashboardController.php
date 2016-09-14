<?php
namespace TuaWebsite\Http\Controllers\Admin;

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
    public function showDashboard()
    {
        return \View::make('admin.dashboard');
    }
}