<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NewspaperFile;

class NewspaperController extends Controller
{

    public function index(Request $request) {
        $newspapers = NewspaperFile::groupBy(['newspaper', 'date'])->orderBy('id', 'desc')->paginate(10);

        return view('admin.newspaper.index', compact('newspapers'));
    }

    public function indexGuest(Request $request) {
        //$newspapers = NewspaperFile::groupBy(['newspaper', 'date'])->orderBy('id', 'desc')->paginate(30);
        $newspapers = NewspaperFile::select(
            'newspaper',
            'date',
            // Usamos MAX() para obtener el ID más alto dentro de cada grupo
            \DB::raw('MAX(id) as latest_id'), 
            // Y la función apropiada para obtener el 'file' asociado
            \DB::raw('SUBSTRING_INDEX(GROUP_CONCAT(file ORDER BY id DESC), ",", 1) as latest_file')
        )
        ->groupBy(['newspaper', 'date'])
        ->orderBy('latest_id', 'desc')
        ->paginate(10);

        return view('admin.newspaper.index_guest', compact('newspapers'));
    }
    
}
