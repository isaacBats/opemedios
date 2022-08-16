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

use App\{AssignedNews, Company, Cover, Genre, Means, News, Sector, Theme};
use App\Exports\NewsExport;
use App\Filters\{AssignedNewsFilter, NewsFilter};
use App\Http\Controllers\{MediaController, NewsController};
use App\Traits\StadisticsNotes;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\{Arr, Str};
use Illuminate\Support\Facades\{Auth, DB, URL};
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
        $company = Company::where('slug', $slug_company)->first();

        $note = News::findOrFail($newId);
        return view('clients.shownew', compact('note', 'company'));
    }

    public function getCovers(Request $request, $slug_company)
    {
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

    public function myNews(Request $request, Company $company)
    {
        $pagination = null !== $request->input('pagination') ? $request->input('pagination') : 15 ;
        $notesIds = AssignedNewsFilter::filter($request, compact('company'))->pluck('news_id');
        $news = NewsFilter::filter($request, ['ids' => $notesIds])->paginate($pagination);
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
        // TODO: error al buscar por paginas
        $theme = Theme::findOrFail($data['themeid']);
        $news = News::whereIn('id', $idsNewsAssigned)
            ->orderBy('id', 'desc')
            ->paginate(30);
            // ->appends(['companyid' => $company->id, 'themeid' => $theme->id, 'companyslug' => $company->slug]);

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

        $notesIds = AssignedNewsFilter::filter($request, compact('company'))->pluck('news_id');

        $notes = NewsFilter::filter($request, ['ids' => $notesIds])
            ->orderBy('news_date', 'DESC')
            ->simplePaginate($paginate);

        $notes->setPath(URL::full());

        return view('clients.report', compact('notes', 'company'));
    }

    public function createReport(Request $request)
    {
        $date = Carbon::today()->timestamp;
        return Excel::download(new NewsExport($request->all()), "reporte_{$date}.xlsx");
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
