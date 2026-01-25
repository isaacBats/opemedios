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

use App\{Models\Company, Models\Cover, Models\News, Models\Theme};
use App\Exports\NewsExport;
use App\Filters\{AssignedNewsFilter, NewsFilter};
use App\Traits\StadisticsNotes;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{DB, URL};
use Maatwebsite\Excel\Facades\Excel;

class ClientController extends Controller
{

    use StadisticsNotes;

    /**
     * @var \App\Http\Controllers\MediaController
     */
    protected $mediaController;
    /**
     * @var \App\Http\Controllers\NewsController
     */
    protected $newsController;

    public function __construct(MediaController $mediaController, NewsController $newsController)
    {
        $this->mediaController = $mediaController;
        $this->newsController = $newsController;
    }

    public function index(Request $request, Company $company)
    {
        return view('clients.news', compact('company'));
    }

    public function showNew(Request $request, $slug_company, $newId)
    {
        $company = Company::where('slug', $slug_company)->firstOrFail();

        $note = News::findOrFail($newId);

        // Validación multi-tenant: verificar que la noticia esté asignada a esta compañía
        $isAssigned = $company->assignedNews()
            ->where('news_id', $note->id)
            ->exists();

        if (!$isAssigned) {
            abort(403, 'No tiene permiso para ver esta noticia.');
        }

        // Eager load relaciones necesarias para la vista
        $note->load(['source', 'mean', 'sector', 'genre', 'section', 'authorType', 'files']);

        return view('clients.shownew', compact('note', 'company'));
    }

    public function getCovers(Request $request, $slug_company)
    {
        $type = $request->get('type');
        $company = Company::where('slug', $slug_company)->firstOrFail();
        $coverType = null;
        $title = '';

        switch ($type) {
            case 'primeras':
                $coverType = 1;
                $title = 'Primeras Planas';
                break;
            case 'politicas':
                $coverType = 3;
                $title = 'Columnas Políticas';
                break;
            case 'financieras':
                $coverType = 4;
                $title = 'Columnas Financieras';
                break;
            case 'portadas':
                $coverType = 2;
                $title = 'Portadas Financieras';
                break;
            case 'cartones':
                $coverType = 5;
                $title = 'Cartones';
                break;
            default:
                abort(404, 'Tipo de sección no válido.');
        }

        // Eager load relationships to avoid N+1 queries
        $covers = Cover::with(['source', 'image'])
            ->whereDate('date_cover', Carbon::today()->format('Y-m-d'))
            ->where('cover_type', $coverType)
            ->orderBy('date_cover', 'desc')
            ->get();

        return view('clients.covers', compact('covers', 'company', 'title'));
    }

    public function myNews(Request $request, Company $company)
    {
        $pagination = null !== $request->input('pagination') ? $request->input('pagination') : 15 ;
        $notesIds = AssignedNewsFilter::filter($request, compact('company'))->pluck('news_id');
        $news = NewsFilter::filter($request, ['ids' => $notesIds])
            ->orderBy('news_date', 'DESC')
            ->paginate($pagination);
        session()->flashInput($request->input());

        return view('clients.mynews', compact('news', 'company'));
    }

    public function newsByTheme(Request $request, $slug_company)
    {
        $data = $request->all();
        $company = Company::where('slug', $slug_company)->first();

        $idsNewsAssigned = $company->assignedNews->where('theme_id', $data['themeid'])->map(function ($assigned) {
            return $assigned->news_id;
        });
        
        $theme = Theme::findOrFail($data['themeid']);
        $news = News::whereIn('id', $idsNewsAssigned)
            ->orderBy('id', 'desc')
            ->paginate(30);

        return view('components.listNews', compact('news', 'company', 'theme'))->render();
    }

    /**
     * Search of client
     *
     * @return view
     */
    public function search(Request $request, $slug_company)
    {
        $query = $request->query();
        $company = Company::where('slug', $slug_company)->first();

        $idsNewsAssigned = $company->assignedNews->map(function ($assigned) {
            return $assigned->news_id;
        });

        $news = News::whereIn('id', $idsNewsAssigned->all());
        $news->when(!empty($query['query']), function ($q) use ($query) {
            return $q->where('title', 'like', "%{$query['query']}%")
                ->orWhere('synthesis', 'like', "%{$query['query']}%")
                ->orderBy('news_date', 'DESC');
        });
        $news = $news->get();

        return view('components.listSearch', compact('news', 'company'))->render();
    }

