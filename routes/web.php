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

# Login
Route::get('/login', 'Auth\LoginController@showLoginForm');
Route::post('/login', 'Auth\LoginController@login');

// Members' content
# Information
Route::get('/members/{userId}', 'Members\ProfileController@showProfile');
Route::get('/members/{userId}/scores', 'Members\ScoreController@showMemberScores');
Route::post('/members/{userId}/scores', 'Members\ScoreController@submitScore');
//Route::post('/news/article/{articleId}/comments', 'Members\NewsController@submitComment');

# Logout
Route::post('/logout', 'Auth\LoginController@logout');

// Committee content
# Members
Route::post('/admin/members', 'Admin\MemberController@registerMember');
Route::post('/admin/members/{memberId}', 'Admin\MemberController@modifyMemberDetails');
Route::get('/admin/members', 'Admin\MemberController@showMembers');
Route::get('/admin/members/{memberId}', 'Admin\MemberController@showMemberDetails');
Route::post('/admin/members/{memberId}/remove', 'Admin\MemberController@removeMember');

# News
Route::post('/admin/articles', 'Admin\NewsController@publishArticle');
Route::post('/admin/articles/{articleId}', 'Admin\NewsController@editArticle');
Route::get('/admin/articles', 'Admin\NewsController@showArticles');
Route::get('/admin/articles/{articleId}', 'Admin\NewsController@showArticleDetails');
Route::post('/admin/articles/{articleId}/remove', 'Admin\NewsController@removeArticle');