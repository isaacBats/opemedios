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

use App\{Models\Company, Models\Cover, Models\ListReport, Models\News, Models\Theme};
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
        // Seguridad multi-tenant: verificar que el usuario tiene acceso a esta compañía
        $user = auth()->user();
        $userCompanyId = $user->metas()->where('meta_key', 'company_id')->first()?->meta_value;

        // Si es cliente, verificar que la compañía del slug coincide con la del usuario
        if ($user->isClient() && $userCompanyId != $company->id) {
            abort(403, 'No tiene permiso para acceder a este dashboard.');
        }

        // Métricas del dashboard
        $today = Carbon::today();
        $startOfMonth = Carbon::now()->startOfMonth();
        $startOfYear = Carbon::now()->startOfYear();

        // Conteos de noticias
        $newsToday = $company->assignedNews()
            ->whereDate('created_at', $today)
            ->count();

        $newsThisMonth = $company->assignedNews()
            ->where('created_at', '>=', $startOfMonth)
            ->count();

        $newsThisYear = $company->assignedNews()
            ->where('created_at', '>=', $startOfYear)
            ->count();

        $newsTotal = $company->assignedNews()->count();

        // Distribución por tipo de medio
        $newsByMean = DB::table('assigned_news')
            ->join('news', 'assigned_news.news_id', '=', 'news.id')
            ->join('means', 'news.mean_id', '=', 'means.id')
            ->where('assigned_news.company_id', $company->id)
            ->whereDate('assigned_news.created_at', '>=', $startOfMonth)
            ->select('means.name', 'means.short_name', DB::raw('count(*) as total'))
            ->groupBy('means.id', 'means.name', 'means.short_name')
            ->orderBy('total', 'desc')
            ->get();

        // Temas de la compañía con conteo de noticias
        $themesWithCount = DB::table('assigned_news')
            ->join('themes', 'assigned_news.theme_id', '=', 'themes.id')
            ->where('assigned_news.company_id', $company->id)
            ->whereDate('assigned_news.created_at', '>=', $startOfMonth)
            ->select('themes.id', 'themes.name', DB::raw('count(*) as total'))
            ->groupBy('themes.id', 'themes.name')
            ->orderBy('total', 'desc')
            ->limit(10)
            ->get();

        // Últimas 5 noticias
        $recentNews = News::whereIn('id', function ($query) use ($company) {
                $query->select('news_id')
                    ->from('assigned_news')
                    ->where('company_id', $company->id);
            })
            ->with(['source', 'mean'])
            ->orderBy('news_date', 'desc')
            ->limit(5)
            ->get();

        // Tendencia de noticias (positivas, neutrales, negativas) del mes
        $trendStats = DB::table('assigned_news')
            ->join('news', 'assigned_news.news_id', '=', 'news.id')
            ->where('assigned_news.company_id', $company->id)
            ->whereDate('assigned_news.created_at', '>=', $startOfMonth)
            ->select('news.trend', DB::raw('count(*) as total'))
            ->groupBy('news.trend')
            ->get()
            ->keyBy('trend');

        // Últimos 3 reportes del usuario
        $recentReports = ListReport::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();

        return view('clients.dashboard', compact(
            'company',
            'newsToday',
            'newsThisMonth',
            'newsThisYear',
            'newsTotal',
            'newsByMean',
            'themesWithCount',
            'recentNews',
            'trendStats',
            'recentReports'
        ));
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
        // Seguridad multi-tenant: verificar acceso a la compañía
        $user = auth()->user();
        $userCompanyId = $user->metas()->where('meta_key', 'company_id')->first()?->meta_value;

        if ($user->isClient() && $userCompanyId != $company->id) {
            abort(403, 'No tiene permiso para acceder a los reportes de esta empresa.');
        }

        $paginate = 25;

        // Configurar rango de fechas
        if ($request->input('start_date') !== null && $request->input('end_date') !== null) {
            $from = Carbon::create($request->input('start_date'));
            $to = Carbon::create($request->input('end_date'));
        } else {
            $from = Carbon::now()->subDays(10);
            $to = Carbon::now();
        }

        $from_d = $from->format('Y-m-d');
        $to_d = $to->format('Y-m-d');

        $request->merge(['start_date' => $from_d, 'end_date' => $to_d]);

        // Obtener IDs de noticias asignadas (una sola vez)
        $notesIds = AssignedNewsFilter::filter($request, compact('company'))->pluck('news_id');

        // Estadísticas de tendencias
        $tendencias = NewsFilter::filter($request, ['ids' => $notesIds])
            ->select('trend', DB::raw('count(*) as total'))
            ->groupBy('trend')
            ->get();

        // Estadísticas por medio
        $medios = NewsFilter::filter($request, ['ids' => $notesIds])
            ->select('mean_id', DB::raw('count(*) as total'))
            ->groupBy('mean_id')
            ->get();

        // Datos para gráficos
        $json = '';
        $themes = collect();
        $fechas = [];
        $data = [];

        if ($notesIds->isNotEmpty()) {
            // Obtener temas usando Query Builder seguro (sin SQL raw con interpolación)
            $themes = DB::table('assigned_news')
                ->join('news', 'assigned_news.news_id', '=', 'news.id')
                ->join('themes', 'assigned_news.theme_id', '=', 'themes.id')
                ->whereIn('news.id', $notesIds)
                ->whereBetween(DB::raw('date(news.created_at)'), [$from_d, $to_d])
                ->select('themes.id', 'themes.name')
                ->groupBy('themes.id', 'themes.name')
                ->orderBy('themes.name', 'desc')
                ->get();

            $period = CarbonPeriod::create($from, $to);

            foreach ($period as $date) {
                $dt = $date->format('Y-m-d');
                $fechas[] = $dt;

                // Query segura por fecha
                $qry = DB::table('assigned_news')
                    ->join('news', 'assigned_news.news_id', '=', 'news.id')
                    ->join('themes', 'assigned_news.theme_id', '=', 'themes.id')
                    ->whereIn('news.id', $notesIds)
                    ->whereDate('news.created_at', $dt)
                    ->select(
                        DB::raw('date(news.created_at) as dt'),
                        'themes.id',
                        'themes.name',
                        DB::raw('count(*) as total')
                    )
                    ->groupBy(DB::raw('date(news.created_at)'), 'themes.id', 'themes.name')
                    ->orderBy(DB::raw('date(news.created_at)'), 'desc')
                    ->get();

                $data[$dt] = $qry;
            }

            // Construir JSON para gráficos
            foreach ($themes as $theme) {
                $json .= '{';
                $json .= 'name: "' . addslashes($theme->name) . '",';
                $json .= 'data:[';
                $xcoma = '';
                foreach ($fechas as $dt) {
                    $dat_imp = 0;
                    foreach ($data[$dt] as $dato_) {
                        if ($dato_->id == $theme->id) {
                            $dat_imp = $dato_->total;
                        }
                    }
                    $json .= $xcoma . $dat_imp;
                    $xcoma = ',';
                }
                $json .= ']},';
            }
        }

        // Obtener noticias paginadas con relaciones
        // Usamos paginate() en lugar de simplePaginate() para tener acceso a total(), firstItem(), lastItem()
        $notes = NewsFilter::filter($request, ['ids' => $notesIds])
            ->with(['sector', 'genre', 'source', 'mean', 'assignedNews' => function ($q) use ($company) {
                $q->where('company_id', $company->id)->with('theme');
            }])
            ->orderBy('news_date', 'DESC')
            ->paginate($paginate);

        $notes->appends($request->except('page'));

        return view('clients.report', compact(
            'notes',
            'company',
            'tendencias',
            'medios',
            'themes',
            'fechas',
            'data',
            'json',
            'from_d',
            'to_d'
        ));
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
