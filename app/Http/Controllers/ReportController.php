<?php

namespace App\Http\Controllers;

use App\AssignedNews;
use App\Company;
use App\News;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function byClient(Request $request) {
        
        $companies = Company::all();

        if($request->ajax()) {
            $paginate = 5;

            $notesIds = AssignedNews::where('company_id', $request->input('company'))->pluck('news_id');
            $notes = News::whereIn('id', $notesIds)->simplePaginate($paginate);
            return [
                'render' => view('admin.report.table-rows', compact('notes'))->render(),
                'count' => $notes->count(),
                'firstitem' => $notes->firstItem()
            ];
        }

        return view('admin.report.byclient', compact('companies'));
    }
}
