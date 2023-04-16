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
use Illuminate\Http\Request;

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

    public function byNotes(Request $request) {
        $breadcrumb = array();
        $start = $request->input('start') ? $request->input('start') : null;
        $end = $request->input('end') ? $request->input('end') : null;
        array_push($breadcrumb, ['label' => 'Reporte por Notas']);
        $notes = $this->getNewsForMonitor('now', $start, $end);

        return view('admin.report.notes', compact('breadcrumb', 'notes'));
    }

<<<<<<< Updated upstream
    public function export(Request $request) {
        return (new ReportsExport($request))->download('Reporte.xlsx');
=======
    public function export(Request $request, $ind = false) {

        if($request->input('company') == null)
            return redirect()->route('admin.report.byclient')->with('error', 'Es necesario seleccionar un cliente');

        if($request->input('start_date') !== null && $request->input('end_date') !== null)
        {
            $from = Carbon::create($request->input('start_date'));
            $to = Carbon::create($request->input('end_date'));
        }else{
            $from =  Carbon::now()->add('-10 days');
            $to =  Carbon::now();//->add(' days');
        }

        $period = CarbonPeriod::create($from, $to);


        $from_d = $from->format('Y-m-d');
        $to_d = $to->format('Y-m-d');

        $request->merge(['start_date' => $from_d]);
        $request->merge(['end_date' => $to_d]);

        // Convert the period to an array of dates
        $dates = $period->toArray();


        if($ind)
        {
            try{
                Excel::store(new ReportsExport($request), $request->name_file, 'public');
            } catch (Exception $e) {
                Log::info("Error al generar el reporte: {$request->name_file}|{$e->getMessage()}");
            }

            $report = ListReport::find($request->id_report);
            $report->status = 1;
            $report->save();
            return true;
        }
        elseif(count($dates) < 3330)
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
            //Session::flash('status', 'Si su solicitud devolvió un error será procesada y podra descargarla cuando se encuentre lista, el nombre de su archivo es ' . $name_file);
            //return (new ReportsExport($request))->download('Reporte.xlsx');

            $company = Company::find($request->input('company'));
            $slug = $company->slug;
            $user = auth()->user();
            if($user->isClient())
                return redirect()->route('client.report', [$slug])->with('status', 'Su solicitud será procesada y podra descargarla cuando se encuentre lista, el nombre de su archivo es ' . $name_file . '.<br> Lo puede visualizar desde aquí <a href="' . route('client.report.solicitados', [$slug]) . '">Lista de reportes</a>');
            else
                return redirect()->route('admin.report.byclient')->with('status', 'Su solicitud será procesada y podra descargarla cuando se encuentre lista, el nombre de su archivo es ' . $name_file . '.<br> Lo puede visualizar desde aquí <a href="' . route('admin.report.solicitados') . '">Lista de reportes</a>');
        }

        //Excel::store(new ReportsExport($request), 'fileName.xlsx', 'public');

>>>>>>> Stashed changes
    }
    
    public function exportPDF(Request $request) {
        //return (new ReportsExportPDF($request))->download('Reporte.xlsx');
        return (new ReportsExportPDF($request))->download('Reporte.pdf', \Maatwebsite\Excel\Excel::DOMPDF);
    }
}
