<?php
/**
  *-------------------------------------------------------------------------------------
  * Developer Information
  *-------------------------------------------------------------------------------------
  * @author Isaac Daniel Batista <daniel@danielbat.com>
  * @link https://danielbat.com Web Autor's site
  * @see https://twitter.com/codeisaac <@codeisaac>
  * @copyright 2019
  * @version 1.0.0
  * @package App\Http\Controllers
  * Type: Class Controller
  * Description: ClientController
  *
  * For the full copyright and license information, please view the LICENSE
  * file that was distributed with this source code.
  */
        


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

        $date = \Carbon\Carbon::now();
        // dd($date->format('Y-m'));
        $count = array();
        $count['total'] = DB::connection('opemediosold')->table('asigna')->where('id_empresa', $idCompany)->count();
        $count['month'] = DB::connection('opemediosold')->table('asigna')
            ->join('noticia', 'noticia.id_noticia', '=', 'asigna.id_noticia')
            ->where('id_empresa', $idCompany)
            ->whereRaw("date_format(noticia.fecha, '%Y-%m') = '{$date->format('Y-m')}'")->count();
        $count['day'] = DB::connection('opemediosold')->table('asigna')
            ->join('noticia', 'asigna.id_noticia', '=', 'noticia.id_noticia')
            ->where('id_empresa', $idCompany)
            ->where('noticia.fecha', $date->format('Y-m-d'))->count();
        
        return view('clients.news', compact('company', 'newsAssigned', 'themes', 'count'));
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

    public function primeras (Request $request, $company) {

        $date = \Carbon\Carbon::now()->subDay();

        $covers = DB::connection('opemediosold')->table('primera_plana as pp')
            ->select('pp.fecha', 'pp.imagen', 'f.nombre')
            ->join('fuente as  f', 'pp.id_fuente', '=', 'f.id_fuente')
            ->where('pp.fecha', $date->format('Y-m-d'))->get();

        return view('clients.primeras', compact('covers'));
    }
    
    public function portadas (Request $request, $company) {

        $date = \Carbon\Carbon::now()->subDay();

        $covers = DB::connection('opemediosold')->table('portada_financiera as pf')
            ->select('pf.fecha', 'pf.imagen', 'f.nombre')
            ->join('fuente as  f', 'pf.id_fuente', '=', 'f.id_fuente')
            ->where('pf.fecha', $date->format('Y-m-d'))->get();

        return view('clients.portadas', compact('covers'));
    }

    public function cartones (Request $request, $company) {

        $date = \Carbon\Carbon::now()->subDay();

        $covers = DB::connection('opemediosold')->table('carton')
            ->select('carton.fecha', 'carton.imagen', 'fuente.nombre', 'carton.titulo')
            ->join('fuente', 'carton.id_fuente', '=', 'fuente.id_fuente')
            ->where('carton.fecha', $date->format('Y-m-d'))->get();

        return view('clients.cartones', compact('covers'));
    }

    public function financieras (Request $request, $company) {

        $date = \Carbon\Carbon::now()->subDay();

        $covers = DB::connection('opemediosold')->table('columna_financiera as cf')
            ->select('cf.titulo', 'cf.fecha', 'cf.imagen_jpg', 'f.nombre', 'cf.autor')
            ->join('fuente as  f', 'cf.id_fuente', '=', 'f.id_fuente')
            ->where('cf.fecha', $date->format('Y-m-d'))->get();

        return view('clients.financieras', compact('covers'));
    }

    public function politicas (Request $request, $company) {

        $date = \Carbon\Carbon::now()->subDay();

        $covers = DB::connection('opemediosold')->table('columna_politica as cp')
            ->select('cp.titulo', 'cp.fecha', 'cp.imagen_jpg', 'f.nombre', 'cp.autor')
            ->join('fuente as  f', 'cp.id_fuente', '=', 'f.id_fuente')
            ->where('cp.fecha', $date->format('Y-m-d'))->get();

        return view('clients.politicas', compact('covers'));
    }

    public function themes (Request $request, $slug_company) {

        $company = Company::where('slug', $slug_company)->first();

        $userMetaOldCompany = auth()->user()->metas()->where('meta_key', 'old_company_id')->first();
        if($userMetaOldCompany) {
            $idCompany = $userMetaOldCompany->meta_value;
        } else {
            $idCompany = $company->id;
        }

        $themes = DB::connection('opemediosold')->table('tema')->where('id_empresa', $idCompany)->get();
        
        $defaultThemeId = $themes->first()->id_tema;

        $news = $this->getNewsByTheme($defaultThemeId, $idCompany);

        return view('clients.themes', compact('themes', 'news', 'company', 'defaultThemeId', 'idCompany'));
    }

    protected function getNewsByTheme ($themeId, $idCompany) {
        return DB::connection('opemediosold')->table('asigna')
            ->select('noticia.encabezado', 'fuente.nombre', 'fuente.logo', 'noticia.fecha', 'noticia.autor', 'fuente.empresa', 'noticia.sintesis', 'noticia.id_noticia')
            ->join('noticia', 'asigna.id_noticia', '=', 'noticia.id_noticia')
            ->join('fuente', 'noticia.id_fuente', '=', 'fuente.id_fuente')
            ->where('id_empresa', $idCompany)
            ->where('id_tema', $themeId)
            ->orderBy('noticia.fecha', 'desc')
            ->simplePaginate(15);
            // ->get();
    }

    public function newsByTheme(Request $request) {
        $data = $request->all();
        $news = $this->getNewsByTheme($data['themeid'], $data['companyid']);
        $company = Company::where('slug', $data['companyslug'])->first();
        $idCompany = $data['companyid'];
        $theme = $themes = DB::connection('opemediosold')->table('tema')->where('id_empresa', $idCompany)->where('id_tema', $data['themeid'])->first();
        // return response()->json($this->getNewsByTheme($data['themeid'], $data['companyid']));
        return view('components.listNews', compact('news', 'company', 'theme', 'idCompany'))->render();
    }
}
