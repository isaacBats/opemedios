<?php

namespace App\Http\Controllers;

use App\Means;
use App\Source;
use Illuminate\Http\Request;

class SourceController extends Controller
{
    public function index() {

        $sources = Source::all();
        return view('admin.sources.index', compact('sources'));
    }

    public function showForm() {
        $means = Means::all();

        return view('admin.sources.create', compact('means'));
    }
}
