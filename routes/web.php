<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();  // TODO: @route disable regirter route.

Route::group([
    'prefix' => 'admin', 
    'middleware' => ['auth', ],
], 
function () {
    Route::get('/', 'HomeController@index')->name('home');
    Route::get('users', 'UserController@index')->name('users');
    Route::get('user/add', 'UserController@create')->name('addUser');
    Route::get('roles', 'RoleController@index')->name('roles');
    Route::post('role/add', 'RoleController@create')->name('crateRole');
});

