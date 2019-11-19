<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the frontend.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.index');
    }

    public function about() {

        return view('aboutus');
    }

    public function clients() {

        return view('clients');
    }

    public function contact() {

        return view('contact');
    }

    public function signin() {

        return view('signin');
    }
}
