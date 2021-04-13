<?php

namespace App\Http\Controllers;

use App\Company;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function byClient() {
        
        $companies = Company::all();

        return view('admin.report.byclient', compact('companies'));
    }
}
