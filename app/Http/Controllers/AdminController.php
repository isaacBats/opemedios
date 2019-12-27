<?php

namespace App\Http\Controllers;

use App\Company;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $count['users'] = User::all()->count();
        $count['news'] = DB::connection('opemediosold')->table('noticia')->count();
        return view('admin.home', compact('count'));
    }
}
