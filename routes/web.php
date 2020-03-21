<?php
/**
  *-------------------------------------------------------------------------------------
  * Developer Information
  *-------------------------------------------------------------------------------------
  * @author Isaac Daniel Batista <daniel@danielbat.com>
  * @link https://danielbat.com Web Autor's site
  * @see https://twitter.com/codeisaac <@codeisaac>
  * @copyright 2019
  * @version 1.0.0
  * @package App\
  * Type: Router
  * Description: Description
  *
  * For the full copyright and license information, please view the LICENSE
  * file that was distributed with this source code.
  */
        
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
Route::post('contacto', 'HomeController@formContact')->name('form.contact');
Route::get('newsletter-detalle-noticia', 'NewsletterController@showNew')->name('newsletter.shownew');

Route::get('api/v2/clientes/antiguas', 'CompanyController@getOldCompanies');


Auth::routes();

Route::group(['prefix' => '{company}', 'middleware' => ['auth', 'role:client']], function () {
    Route::get('dashboard', 'ClientController@index')->name('news');
    Route::get('primeras-planas', 'ClientController@primeras')->name('primeras');
    Route::get('columnas-financieras', 'ClientController@financieras')->name('financieras');
    Route::get('columnas-politicas', 'ClientController@politicas')->name('politicas');
    Route::get('portadas-financieras', 'ClientController@portadas')->name('portadas');
    Route::get('cartones', 'ClientController@cartones')->name('cartones');
    Route::get('noticia/{id}', 'ClientController@showNew')->name('client.shownew');

    Route::get('mis-temas', 'ClientController@themes')->name('themes');
    Route::post('news-by-theme', 'ClientController@newsByTheme')->name('newsbytheme');
    Route::get('search', 'ClientController@search')->name('search');


});


Route::group(['prefix' => 'panel', 'middleware' => ['auth', 'role:admin|monitor|manager'],], function () {
    
    Route::get('/', 'AdminController@index')->name('panel');

    Route::get('usuarios', 'UserController@index')->name('users');
    Route::get('usuario/nuevo', 'UserController@showFormNewUser')->name('register.user');
    Route::post('usuario/nuevo', 'UserController@register')->name('register.user');
    Route::get('usuario/nuevo/{companyId}', 'UserController@addUserCompany')->name('user.add.company');
    Route::get('usuario/show/{id}', 'UserController@show')->name('user.show');
    Route::get('usuario/editar/{id}', 'UserController@edit')->name('user.edit');
    Route::post('usuario/editar/{id}', 'UserController@update')->name('edit.user');
    Route::get('usuario/borrar/{id}', 'UserController@delete')->name('user.delete');

    Route::get('empresas', 'CompanyController@index')->name('companies');
    Route::get('empresa/nuevo', 'CompanyController@showFormNewCompany')->name('company.create');
    Route::post('empresa/nuevo', 'CompanyController@create')->name('company.create');
    Route::get('empresa/ver/{id}', 'CompanyController@show')->name('company.show');
    Route::post('empresa/relacionar', 'CompanyController@relations')->name('company.relation');
    Route::post('empresa/remover-usuario/{id}', 'CompanyController@removeUser')->name('company.remove.user');
    Route::post('empresa/agregar-usuario-ajax', 'CompanyController@addUserAjax')->name('company.add.user.ajax');

    Route::get('fuentes', 'SourceController@index')->name('sources');
    Route::get('fuente/nueva', 'SourceController@showForm')->name('source.create');
    
    Route::post('tema/nuevo', 'ThemeController@create')->name('theme.create');
    Route::get('tema/ver/{id}', 'ThemeController@show')->name('theme.show');
    Route::post('tema/actualizar/{id}', 'ThemeController@update')->name('theme.update');
    Route::post('tema/eliminar/{id}', 'ThemeController@delete')->name('theme.delete');
    
    Route::post('giro/nuevo', 'TurnController@create')->name('turn.create');

    Route::get('newsletters', 'NewsletterController@index')->name('newsletters');
    Route::get('newsletter/crear', 'NewsletterController@showFormCreateNewsletter')->name('newsletter.create');
    Route::post('newsletter/crear', 'NewsletterController@create')->name('newsletter.create');

});
