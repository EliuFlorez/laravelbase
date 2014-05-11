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

// Account
Route::controller('account', 'AccountController' );

// Guest
Route::group(['before' => 'guest'], function()
{
	// Login
    Route::get('/login', [
        'as'   => 'account/login',
        'uses' => 'AccountController@getLogin'
    ]);
	
	Route::post('/login', [
        'as'   => 'account/login',
        'uses' => 'AccountController@postLogin'
    ]);
	
	// Signup
	Route::get('/register', [
        'as'   => 'account/register',
        'uses' => 'AccountController@getRegister'
    ]);
	
	Route::post('/register', [
        'as'   => 'account/register',
        'uses' => 'AccountController@postRegister'
    ]);
	
	// Activate account
	Route::get('account/activate/{code}', [
		'as'   => 'account/activate',
		'uses' => 'AccountController@getActivate'
	]);
	
	// Password
	Route::controller('password', 'RemindersController');
	
});

// Auth
Route::group(['before' => 'auth'], function()
{	
	// Account
    Route::get('/account', [
        'as'   => 'account/index',
        'uses' => 'AccountController@getIndex'
    ]);
	
	Route::post('/account/setting', [
        'as'   => 'account/setting',
        'uses' => 'AccountController@postIndex'
    ]);
	
	// Logout
    Route::get('logout', [
        'as'   => 'account/logout',
        'uses' => 'AccountController@getLogout'
    ]);
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
