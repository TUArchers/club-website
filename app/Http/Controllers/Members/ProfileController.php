<?php
namespace TuaWebsite\Http\Controllers\Members;

use TuaWebsite\Http\Controllers\Controller;

/**
 * Profile Controller
 *
 * @package TuaWebsite\Http\Controllers\Members
 * @author
 * @version 0.1.0
 * @since   0.1.0
 */
class ProfileController extends Controller
{
    public function showProfile($memberId)
    {
        echo $memberId;
    }
}