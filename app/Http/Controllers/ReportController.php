<?php
/**
  *-------------------------------------------------------------------------------------
  * Developer Information
  *-------------------------------------------------------------------------------------
  * @author Isaac Daniel Batista <daniel@danielbat.com>
  * @link https://danielbat.com Web Autor's site
  * @see https://twitter.com/codeisaac <@codeisaac>
  * @copyright 2021
  * @version 1.0.0
  * @package App\
  * Type: Controller
  * Description: Description
  *
  * For the full copyright and license information, please view the LICENSE
  * file that was distributed with this source code.
  */

namespace App\Http\Controllers;

use App\Exports\ReportsExport;
use App\Exports\ReportsExportPDF;
use App\Filters\AssignedNewsFilter;
use App\Filters\NewsFilter;
use App\Jobs\ExportReport;
use App\Models\Company;
use App\Models\ListReport;
use App\Traits\StadisticsNotes;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    use StadisticsNotes;

    public function byClient(Request $request) {

        $companies = Company::all();
        $breadcrumb = array();
        array_push($breadcrumb, ['label' => 'Reporte por Cliente']);

        if($request->ajax()) {
            $paginate = 50;
            $filters = $request->all();
            $client = Company::find($request->input('company'));
            $filters['notesIds'] = AssignedNewsFilter::filter($filters)
                ->pluck('news_id');
            $notes = NewsFilter::filter($filters)
                ->simplePaginate($paginate);

            return [
                'render' => view('admin.report.table-rows', compact('notes', 'client'))->render(),
                'count' => $notes->count(),
                'firstitem' => $notes->firstItem()
            ];
        }

        return view('admin.report.byclient', compact('companies', 'breadcrumb'));
    }

    public function generate_reports_bd() {
        $reportes = ListReport::where('created_at', '<', Carbon::now()->add('-10 days'))->get();

        foreach($reportes as $itm)
        {
            Storage::disk('public')->delete($itm->name_file);
            $itm->delete();
        }

        $data = ListReport::where('status', 0)->orderBy('id')->first();

        if(!is_null($data))
        {
            $request = new Request;

            $request->merge(
                [
                    'id_report' => $data->id,
                    'name_file' => $data->name_file,
                    'start_date' => $data->start_date,
                    'end_date' => $data->end_date,
                    'company' => $data->company,
                    'theme_id' => $data->theme_id,
                    'sector' => $data->sector,
                    'genre' => $data->genre,
                    'mean' => $data->mean,
                    'source_id' => $data->source_id,
                    'word' => $data->word,
                ]
            );

            $this->export($request, true);
        }
    }

    public function solicitados(Request $request, $slug_company = '')
    {
        $auth = Auth::user();
        if ($auth->hasRole('admin')) {
            $datos = ListReport::where('status', '>', 0)
                ->orderBy('id', 'DESC')
                ->get();
        } else {
            $user_id = $auth->id;
            $datos = ListReport::where('status', '>', 0)->where('user_id', $user_id)->orderBy('id', 'desc')->get();
        }



        $user = auth()->user();
        if($user->isClient())
        {
            $company = Company::where('slug', $slug_company)->first();
            return view('clients.list_solicitados', compact('company', 'datos'));
        }
        else
            return view('admin.report.list_solicitados', compact('datos'));

    }

    public function byNotes(Request $request) {
        $breadcrumb = array();
        $start = $request->input('start') ? $request->input('start') : null;
        $end = $request->input('end') ? $request->input('end') : null;
        array_push($breadcrumb, ['label' => 'Reporte por Notas']);
        $notes = $this->getNewsForMonitor('now', $start, $end);

        return view('admin.report.notes', compact('breadcrumb', 'notes'));
    }

    public function export(Request $request)
    {
        $time = date('YmdHis');
        $fileName = "Reporte_{$time}.xlsx";

//        ExportReport::dispatch($request->all(), $fileName); // Se crea el reporte por colas
//        Excel::store(new ReportsExport($request->all()), $fileName, 'public');  // guarda un archivo en local
        return (new ReportsExport($request->all()))->download($fileName); // para probar

        return redirect()->route('admin.report.byclient')
            ->with('status', "Se ha comenzado a generar el reporte con el nombre {$fileName}")
            ->withInput();

    }

    public function exportPDF(Request $request) {
        return (new ReportsExportPDF($request))->download('Reporte.pdf', \Maatwebsite\Excel\Excel::DOMPDF);
    }

    public function cambiaEstatus(Request $request)
    {
        $id = $request->id;

        $reporte = ListReport::find($id);
        $reporte->status = 2;
        $reporte->save();

        return true;
    }
}
