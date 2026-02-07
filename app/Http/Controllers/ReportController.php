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

use App\Exports\{ReportsExport, ReportsExportPDF};
use App\Filters\{AssignedNewsFilter, NewsFilter};
use App\Models\{Company, ListReport, User, News};
use App\Traits\StadisticsNotes;
use Carbon\{Carbon, CarbonPeriod};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, DB, Log, Storage};
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

    public function generate_reports_bd($size) {
        $reportes = ListReport::where('created_at', '<', Carbon::now()->add('-10 days'))->get();

        foreach($reportes as $itm)
        {
            Storage::disk('public')->delete($itm->name_file);
            $itm->delete();
        }

        $data = ListReport::where('status', 0)->where('size', $size)->orderBy('id')->first();

        if(!is_null($data))
        {
            $data->status = 3;
            $data->save();
            
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
        $user = auth()->user();

        if ($user->isClient()) {
            $company = Company::where('slug', $slug_company)->firstOrFail();

            // Seguridad multi-tenant: verificar que el usuario tiene acceso a esta compañía
            $userCompanyId = $user->metas()->where('meta_key', 'company_id')->first()?->meta_value;
            if ($userCompanyId != $company->id) {
                abort(403, 'No tiene permiso para ver estos reportes.');
            }

            // Solo mostrar reportes del usuario actual
            $datos = ListReport::where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->get();

            return view('clients.list_solicitados', compact('company', 'datos'));
        }

        // Admin/Manager: ver todos los reportes
        $datos = ListReport::with('user')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.report.list_solicitados', compact('datos'));
    }

    public function byNotes(Request $request) {
        $breadcrumb = array();
        $start = $request->input('start') ? $request->input('start') : null;
        $end = $request->input('end') ? $request->input('end') : null;
        array_push($breadcrumb, ['label' => 'Reporte Notas por día']);
        $notes = $this->getNewsForMonitor('now', $start, $end);

        return view('admin.report.notes', compact('breadcrumb', 'notes', 'start', 'end'));
    }

    public function byUser(Request $request, User $user)
    {
        $day = $request->input('day') ?? null;
        $day = ($day == 'now' || $day == null) ? \Carbon\Carbon::now()->format('Y-m-d') : $day;
        $breadcrumb = array();
        array_push($breadcrumb, ['label' => 'Reporte Notas por día', 'url' => route('admin.report.bynotes')]);
        array_push($breadcrumb, ['label' => "Reporte de {$user->name}"]);

        $query = News::query();
        $start = $request->input('start') ?? null;
        $end = $request->input('end') ?? null;

        $notes = News::where('user_id', $user->id);

        if($start && is_null($end)){
            $notes->whereRaw('DATE(news_date) = ?', $start);
        } elseif ($start && $end) {
            $notes->whereBetween('news_date', [$start, $end]);
        } elseif (is_null($start) && is_null($end)) {
            $notes->whereRaw("DATE(news_date) = ? ", $day);
        } else {
            $notes->whereRaw("DATE(news_date) = ? ", $day);
        }

        $notes = $notes->orderBy('news_date', 'desc')
            ->paginate(20)
            ->appends('start', request('start'))
            ->appends('end', request('end'));

        return view('admin.report.user', compact('breadcrumb', 'notes'));
    }

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
        elseif(count($dates) < 120)
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
            
            $file_save->size        = count($dates) < 60 ? 'small' : (count($dates) < 210 ? 'medium' : 'big');

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
