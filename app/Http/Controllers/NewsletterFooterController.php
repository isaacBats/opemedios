<?php

namespace App\Http\Controllers;

use App\NewsletterFooter;
use Carbon\Carbon;
use Illuminate\Http\Request;

class NewsletterFooterController extends Controller
{
    public function addCovers (Request $request){

        if( NewsletterFooter::whereDate('created_at', Carbon::today()->format('Y-m-d'))->count() > 0 ) {
            return redirect()->route('admin.newsletters')->with('status', 'Ya existen portadas para el día de hoy.');
        }


        $request->validate([
            'primeras_planas' => 'required|url',
            'portadas_financieras' => 'required|url',
            'columnas_financieras' => 'required|url',
            'portadas_politicas' => 'required|url',
            'cartones' => 'required|url'
        ]);

        $urls = serialize($request->except('_token'));
        NewsletterFooter::create([
            'urls' => $urls
        ]);

        return redirect()->route('admin.newsletters')->with('status', 'Portadas agregadas correctamente.');
    }

    public function deleteCovers (Request $request, $id) {
        $covers = NewsletterFooter::findOrFail($id);
        $covers->delete();

        return back()->with('status', "Se han eliminado las portadas satisfactoriamente");
    }
}
