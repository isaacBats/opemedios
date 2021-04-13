<?php

namespace App\Http\Controllers;

use App\AssignedNews;
use App\News;
use Illuminate\Http\Request;

class AssignedNewsController extends Controller
{
    public function getNewsByClient(Request $request) {

        $notesIds = AssignedNews::where('company_id', $request->input('company'))->pluck('news_id');
        $notes = News::whereIn('id', $notesIds)->get();
        
        return view('admin.report.table-rows', compact('notes'))->render();
    }
}