    public function report(Request $request, Company $company)
    {

        $paginate = 25;

        if($request->input('start_date') !== null && $request->input('end_date') !== null)
        {
            $from = Carbon::create($request->input('start_date'));
            $to = Carbon::create($request->input('end_date'));
        }else{
            $from =  Carbon::now()->add('-10 days');
            $to =  Carbon::now();
        }

        $from_d = $from->format('Y-m-d');
        $to_d = $to->format('Y-m-d');

        $request->merge(['start_date' => $from_d]);
        $request->merge(['end_date' => $to_d]);

        $notesIds = AssignedNewsFilter::filter($request, compact('company'))->pluck('news_id');
        $notesIdsArray = AssignedNewsFilter::filter($request, compact('company'))->pluck('news_id')->toArray();

        $tendencias = NewsFilter::filter($request, ['ids' => $notesIds])
            ->select('trend', DB::raw('count(*) as total'))
            ->groupBy('trend')
            ->get();

        $medios = NewsFilter::filter($request, ['ids' => $notesIds])
            ->select('mean_id', DB::raw('count(*) as total'))
            ->groupBy('mean_id')
            ->get();

        $where = '';

        $json = '';
        $themes = null;
        $fechas = array();
        $data = array();
        if(count($notesIds) > 0)
        {
            $themes = DB::select("select themes.id, themes.name
                            from assigned_news
                            inner join news on assigned_news.news_id = news.id
                            inner join themes on assigned_news.theme_id = themes.id
                            where news.id in (" . str_replace(']', '', str_replace('[', '', $notesIds)) . ")
                            AND date(news.created_at) BETWEEN '". $from->format('Y-m-d') ."' AND '" . $to->format('Y-m-d') ."'
                            group by themes.id, themes.name
                            order by name desc");

            $period = CarbonPeriod::create($from, $to);

            foreach ($period as $date) {
                $dt = $date->format('Y-m-d');
                $where = " AND date(news.created_at) = '$dt'";
                $qry = DB::select("select date(news.created_at) as dt, themes.id, themes.name, count(*) as total
                                from assigned_news
                                inner join news on assigned_news.news_id = news.id
                                inner join themes on assigned_news.theme_id = themes.id
                                where news.id in (" . str_replace(']', '', str_replace('[', '', $notesIds)) . ")
                                " . $where . "
                                group by date(news.created_at), themes.id, themes.name
                                order by date(news.created_at) desc");

                $data[$date->format('Y-m-d')] = $qry;
                $fechas[] = $date->format('Y-m-d');
            }

            foreach ($themes as $theme)
            {
                $xcoma = '';
                $json .= '{';
                $json .= 'name: "' . $theme->name . '",';
                $json .= 'data:[';
                foreach ($fechas as $dt){
                    $dat_imp = '';
                    foreach ($data[$dt] as $dato_){
                        if($dato_->id == $theme->id)
                            $dat_imp = $dato_->total;
                    }
                    $json .= $xcoma . (empty($dat_imp) ? 0 : $dat_imp);
                    $xcoma = ',';
                }
                $json .= ']},';
            }
        }


        $notes = NewsFilter::filter($request, ['ids' => $notesIds])
            ->orderBy('news_date', 'DESC')
            ->simplePaginate($paginate);

        $notes->setPath(URL::full());

        return view('clients.report', compact('notes', 'company','tendencias','medios','themes','fechas','data','json', 'from_d', 'to_d'));
    }

    public function createReport(Request $request)
    {
        $date = Carbon::today()->timestamp;
        return Excel::create(new NewsExport($request->all()), "reporte_{$date}.xlsx")->export('pdf');
    }

    public function notesPerDay(Request $request, $company)
    {

        $data = $this->getNoteCountPerWeek('now', $company);

        return response()->json($data);
    }

    public function notesPerYear(Request $request, $company)
    {
        $data = $this->getNotesCountPerYear($company);

        return response()->json($data);
    }
}
