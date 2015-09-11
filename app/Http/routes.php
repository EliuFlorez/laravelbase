<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

// Home - Welcome
Route::get('/', 'WelcomeController@index');

// Home - Auth
Route::get('home', 'HomeController@index');

// Auth
Route::controllers([
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
]);

// Group - MiddleWare Auth
//Route::group(['prefix' => 'admin', 'middleware' => 'role:admin'], function()
Route::group(['prefix' => 'admin'], function()
{
    // Users
    Route::resource('users', 'UsersController');

    // Roles
    Route::any('api/roles', 'RolesController@anyUsers');
    Route::resource('roles', 'RolesController');

    // Permissions
    Route::any('api/permissions', 'PermissionsController@anyUsers');
    Route::resource('permissions', 'PermissionsController');
});