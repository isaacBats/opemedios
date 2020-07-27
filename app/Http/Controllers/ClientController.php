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
  * @package App\Http\Controllers
  * Type: Class Controller
  * Description: ClientController
  *
  * For the full copyright and license information, please view the LICENSE
  * file that was distributed with this source code.
  */
        


namespace App\Http\Controllers;

use App\AssignedNews;
use App\Company;
use App\Cover;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\NewsController;
use App\News;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{
    protected $mediaController;

    protected $newsController;

    public function __construct(MediaController $mediaController, NewsController $newsController) {
        $this->mediaController = $mediaController;
        $this->newsController = $newsController;
    }

    public function index($slug_company) {  
        $company = Company::where('slug', $slug_company)->first();

        return view('clients.news', compact('company'));
    }

    public function previousNews(Request $request, $slug_company) {
        $company = Company::where('slug', $slug_company)->first();
        $assignedNews = DB::connection('opemediosold')->select('SELECT * FROM asigna WHERE id_empresa = ? ORDER BY id_noticia DESC LIMIT 200', [$company->old_company_id]);
        $idThemeAssigned = array_values(array_unique(array_map(function ($assign) {
            return $assign->id_tema;
        }, $assignedNews)));
        $lastFiveIdThemes = array_slice($idThemeAssigned, 0, 5);
        $themes = DB::connection('opemediosold')->table('tema')->whereIn('id_tema', $lastFiveIdThemes)->get();
        $newsAssigned = array_map(function ($theme) use ($idCompany) {
            
                $newsByTheme = DB::connection('opemediosold')->table('asigna')
                ->select('id_noticia')
                ->where([
                    ['id_empresa', '=',  $idCompany], 
                    ['id_tema', '=', $theme->id_tema],
                ])
                ->orderBy('id_noticia', 'desc')
                ->limit(7)
                ->get();

                $idNewsAssigned = array_map(function ($assignNew) {
                    return $assignNew->id_noticia;
                }, $newsByTheme->toArray());
            
                return array($theme->id_tema, DB::connection('opemediosold')->table('noticia')
                    ->join('fuente', 'noticia.id_fuente', '=', 'fuente.id_fuente')
                    ->whereIn('id_noticia', $idNewsAssigned)->get());

        }, $themes->toArray());
        $date = \Carbon\Carbon::now();
        $count = array();
        $count['total'] = DB::connection('opemediosold')->table('asigna')->where('id_empresa', $idCompany)->count();
        $count['month'] = DB::connection('opemediosold')->table('asigna')
            ->join('noticia', 'noticia.id_noticia', '=', 'asigna.id_noticia')
            ->where('id_empresa', $idCompany)
            ->whereRaw("date_format(noticia.fecha, '%Y-%m') = '{$date->format('Y-m')}'")->count();
        $count['day'] = DB::connection('opemediosold')->table('asigna')
            ->join('noticia', 'asigna.id_noticia', '=', 'noticia.id_noticia')
            ->where('id_empresa', $idCompany)
            ->where('noticia.fecha', $date->format('Y-m-d'))->count();
        
        return view('clients.oldnews', compact('company', 'newsAssigned', 'themes', 'count'));
    }

    public function showNew(Request $request, $slug_company, $newId) {

        // $new = $this->newsController->getNewById($newId);

        // $adjuntosHTML = DB::connection('opemediosold')->table('adjunto')
        //         ->where('id_noticia', $new->id_noticia)
        //         ->get()->map(function ($adj) use ($new) { 
                    
        //             $medio = strtolower($new->medio);
        //             if($medio == 'peri&oacute;dico' || $medio == 'periódico') {
        //                 $medio = 'periodico';
        //             } elseif ($medio == 'televisi&oacute;n' || $medio == 'Televisión') {
        //                 $medio = 'television';
        //             }
                    
        //             $path = "http://sistema.opemedios.com.mx/data/noticias/{$medio}/{$adj->nombre_archivo}"; 
                    
        //             return $adj->principal ? $this->mediaController->getHTMLForMedia($adj, $path)
        //                                     :"<a href='{$path}' download='{$adj->nombre}' target='_blank'>Descargar Archivo Secundario</a>"; 
        //         });

        // $metadata = $this->newsController->getMetaNew($new);
        $note = News::findOrFail($newId);
        $company = Company::where('slug', $slug_company)->first();
            

        return view('clients.shownew', compact('note', 'company'));
    }

    public function getCovers(Request $request, $slug_company) {
        $type = $request->get('type');
        $company = Company::where('slug', $slug_company)->first();
        $coverType = null;
        $template = '';
        $title = '';
        
        switch ($type) {
            case 'primeras':
                $coverType = 1;
                $template = 'clients.primeras';
                $title = 'Primeras Planas';
                break;
            case 'politicas':
                $coverType = 3;
                //Actualizar la vista de las columnas para poder verlas en la pag
                // Por el momento solo se mostrara el archivo
                // $template = 'clients.politicas'
                $template = 'clients.primeras';
                $title = 'Columnas Políticas';
                break;
            case 'financieras':
                $coverType = 4;
                // $template = 'clients.politicas'
                $template = 'clients.primeras';
                $title = 'Columnas Financieras';
                break;
            case 'portadas':
                $coverType = 2;
                $template = 'clients.primeras';
                $title = 'Portadas Financieras';
                break;
            case 'cartones':
                $coverType = 5;
                $template = 'clients.primeras';
                $title = 'Cartones';
                break;
        }
        $covers = Cover::whereDate('date_cover', Carbon::today()->format('Y-m-d'))
            ->where('cover_type', $coverType)->get();
        return view($template, compact('covers', 'company', 'title'));
    }

    public function themes (Request $request, $slug_company) {

        $company = Company::where('slug', $slug_company)->first();

        // $userMetaOldCompany = auth()->user()->metas()->where('meta_key', 'old_company_id')->first();
        // if($userMetaOldCompany) {
        //     $idCompany = $userMetaOldCompany->meta_value;
        // } else {
        //     $idCompany = $company->id;
        // }

        // $themes = DB::connection('opemediosold')->table('tema')->where('id_empresa', $idCompany)->get();
        
        $defaultThemeId = $company->themes->first()->id;
         $idsNewsAssigned = $company->assignedNews->where('theme_id', $defaultThemeId)->map(function($assigned) {
                return $assigned->news_id;
            });

            $news = News::whereIn('id', $idsNewsAssigned)
                ->orderBy('id', 'desc')
                ->paginate(15);

        // $news = $this->getNewsByTheme($defaultThemeId, $idCompany);

        return view('clients.themes', compact('news', 'company', 'defaultThemeId'));
    }

    protected function getNewsByTheme ($themeId, $idCompany) {
        return DB::connection('opemediosold')->table('asigna')
            ->select('noticia.encabezado', 'fuente.nombre', 'fuente.logo', 'noticia.fecha', 'noticia.autor', 'fuente.empresa', 'noticia.sintesis', 'noticia.id_noticia')
            ->join('noticia', 'asigna.id_noticia', '=', 'noticia.id_noticia')
            ->join('fuente', 'noticia.id_fuente', '=', 'fuente.id_fuente')
            ->where('id_empresa', $idCompany)
            ->where('id_tema', $themeId)
            ->orderBy('noticia.fecha', 'desc')
            ->paginate(15);
            // ->get();
    }

    public function newsByTheme(Request $request) {
        $data = $request->all();
        $news = $this->getNewsByTheme($data['themeid'], $data['companyid']);
        $company = Company::where('slug', $data['companyslug'])->first();
        $idCompany = $data['companyid'];
        $theme = $themes = DB::connection('opemediosold')->table('tema')->where('id_empresa', $idCompany)->where('id_tema', $data['themeid'])->first();
        // return response()->json($this->getNewsByTheme($data['themeid'], $data['companyid']));
        return view('components.listNews', compact('news', 'company', 'theme', 'idCompany'))->render();
    }

    public function search(Request $request, $slug_company) {
        $query = $request->query();
        $company = Company::where('slug', $slug_company)->first();
        
        if($request['last'] == 'noticias-pasadas'){

            if(is_null($company->old_company_id)){
                // regresar un mensaje de que la compañia no esta relacionada con una empresa vieja
            }

            $news = DB::connection('opemediosold')->table('noticia')
                ->select('noticia.encabezado', 'fuente.nombre', 'fuente.logo', 'noticia.fecha', 'noticia.autor', 'fuente.empresa', 'noticia.sintesis', 'noticia.id_noticia')
                ->join('fuente', 'noticia.id_fuente', '=', 'fuente.id_fuente')
                ->join('asigna', 'noticia.id_noticia', '=', 'asigna.id_noticia')
                ->where([
                    ['asigna.id_empresa', '=', $company->old_company_id],
                    ['noticia.encabezado', 'like', "%{$query['query']}%"]])
                ->orWhere('noticia.sintesis', 'like', "%{$query['query']}%")
                ->orderBy('fecha', 'desc')
                ->get();

            return view('components.listSearchOldNews', compact('news', 'company'))->render();
        } else {
            
            $idsNewsAssigned = $company->assignedNews->map(function($assigned) {
                return $assigned->news_id;
            });

            $news = News::whereIn('id', $idsNewsAssigned)
                    ->where('title', 'like', "%{$query['query']}%")
                    ->orWhere('synthesis', 'like', "%{$query['query']}%")
                    ->get();

            return view('components.listSearch', compact('news', 'company'))->render();
        }
    }
}
