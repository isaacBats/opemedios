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

use App\AssignedNews;
use App\Company;
use App\Exports\ReportsExport;
use App\Exports\ReportsExportPDF;
use App\Filters\AssignedNewsFilter;
use App\Filters\NewsFilter;
use App\News;
use App\Traits\StadisticsNotes;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\ListReport;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    use StadisticsNotes;

    public function byClient(Request $request) {

        $companies = Company::all();
        $breadcrumb = array();
        array_push($breadcrumb, ['label' => 'Reporte por Cliente']);

        if($request->ajax()) {
            $paginate = 50;
            $client = Company::find($request->input('company'));
            $notesIds = AssignedNewsFilter::filter($request, ['company' => $client])
                ->pluck('news_id');

            $notes = NewsFilter::filter($request, ['ids' => $notesIds])
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

    public function solicitados(Request $request)
    {
        $user_id = Auth::user()->id;
        $datos = ListReport::where('status', 1)->where('user_id', $user_id)->orderBy('id', 'desc')->get();

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

    public function export(Request $request, $ind = false) {


        if($request->input('start_date') !== null && $request->input('end_date') !== null)
        {
            $from = Carbon::create($request->input('start_date'));
            $to = Carbon::create($request->input('end_date'));
        }else{
            $from =  Carbon::now()->add('-10 days');
            $to =  Carbon::now();//->add(' days');
        }

        $period = CarbonPeriod::create($from, $to);

        // Convert the period to an array of dates
        $dates = $period->toArray();


        if($ind)
        {
            Excel::store(new ReportsExport($request), $request->name_file, 'public');
            
            $report = ListReport::find($request->id_report);
            $report->status = 1;
            $report->save();

            return true;
        }
        elseif(count($dates) < 10)
            return (new ReportsExport($request))->download('Reporte.xlsx');
        else
        {
            $name_file = Carbon::now()->format('YmdHis') . '.xlsx';
            $file_save = new ListReport;
            $file_save->user_id     = Auth::user()->id;
            $file_save->name_file   = $name_file;
            $file_save->start_date  = $request->input('start_date');
            $file_save->end_date    = $request->input('end_date');
            $file_save->company     = $request->input('company');
            $file_save->theme_id    = $request->input('theme_id');
            $file_save->sector      = $request->input('sector');
            $file_save->genre       = $request->input('genre');
            $file_save->mean        = $request->input('mean');
            $file_save->source_id   = $request->input('source_id');
            $file_save->word        = $request->input('word');

            $file_save->save();

            return redirect()->route('admin.report.byclient')->with('status', 'Su solicitud será procesada y podra descargarla cuando se encuentre lista, el nombre de su archivo es ' . $name_file);
        }
        
        //Excel::store(new ReportsExport($request), 'fileName.xlsx', 'public');
        
    }
    
    public function exportPDF(Request $request) {
        return (new ReportsExportPDF($request))->download('Reporte.pdf', \Maatwebsite\Excel\Excel::DOMPDF);
    }
}
