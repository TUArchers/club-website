<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

# Information
Route::get('/', 'PublicPages\NewsController@home');
Route::get('/about', 'PublicPages\ClubController@about');
Route::get('/committee', 'PublicPages\ClubController@committee');
Route::get('/team', 'PublicPages\ClubController@team');
Route::get('/history', 'PublicPages\ClubController@history');
Route::get('/records', 'PublicPages\ClubController@records');
Route::get('/contact', 'PublicPages\ContactController@contact');

# Join
Route::get('/tasters', 'Kiosk\TastersController@index');
Route::get('/events', 'Kiosk\EventsController@index')->name('events.index');

# Auth
Route::get('/login', 'Auth\LoginController@showLoginForm')->name('auth.login.show');
Route::post('/login', 'Auth\LoginController@login')->name('auth.login.attempt');
Route::match(['POST', 'GET'], '/logout', 'Auth\LoginController@logout')->name('auth.logout.attempt');
Route::get('/password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('auth.password-reset-request.show');
Route::post('/password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('auth.password-reset-request.attempt');
Route::get('/password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('auth.password-reset.show');
Route::post('/password/reset', 'Auth\ResetPasswordController@reset')->name('auth.password-reset.attempt');

/*
|--------------------------------------------------------------------------
| Member Routes
|--------------------------------------------------------------------------
|
| These are used by club members with active accounts
|
*/

# Profile
Route::get('/members/{userId}', 'Members\ProfileController@showProfile');

# Scores
Route::get('/members/{userId}/scores', 'Members\ScoreController@showMemberScores');
Route::post('/members/{userId}/scores', 'Members\ScoreController@submitScore');

# Events
//Route::get('/events');
//Route::get('/events/{eventId}');
//Route::post('/events/{eventId}/register');

/*
|--------------------------------------------------------------------------
| Committee Routes
|--------------------------------------------------------------------------
|
| These are used by those with access to the admin tools only
|
*/

# Dashboard
Route::get('/admin', 'Admin\DashboardController@showDashboard')->name('admin.index');

# Users (Including members)
Route::resource('admin/users', 'Admin\UsersController', [
    'names'  => [
        'index'   => 'admin.users.index',
        'create'  => 'admin.users.create',
        'store'   => 'admin.users.store',
        'show'    => 'admin.users.show',
        'edit'    => 'admin.users.edit',
        'update'  => 'admin.users.update',
        'destroy' => 'admin.users.destroy',
    ]
]);
Route::resource('admin/roles', 'Admin\RolesController', [
    'except' => ['show'],
    'names'  => [
        'index'   => 'admin.roles.index',
        'create'  => 'admin.roles.create',
        'store'   => 'admin.roles.store',
        'edit'    => 'admin.roles.edit',
        'update'  => 'admin.roles.update',
        'destroy' => 'admin.roles.destroy',
    ]
]);

# Scores
Route::resource('admin/scores', 'Admin\ScoresController', [
    'only'  => ['index', 'create', 'store'],
    'names' => [
        'index'   => 'admin.scores.index',
        'create'  => 'admin.scores.create',
        'store'   => 'admin.scores.store',
    ]
]);
Route::resource('admin/rounds', 'Admin\RoundsController', [
    'names'  => [
        'index'   => 'admin.rounds.index',
        'create'  => 'admin.rounds.create',
        'store'   => 'admin.rounds.store',
        'show'    => 'admin.rounds.show',
        'edit'    => 'admin.rounds.edit',
        'update'  => 'admin.rounds.update',
        'destroy' => 'admin.rounds.destroy',
    ]
]);

# Events
Route::resource('admin/events', 'Admin\EventsController', [
    'names' => [
        'index'   => 'admin.events.index',
        'create'  => 'admin.events.create',
        'store'   => 'admin.events.store',
        'show'    => 'admin.events.show',
        'edit'    => 'admin.events.edit',
        'update'  => 'admin.events.update',
        'destroy' => 'admin.events.destroy',
    ]
]);
Route::resource('admin/event-types', 'Admin\EventTypesController', [
    'names' => [
        'index'   => 'admin.event-types.index',
        'create'  => 'admin.event-types.create',
        'store'   => 'admin.event-types.store',
        'show'    => 'admin.event-types.show',
        'edit'    => 'admin.event-types.edit',
        'update'  => 'admin.event-types.update',
        'destroy' => 'admin.event-types.destroy',
    ]
]);
Route::resource('admin/event-invites', 'Admin\EventInvitesController', [
    'names' => [
        'index'   => 'admin.event-invites.index',
        'create'  => 'admin.event-invites.create',
        'store'   => 'admin.event-invites.store',
        'show'    => 'admin.event-invites.show',
        'edit'    => 'admin.event-invites.edit',
        'update'  => 'admin.event-invites.update',
        'destroy' => 'admin.event-invites.destroy',
    ]
]);