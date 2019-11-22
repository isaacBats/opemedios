<?php

namespace App\Http\Controllers;

use App\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{
    public function index($slug_company) {
        // Analizar si es necesario la paginación 
        // Crear el buscador de noticias
        // crear filtros para las noticias

        //traer los logos de las fuentes asi como su información

        $company = Company::where('slug', $slug_company)->first();
        $userMetaOldCompany = auth()->user()->metas()->where('meta_key', 'old_company_id')->first();
        if($userMetaOldCompany) {
            $idCompany = $userMetaOldCompany->meta_value;
        } else {
            $idCompany = $company->id;
        }
        
        $assignedNews = DB::connection('opemediosold')->select('SELECT * FROM asigna WHERE id_empresa = ? ORDER BY id_noticia DESC LIMIT 200', [$idCompany]);
        
        $idThemeAssigned = array_values(array_unique(array_map(function ($assign) {
            return $assign->id_tema;
        }, $assignedNews)));
        $lastFiveIdThemes = array_slice($idThemeAssigned, 0, 5);
        $themes = DB::connection('opemediosold')->table('tema')->whereIn('id_tema', $lastFiveIdThemes)->get();
        
        $newsAssigned = array_map(function ($theme) use ($idCompany) {
            
                $newsByTheme = DB::connection('opemediosold')->table('asigna')
                ->select('id_noticia')
                ->where([
                    ['id_empresa', '=',  $idCompany], 
                    ['id_tema', '=', $theme->id_tema],
                ])
                ->orderBy('id_noticia', 'desc')
                ->limit(7)
                ->get();

                $idNewsAssigned = array_map(function ($assignNew) {
                    return $assignNew->id_noticia;
                }, $newsByTheme->toArray());
            
                return array($theme->id_tema, DB::connection('opemediosold')->table('noticia')
                    ->join('fuente', 'noticia.id_fuente', '=', 'fuente.id_fuente')
                    ->whereIn('id_noticia', $idNewsAssigned)->get());

        }, $themes->toArray());

        $countTotal = DB::connection('opemediosold')->table('asigna')->where('id_empresa', $idCompany)->count();
        
        return view('clients.news', compact('company', 'newsAssigned', 'themes', 'countTotal'));
    }

    public function showNew(Request $request, $company, $newId) {

        return DB::connection('opemediosold')->table('noticia')
                    ->join('fuente', 'noticia.id_fuente', '=', 'fuente.id_fuente')
                    ->where('id_noticia', $newId)->get();
    }
}
