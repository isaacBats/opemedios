<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NewspaperFile;

class NewspaperController extends Controller
{

    public function index(Request $request) {
        $newspapers = NewspaperFile::orderBy('id', 'desc')->paginate(10);

        return view('admin.newspaper.index', compact('newspapers'));
    }

}
