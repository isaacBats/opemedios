<?php

namespace App\Http\Controllers;

use App\Company;
use App\Http\Controllers\MediaController;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{
    protected $mediaController;

    public function __construct(MediaController $mediaController) {
        $this->mediaController = $mediaController;
    }


    private function getMinName($id) {
        $dim = [
            1 => 'tel',
            2 => 'rad',
            3 => 'per',
            4 => 'rev',
            5 => 'int',
        ];

        return $dim[$id];

    }
    public function index($slug_company) {
        // Analizar si es necesario la paginación 
        // Crear el buscador de noticias
        // crear filtros para las noticias

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

        $new = DB::connection('opemediosold')->table('noticia as n')
                ->select(
                    'n.id_noticia',
                    'n.encabezado',
                    'n.sintesis',
                    'n.autor',
                    'n.fecha',
                    'n.comentario',
                    'n.alcanse',
                    'n.id_tipo_fuente as medio_id',
                    'tf.descripcion as medio',
                    'f.nombre as fuente_nombre',
                    'f.empresa as fuente_empresa',
                    'f.logo as fuente_logo',
                    'secc.nombre as seccion',
                    'sec.nombre as sector',
                    'ta.descripcion as tipo_autor',
                    'g.descripcion as genero',
                    't.descripcion as tendencia',
                    'u.id_usuario as id_monitor'
                )
                    ->join('tipo_fuente as tf', 'n.id_tipo_fuente', '=', 'tf.id_tipo_fuente')
                    ->join('fuente as f', 'n.id_fuente', '=', 'f.id_fuente')
                    ->join('seccion as secc', 'n.id_seccion', '=', 'secc.id_seccion')
                    ->join('sector as sec', 'n.id_sector', '=', 'sec.id_sector')
                    ->join('tipo_autor as ta', 'n.id_tipo_autor', '=', 'ta.id_tipo_autor')
                    ->join('genero as g', 'n.id_genero', '=', 'g.id_genero')
                    ->join('tendencia as t', 'n.id_tendencia_monitorista', '=', 't.id_tendencia')
                    ->join('usuario as u', 'n.id_usuario', '=', 'u.id_usuario')
                ->where('id_noticia', $newId)->get()->first();

        $adjuntosHTML = DB::connection('opemediosold')->table('adjunto')
                ->where('id_noticia', $new->id_noticia)
                ->get()->map(function ($adj) use ($new) { 
                    
                    $medio = strtolower($new->medio);
                    
                    if($medio == 'peri&oacute;dico') {
                        $medio = 'periodico';
                    } elseif ($medio == 'Televisi&oacute;n') {
                        $medio = 'television';
                    }
                    
                    $path = "http://sistema.opemedios.com.mx/data/noticias/{$medio}/{$adj->nombre_archivo}"; 
                    
                    return $adj->principal ? $this->mediaController->getHTMLForMedia($adj, $path)
                                            :"<a href='{$path}' download='{$adj->nombre}' target='_blank'>Descargar Archivo</a>"; 
                });

        $metadata = $this->getMetaNew($new);
            

        return view('clients.shownew', compact('new', 'metadata', 'adjuntosHTML'));
    }

    private function getMetaNew($new) {
        $min = $this->getMinName($new->medio_id);
        $tableNewName = 'noticia_' . $min;
        $newComplement = DB::connection('opemediosold')->table($tableNewName)->where('id_noticia', $new->id_noticia)->first();
        $metas = [
            'Autor' => $new->autor,
            'Alcance' => number_format($new->alcanse),
            'Medio' => $new->medio,
            'Sección' => $new->seccion,
            'Sector' => $new->sector,
            'Tipo Autor' => $new->tipo_autor,
            'Genero' => $new->genero,
            'Tendencia' => $new->tendencia, 
            'Costo' => money_format('%.2n', $newComplement->costo),
        ];

        if($min == 'per' || $min == 'rev') {
            $tipoPag = DB::connection('opemediosold')->table('tipo_pagina')->where('id_tipo_pagina', $newComplement->id_tipo_pagina)->first();
            $tamanoNota = DB::connection('opemediosold')->table('tamano_nota')->where('id_tamano_nota', $newComplement->id_tamano_nota)->first();
            
            $metas += [
                'Pagina' => $newComplement->pagina,
                'Porcentaje pagina' => $newComplement->porcentaje_pagina,
                'Tipo de pagina' => $tipoPag->descripcion,
                'Tamaño Nota' => $tamanoNota ? $tamanoNota->descripcion : 0,
            ];
        } elseif($min == 'tel' || $min == 'rad') {
            $metas += [
                'Hora' => $newComplement->hora,
                'Duración' => $newComplement->duracion,
            ];
        } else {
            $metas += [
                'Url' => $newComplement->url,
            ];
        }

        return $metas;
    }
}
