<?php

use Illuminate\Support\Facades\Route;

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

Route::view('/', 'home')->name('home');

Route::get('/generate_reports_bd', 'ReportController@generate_reports_bd');

Route::view('quienes-somos', 'aboutus')->name('about');
Route::view('clientes', 'clients')->name('clients');
Route::view('contacto', 'contact')->name('contact');
Route::view('cuenta', 'signin')->name('signin');

Route::post('contacto', 'HomeController@formContact')->name('form.contact');
Route::get('newsletter-detalle-noticia', 'NewsletterController@showNew')->name('newsletter.shownew');
Route::get('detalle-noticia', 'NewsController@showDetailNews')->name('front.detail.news');
Route::get('cambio-empresa', 'HomeController@changeCompany');

Route::get('reportes/exportar', 'ReportController@export')->name('admin.report.export');
Route::get('reportes/exportar-pdf', 'ReportController@exportPDF')->name('admin.report_pdf.export');

Route::get('vista-newsletter', 'NewsletterSendController@seeNewsletter')->name('front.newsletter.see');

Route::post('api/v2/fuentes/obtener-fuentes', 'SourceController@sendSelectHTMLWithSourcesByMeanType')
    ->name('api.getsourceshtml');
Route::post('api/v2/fuentes/obtener-una-fuente', 'SourceController@getSourceByAjax')->name('api.getsourceajax');

Auth::routes([
    'register' => false,
]);

Route::group(['prefix' => '{company:slug}', 'middleware' => ['auth', 'role:client|manager|admin']], function () {
    Route::get('dashboard', 'ClientController@index')->name('news');
    Route::get('otras-secciones', 'ClientController@getCovers')->name('client.sections');
    Route::get('noticia/{id}', 'ClientController@showNew')->name('client.shownew');
    Route::get('mis-noticias', 'ClientController@myNews')->name('client.mynews');
    Route::post('news-by-theme', 'ClientController@newsByTheme')->name('newsbytheme');
    Route::get('search', 'ClientController@search')->name('search');
    Route::get('reporte', 'ClientController@report')->name('client.report');
    Route::post('reporte', 'ClientController@createReport')->name('client.report');
    Route::get('reporte-grafico', 'ClientController@reporteGrafico')->name('client.reporte_grafico');
    Route::get('reportes/solicitados', 'ReportController@solicitados')->name('client.report.solicitados');
    Route::post('reportes/cambiaEstatus', 'ReportController@cambiaEstatus')->name('client.report.cambia_estatus_reporte');

    Route::get('api/v2/cliente/notas-por-dia', 'ClientController@notesPerDay')->name('api.client.notesday');
    Route::get('api/v2/cliente/notas-por-anio', 'ClientController@notesPerYear')->name('api.client.notesyear');
});


