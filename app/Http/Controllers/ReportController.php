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

    public function export(Request $request) {
        return (new ReportsExport($request))->download('Reporte.xlsx');
    }
    
    public function exportPDF(Request $request) {
        //return (new ReportsExport($request))->download('Reporte.xlsx');
        return (new ReportsExportPDF($request))->download('Reporte.pdf', \Maatwebsite\Excel\Excel::DOMPDF);
    }
}
