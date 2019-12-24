<?php

namespace App\Http\Controllers;

use App\Company;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $count = array();
        $count['clients'] = Company::all()->count();
        return view('admin.home', compact('count'));
    }
}