Route::group(['prefix' => 'panel', 'middleware' => ['auth', 'role:admin|monitor|manager'],], function () {
    Route::group(['middleware' => ['can:view menu']], function () {
        Route::get('/', 'AdminController@index')->name('panel');

        Route::get('usuarios', 'UserController@index')->name('users');
        Route::get('usuario/nuevo', 'UserController@showFormNewUser')->name('register.user');
        Route::post('usuario/nuevo', 'UserController@register')->name('register.user');
        Route::get('usuario/nuevo/{companyId}', 'UserController@addUserCompany')->name('user.add.company');
        Route::get('usuario/borrar/{id}', 'UserController@delete')->name('admin.user.delete');
        Route::get('usuario/borrar-definitivo/{id}', 'UserController@forceDelete')->name('admin.user.forcedelete');
        Route::post('usuario/agregar/empresa', 'UserController@addCompanyToExecutive')
            ->name('admin.executive.add.company');
        Route::post('usuario/remover/empresa', 'UserController@removeCAssigned')
            ->name('admin.executive.remove.company');

        Route::get('empresas', 'CompanyController@index')->name('companies');
        Route::get('empresa/ver/{company:id}', 'CompanyController@show')->name('company.show');
        Route::get('empresa/nuevo', 'CompanyController@showFormNewCompany')->name('company.create');
        Route::post('empresa/nuevo', 'CompanyController@create')->name('company.create');
        Route::post('empresa/remover-usuario/{id}', 'CompanyController@removeUser')->name('company.remove.user');
        Route::post('empresa/agregar-usuario-ajax', 'CompanyController@addUserAjax')->name('company.add.user.ajax');
        Route::post('empresa/agregar/usarios-empresa', 'CompanyController@addAccountsToCompany')
            ->name('admin.company.add.accounts');
        Route::post('empresa/actualizar/logo/{id}', 'CompanyController@updateLogo')->name('company.update.logo');
        Route::post('empresa/editar/{id}', 'CompanyController@update')->name('company.update');
        Route::post('empresa/eliminar/{id}', 'CompanyController@delete')->name('admin.company.delete');
        Route::post('empresa/actualizar/nota/theme/{id}', 'CompanyController@updateAssignedNote')
            ->name('admin.assignednews.replacetheme');

        Route::post('tema/nuevo', 'ThemeController@create')->name('theme.create');
        Route::get('tema/ver/{theme:id}', 'ThemeController@show')->name('theme.show');
        Route::post('tema/actualizar/{id}', 'ThemeController@update')->name('theme.update');
        Route::post('tema/eliminar/{id}', 'ThemeController@delete')->name('theme.delete');
        Route::post('tema/relacionar-usuario', 'ThemeController@themeUser')->name('admin.theme.relationship.user');
        Route::post('tema/remover-usuario/{id}', 'ThemeController@themeUserRemove')->name('admin.theme.remove.user');

        Route::get('giros', 'TurnController@index')->name('admin.turns');
        Route::get('giros/nuevo', 'TurnController@create')->name('admin.turns.create');
        Route::post('giros/nuevo', 'TurnController@store')->name('admin.turns.store');
        Route::post('giros/ajax-nuevo', 'TurnController@ajaxCreate')->name('admin.turns.ajaxcreate');
        Route::get('giros/editar/{id}', 'TurnController@edit')->name('admin.turns.edit');
        Route::post('giros/editar/{id}', 'TurnController@update')->name('admin.turns.update');
        Route::post('giros/eliminar/{id}', 'TurnController@destroy')->name('admin.turns.destroy');

        Route::post('api/v2/noticias/obtener-notas', 'NewsController@searchByIdOrTitleAjax')
            ->name('api.news.getnotesbyidortitle');
        Route::post('api/v2/newsletter/newsletter-a-enviar/agregar-nota', 'NewsletterSendController@addNote')
            ->name('api.newslettersend.addnote');
        Route::post('api/v2/newsletter/newsletter-a-enviar/remover-nota', 'NewsletterSendController@remove')
            ->name('admin.newsletter.send.remove.note');

        Route::get('sectores', 'SectorController@index')->name('admin.sectors');
        Route::get('sector/nuevo', 'SectorController@create')->name('admin.sector.create');
        Route::post('sector/nuevo', 'SectorController@store')->name('admin.sector.store');
        Route::get('sector/editar/{id}', 'SectorController@edit')->name('admin.sector.edit');
        Route::post('sector/editar/{id}', 'SectorController@update')->name('admin.sector.update');
        Route::post('sector/eliminar/{id}', 'SectorController@destroy')->name('admin.sector.destroy');

        // Manager role enters as a client
        Route::get('redirect-to-client', 'AdminController@redirectTo')->name('admin.admin.redirectto');

        Route::get('reportes/por-cliente', 'ReportController@byClient')->name('admin.report.byclient');
        Route::get('reportes/por-notas', 'ReportController@byNotes')->name('admin.report.bynotes');

        Route::get('reportes/solicitados', 'ReportController@solicitados')->name('admin.report.solicitados');
        Route::post('reportes/cambiaEstatus', 'ReportController@cambiaEstatus')->name('admin.report.cambia_estatus_reporte');
    });

    Route::get('usuario/show/{id}', 'UserController@show')->name('user.show');
    Route::get('usuario/editar/{id}', 'UserController@edit')->name('admin.user.edit');
    Route::post('usuario/editar/{id}', 'UserController@update')->name('admin.edit.user');
    Route::get('usuario/restaurar/{id}', 'UserController@restore')->name('admin.user.restore');

    Route::get('administrador-archivos', 'FileManagerController@index')->name('filemanager');
    Route::get('administrador-archivos/directorios', 'FileManagerController@getDirectoriesS3');
    Route::post('administrador-archivos/nueva-carpeta', 'FolderController@create')->name('cfm.create.folder');
    Route::get('global-search', 'AdminController@search')->name('global.search');

    Route::get('fuentes', 'SourceController@index')->name('sources');
    Route::get('fuente/nueva', 'SourceController@showForm')->name('source.create');
    Route::post('fuente/nueva', 'SourceController@create')->name('source.create');
    Route::post('fuente/actualizar/{id}', 'SourceController@update')->name('source.update');
    Route::post('fuente/actualizar/logo/{id}', 'SourceController@updateLogo')->name('source.update.logo');
    Route::get('fuente/ver/{id}', 'SourceController@show')->name('source.show');
    Route::post('fuente/eliminar/{id}', 'SourceController@delete')->name('source.delete');
    Route::post('fuente/estatus/{id}', 'SourceController@status')->name('source.status');

    Route::post('seccion/nueva', 'SectionController@create')->name('section.create');
    Route::get('seccion/actualizar/{id}', 'SectionController@editForm')->name('section.edit');
    Route::post('seccion/actualizar/{id}', 'SectionController@update')->name('section.edit');
    Route::post('seccion/eliminar/{id}', 'SectionController@delete')->name('section.delete');
    Route::post('seccion/estatus/{id}', 'SectionController@status')->name('section.status');

    Route::get('noticias', 'NewsController@index')->name('admin.news');
    Route::get('noticias/nueva', 'NewsController@showForm')->name('admin.new.add');
    Route::post('noticias/nueva', 'NewsController@create')->name('admin.new.add');
    Route::get('noticias/ver/{id}', 'NewsController@show')->name('admin.new.show');
    Route::get('noticias/editar/{id}', 'NewsController@edit')->name('admin.new.edit');
    Route::post('noticias/editar/{id}', 'NewsController@update')->name('admin.new.edit');
    Route::post('noticias/asignar/{id}', 'NewsController@toAssign')->name('admin.new.notice.toassign');
    Route::post('noticias/remover/{id}', 'NewsController@toremovenews')->name('admin.assignednews.remove');
    Route::get('noticias/ver/adjuntos/{id}', 'NewsController@adjuntos')->name('admin.new.adjunto.show');
    Route::post('noticias/ver/adjuntos/subir/{id}', 'NewsController@adjuntosUpload')->name('admin.new.adjunto.upload');
    Route::get('noticias/ver/adjunto/asignar-primario', 'NewsController@assignMainFileForNews')
        ->name('admin.new.adjunto.main');
    Route::post('noticias/ver/adjunto/eliminar', 'NewsController@removeFile')->name('admin.new.adjunto.remove');
    Route::get('noticias/ver/newsletters/{id}', 'NewsController@showNewsletters')->name('admin.new.newletter.show');
    Route::post('noticias/ver/newsletters/incluir/{id}', 'NewsController@includeToNewsletters')
        ->name('admin.new.newletter.include');
    Route::post('noticias/ver/newsletters/remover/{id}', 'NewsController@removeNewsletter')
        ->name('admin.new.newletter.remove');
    Route::get('noticias/ver/notificacion/{id}', 'NewsController@notice')->name('admin.new.notice.show');
    Route::post('noticias/enviar-noticia', 'NewsController@sendNews')->name('admin.new.send.news');

    Route::get('newsletters', 'NewsletterController@index')->name('admin.newsletters');
    Route::get('newsletter/crear', 'NewsletterController@showFormCreateNewsletter')->name('admin.newsletter.create');
    Route::post('newsletter/crear', 'NewsletterController@create')->name('admin.newsletter.create');
    Route::get('newsletter/ver/{id}', 'NewsletterController@view')->name('admin.newsletter.view');
    Route::get('newsletter/config/{id}', 'NewsletterController@config')->name('admin.newsletter.config');
    Route::post('newsletter/remover/{id}', 'NewsletterController@remove')->name('admin.newsletter.remove');
    Route::post('newsletter/update/banner/{id}', 'NewsletterController@updateBanner')
        ->name('admin.newsletter.update.banner');
    Route::post('newsletter/estatus/{id}', 'NewsletterController@status')->name('admin.newsletter.status');
    Route::post('newsletter/nueva-plantilla/{id}', 'NewsletterSendController@create')
        ->name('admin.newsletter.newforsend');
    Route::get('newsletter/newsletter-a-enviar/editar/{id}', 'NewsletterSendController@edit')
        ->name('admin.newsletter.edit.send');
    Route::post('newsletter/newsletter-a-enviar/editar-etiqueta/{id}', 'NewsletterSendController@editLabel')
        ->name('admin.newsletter.edit.label.send');
    Route::get('newsletter/newsletter-a-enviar/vista-previa/{newsletterSend}', 'NewsletterSendController@previewEmail')
        ->name('admin.newsletter.preview.send');
    Route::post('newsletter/newsletter-a-enviar/enviar/{sendid}', 'NewsletterController@sendMail')
        ->name('admin.newsletter.send');
    Route::post('newsletter/newsletter-a-enviar/eliminar/{sendid}', 'NewsletterController@removeNewsletterSend')
        ->name('admin.newsletter.delete');

    Route::post('newsletter/config/agregar/cuentas', 'NewsletterUserController@addAccounts')
        ->name('admin.newsletter.config.addemails');
    Route::post('newsletter/config/remover/email', 'NewsletterUserController@removeEmail')
        ->name('admin.newsletter.config.removeemails');
    Route::post('newsletter/config/actualizar/plantilla', 'NewsletterController@updateTemplate')
        ->name('admin.newsletter.config.updatetemplate');
    Route::get('newsletter/config/agregar/portadas', 'NewsletterController@addCovers')
        ->name('admin.newsletter.config.footer');
    Route::post('newsletter/config/agregar/portadas', 'NewsletterFooterController@addCovers')
        ->name('admin.newsletter.config.add.footer');
    Route::post('newsletter/config/borrar/portadas-actuales/{id}', 'NewsletterFooterController@deleteCovers')
        ->name('admin.newsletter.config.delete.footer');

    Route::get('prensa/ver/portadas', 'CoverController@index')->name('admin.press.show');
    Route::get('prensa/nueva-portada', 'CoverController@create')->name('admin.press.add');
    Route::post('prensa/nueva-portada', 'CoverController@store')->name('admin.press.add');
    Route::get('prensa/editar/portada/{id}', 'CoverController@edit')->name('admin.press.edit');
    Route::post('prensa/editar/portada/{id}', 'CoverController@update')->name('admin.press.update');
    Route::post('prensa/editar/portada/{id}/archivo', 'CoverController@updateFile')->name('admin.press.update.file');
    Route::post('prensa/eliminar/portada/{id}', 'CoverController@destroy')->name('admin.press.destroy');

    Route::post('api/v2/secciones/obtener-secciones', 'SectionController@sendSelectHTMLWithSctionsBySource')
        ->name('api.getsectionshtml');
    Route::post('api/v2/newsletters/obtener-temas', 'NewsletterController@sendSelectHTMLWithThemes')
        ->name('api.getnewsletterthemeshtml');
    Route::post('api/v2/newsletters/obtener-activos', 'NewsletterController@sendSelectHTMLWithSends')
        ->name('api.getnewslettersendhtml');
    Route::post('api/v2/files/nuevo', 'FileController@uploadFile')->name('api.fileupload');
    Route::post('api/v2/files/borrar', 'FileController@removeFile')->name('api.fileremove');
    Route::post('api/v2/clientes/obtener-clientes-ajax', 'CompanyController@getCompaniesAjax')
        ->name('api.getcompaniesajax');
    Route::post('api/v2/cliente/obtener-temas', 'ThemeController@sendSelectHTMLWithThemesByCompany')
        ->name('api.getthemeshtml');
    Route::post('api/v2/cliente/obtener-cuentas', 'CompanyController@getAccountsAjax')->name('api.company.getaccounts');
    Route::post('api/v2/cliente/obtener-cuentas-para-agregar', 'CompanyController@getNotAccountsAjax')
        ->name('api.company.getnotaccounts');
    Route::post('api/v2/cliente/obtener-cuentas-tema', 'ThemeController@getAccountsAjax')
        ->name('api.theme.getaccounts');

    Route::get('api/v2/admin/notas-por-dia', 'AdminController@notesPerDay')->name('api.admin.notesday');
    Route::get('api/v2/admin/notas-por-medio', 'AdminController@notesPerMean')->name('api.admin.notesmeans');
});
