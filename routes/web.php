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

Route::get('/', 'HomeController@index')->name('home');
Route::get('quienes-somos', 'HomeController@about')->name('about');
Route::get('clientes', 'HomeController@clients')->name('clients');
Route::get('contacto', 'HomeController@contact')->name('contact');
Route::get('cuenta', 'HomeController@signin')->name('signin');


Auth::routes();

Route::group(['prefix' => '{company}', 'middleware' => ['auth', 'role:client']], function () {
    Route::get('dashboard', 'ClientController@index')->name('news');

});


Route::group(['prefix' => 'panel', 'middleware' => ['auth', 'role:admin|monitor|manager'],], function () {
    
    Route::get('/', 'AdminController@index')->name('panel');

    Route::get('usuarios', 'UserController@index')->name('users');
    Route::get('usuario/nuevo', 'UserController@showFormNewUser')->name('register.user');
    Route::post('usuario/crear', 'UserController@register')->name('register.user');
    Route::get('usuario/editar/{id}', 'UserController@edit')->name('edit.user');
    Route::post('usuario/editar/{id}', 'UserController@update')->name('edit.user');
    Route::post('usuario/borrar/{id}', 'UserController@delete')->name('delete.user');

    Route::get('empresas', 'CompanyController@index')->name('companies');
    Route::get('empresa/nuevo', 'CompanyController@showFormNewCompany')->name('company.create');
    Route::post('empresa/nuevo', 'CompanyController@create')->name('company.create');
    
    Route::get('giro/nuevo', 'TurnController@showFormNewTurn')->name('turn.create');

});
