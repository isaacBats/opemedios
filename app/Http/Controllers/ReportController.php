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
use App\News;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function byClient(Request $request) {
        
        $companies = Company::all();

        if($request->ajax()) {
            $paginate = 50;
            $notesIds = AssignedNews::query()->where('company_id', $request->input('company'))
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
                })->simplePaginate($paginate);

            $client = Company::find($request->input('company'));
            return [
                'render' => view('admin.report.table-rows', compact('notes', 'client'))->render(),
                'count' => $notes->count(),
                'firstitem' => $notes->firstItem()
            ];
        }

        return view('admin.report.byclient', compact('companies'));
    }

    public function export(Request $request) {
        return (new ReportsExport($request))->download('Reporte.xlsx');
    }
}
