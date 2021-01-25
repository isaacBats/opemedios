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
use App\Exports\NewsExport;
use App\Genre;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\NewsController;
use App\Means;
use App\News;
use App\Sector;
use App\Theme;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

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
        $newsAssigned = DB::connection('opemediosold')->table('view_noticia_asignada')
            ->where('id_empresa', $company->old_company_id)
            ->paginate(15);
        return view('clients.oldnews', compact('company', 'newsAssigned'));
    }

    public function showNew(Request $request, $slug_company, $newId) {
        $company = Company::where('slug', $slug_company)->first();
        if($request->get('type') == 'old') {
            $new = $this->newsController->getNewById($newId);

            $adjuntosHTML = DB::connection('opemediosold')->table('adjunto')
                    ->where('id_noticia', $new->id_noticia)
                    ->get()->map(function ($adj) use ($new) { 
                        
                        $medio = strtolower($new->medio);
                        if($medio == 'peri&oacute;dico' || $medio == 'periódico') {
                            $medio = 'periodico';
                        } elseif ($medio == 'televisi&oacute;n' || $medio == 'Televisión') {
                            $medio = 'television';
                        }
                        
                        $path = "http://sistema.opemedios.com.mx/data/noticias/{$medio}/{$adj->nombre_archivo}"; 
                        
                        return $adj->principal ? $this->mediaController->getHTMLForMedia($adj, $path)
                                                :"<a href='{$path}' download='{$adj->nombre}' target='_blank'>Descargar Archivo Secundario</a>"; 
                    });

            $metadata = $this->newsController->getMetaNew($new);
            return view('clients.showoldnew', compact('new', 'metadata', 'adjuntosHTML', 'company'));
        } else {
            $note = News::findOrFail($newId);
            return view('clients.shownew', compact('note', 'company'));
        }

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

        $defaultThemeId = $company->themes->first()->id;
        $idsNewsAssigned = $company->assignedNews->where('theme_id', $defaultThemeId)->map(function($assigned) {
            return $assigned->news_id;
        });

            $news = News::whereIn('id', $idsNewsAssigned)
                ->orderBy('id', 'desc')
                ->paginate(15);


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

    public function newsByTheme(Request $request, $slug_company) {
        $data = $request->all();
        $company = Company::where('slug', $slug_company)->first();
        
        $idsNewsAssigned = $company->assignedNews->where('theme_id', $data['themeid'])->map(function($assigned) {
            return $assigned->news_id;
        });
        // TODO: error al buscar por paginas
        $theme = Theme::findOrFail($data['themeid']);
        $news = News::whereIn('id', $idsNewsAssigned)
            ->orderBy('id', 'desc')
            ->paginate(30);
            // ->appends(['companyid' => $company->id, 'themeid' => $theme->id, 'companyslug' => $company->slug]);

        return view('components.listNews', compact('news', 'company', 'theme'))->render();
    }

    public function search(Request $request, $slug_company) {
        $query = $request->query();
        $company = Company::where('slug', $slug_company)->first();
        
        if($request['last'] == 'otras-notas'){

            if(is_null($company->old_company_id)){
                // regresar un mensaje de que la compañia no esta relacionada con una empresa vieja
            }

            $newsAssigned = DB::connection('opemediosold')->table('view_noticia_asignada')
                ->where([
                    ['id_empresa', '=', $company->old_company_id],
                    ['title', 'like', "%{$query['query']}%"]])
                ->orWhere('sintesis', 'like', "%{$query['query']}%")
                ->orderBy('fecha', 'desc')
                ->paginate(15);

            return view('components.listOldNews', compact('newsAssigned', 'company'))->render();
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

    public function report (Request $request) {

        $sectors = Sector::all();
        $genres = Genre::all();
        $means = Means::all();

        return view('clients.report', compact('sectors', 'genres', 'means'));
    }

    public function createReport( Request $request ) {
        $date = Carbon::today()->timestamp;
        return Excel::download(new NewsExport($request->all()), "reporte_{$date}.xlsx");
    }
}
