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

// Public content
# Information
Route::get('/', 'PublicPages\NewsController@home');
Route::get('/about', 'PublicPages\ClubController@about');
Route::get('/committee', 'PublicPages\ClubController@committee');
Route::get('/team', 'PublicPages\ClubController@team');
Route::get('/history', 'PublicPages\ClubController@history');
Route::get('/records', 'PublicPages\ClubController@records');
Route::get('/contact', 'PublicPages\ContactController@contact');

# Join
Route::get('/join', 'PublicPages\JoinController@showJoin');
Route::get('/join/taster', 'PublicPages\JoinController@showChooseTaster');
Route::post('/join/taster/reserve', 'PublicPages\JoinController@postCreateReservation');
Route::post('/join/taster/reserve/confirm', 'PublicPages\JoinController@postConfirmReservation');
Route::get('/join/taster/change/{attendeeId}', 'PublicPages\JoinController@showTasterBookingChangeForm');
Route::post('/join/taster/change/confirm', 'PublicPages\JoinController@postConfirmTasterBookingChange');

# Login
Route::get('/login', 'Auth\LoginController@showLoginForm');
Route::post('/login', 'Auth\LoginController@login');


// Members' content
# Profile
Route::get('/members/{userId}', 'Members\ProfileController@showProfile');

# Scores
Route::get('/members/{userId}/scores', 'Members\ScoreController@showMemberScores');
Route::post('/members/{userId}/scores', 'Members\ScoreController@submitScore');

# Events
Route::get('/events');
Route::get('/events/{eventId}');
Route::post('/events/{eventId}/register');

# News
//Route::get('/news', 'Members\NewsController@showArticles');
//Route::get('/news/article/{articleId}', 'Members\NewsController@showArticleDetails');
//Route::post('/news/article/{articleId}/comments', 'Members\NewsController@submitComment');

# Logout
Route::post('/logout', 'Auth\LoginController@logout');
Route::get('/logout', 'Auth\LoginController@logout');


// Committee content
Route::get('/admin', 'Admin\DashboardController@showDashboard');

# Users (Including members)
Route::resource('admin/users', 'Admin\UsersController');
Route::resource('admin/roles', 'Admin\RolesController');

# Events
Route::post('/admin/events');
Route::post('/admin/events/{eventId}');
Route::get('/admin/events');
Route::get('/admin/events/{eventId}');
Route::post('/admin/events/{eventId}/cancel');

# News
Route::post('/admin/articles', 'Admin\NewsController@publishArticle');
Route::post('/admin/articles/{articleId}', 'Admin\NewsController@editArticle');
Route::get('/admin/articles', 'Admin\NewsController@showArticles');
Route::get('/admin/articles/{articleId}', 'Admin\NewsController@showArticleDetails');
Route::post('/admin/articles/{articleId}/remove', 'Admin\NewsController@removeArticle');