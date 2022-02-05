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
use App\Traits\StadisticsNotes;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

use Illuminate\Support\Facades\URL;


class ClientController extends Controller
{

    use StadisticsNotes;

    protected $mediaController;

    protected $newsController;

    public function __construct(MediaController $mediaController, NewsController $newsController) {
        $this->mediaController = $mediaController;
        $this->newsController = $newsController;
    }

    public function index(Request $request, $company) {  
        $company = Company::where('slug', $company)->first();

        return view('clients.news', compact('company'));
    }

    public function showNew(Request $request, $slug_company, $newId) {
        $company = Company::where('slug', $slug_company)->first();
        
        $note = News::findOrFail($newId);
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

        $defaultThemeId = $company->themes->first()->id;
        $idsNewsAssigned = $company->assignedNews->where('theme_id', $defaultThemeId)->map(function($assigned) {
            return $assigned->news_id;
        });

            $news = News::whereIn('id', $idsNewsAssigned)
                ->orderBy('id', 'desc')
                ->paginate(15);


        return view('clients.themes', compact('news', 'company', 'defaultThemeId'));
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
            
        $idsNewsAssigned = $company->assignedNews->map(function($assigned) {
            return $assigned->news_id;
        });

        $news = News::whereIn('id', $idsNewsAssigned)
                ->where('title', 'like', "%{$query['query']}%")
                ->orWhere('synthesis', 'like', "%{$query['query']}%")
                ->orderBy('news_date', 'DESC')
                ->get();

        return view('components.listSearch', compact('news', 'company'))->render();
    }

    public function report (Request $request) {

        $paginate = 10;
        $company = Company::where('slug', $request->session()->get('slug_company'))->first();

        $notesIds = AssignedNews::query()->where('company_id', $company->id)
            ->when($request->input('theme_id') != null, function($q) use ($request) {
                return $q->where('theme_id', $request->input('theme_id'));
            })->pluck('news_id');
        $notes = News::query()->whereIn('id', $notesIds)
            ->when($request->input('sector') != null, function($q) use ($request) {
                return $q->where('sector_id', $request->input('sector'));
            })
            ->when($request->input('genre') != null, function($q) use ($request) {
                return $q->where('genre_id', $request->input('genre'));
            })
            ->when($request->input('mean') != null, function($q) use ($request) {
                return $q->where('mean_id', $request->input('mean'));
            })
            ->when($request->input('source_id') != null, function($q) use ($request) {
                return $q->where('source_id', $request->input('source_id'));
            })
            ->when(($request->input('fstart') != null && $request->input('fend') != null), function($q) use ($request){
                $from = Carbon::create($request->input('fstart'));
                $to = Carbon::create($request->input('fend'));
                return $q->whereBetween('news_date', [$from, $to]);
            })
            ->when(($request->input('fstart') != null && $request->input('fend') == null), function($q) use ($request){
                return $q->whereDate('news_date', Carbon::create($request->input('fstart')));
            })
            ->when($request->input('word') != null, function($q) use ($request) {
                return $q->where('title', 'like', "%{$request->input('word')}%")
                    ->orWhere('synthesis', 'like', "%{$request->input('word')}%");
            })
            ->orderBy('news_date', 'DESC')
            ->simplePaginate($paginate);
            
            $notes->setPath(URL::full());

        return view('clients.report', compact('notes', 'company'));

    }

    public function createReport( Request $request ) {
        $date = Carbon::today()->timestamp;
        return Excel::download(new NewsExport($request->all()), "reporte_{$date}.xlsx");
    }

    public function notesPerDay(Request $request, $company) {
        
        $data = $this->getNoteCountPerWeek('now', $company);

        return response()->json($data);
    }

    public function notesPerYear(Request $request, $company) {
        $data = $this->getNotesCountPerYear($company);

        return response()->json($data);
    }
}
