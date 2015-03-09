<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

// Guest
Route::group(['before' => 'guest'], function()
{
	// Login
    Route::get('/auth/login', 'AuthController@getLogin');
	Route::post('/auth/login', 'AuthController@postLogin');
	
	// Register
	Route::get('/auth/register', 'AuthController@getRegister');
	Route::post('/auth/register', 'AuthController@postRegister');
	
	// Password
	Route::controller('/auth/password', 'PasswordsController');
});

// Auth
Route::group(['before' => 'auth'], function()
{	
	// Users
    Route::get('/auth', 'AuthController@getIndex');
    Route::get('/auth/setting', 'AuthController@getIndex');
	Route::post('/auth/setting', 'AuthController@postIndex');
	
	// Account
	Route::resource('accounts', 'AccountsController');
	
	// Logout
    Route::get('/auth/logout', 'AuthController@getLogout');
});

// Home
Route::get('/', 'HomeController@showIndex');

// Error 404
App::missing(function($exception)
{
	// shows an error page (app/views/error.blade.php)
	// returns a page not found error
	return Response::view('error', [], 404);
});
