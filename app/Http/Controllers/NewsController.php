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
  * @package App\
  * Type: Controller
  * Description: Description
  *
  * For the full copyright and license information, please view the LICENSE
  * file that was distributed with this source code.
  */
        

namespace App\Http\Controllers;

use App\AuthorType;
use App\Genre;
use App\Means;
use App\Newsletter;
use App\Sector;
use App\TypePage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class NewsController extends Controller
{
    
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

    public static function getNewById($newId) {

        return DB::connection('opemediosold')->table('noticia as n')
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
    }

    public function getMetaNew($new) {
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

    public function index() {

        return view('admin.news.index');
    }

    public function showForm() {
        $means = Means::all();
        $user = Auth::user();
        $defaulNoteType = $user->isMonitor() ? $user->getMonitorType() : Means::where('short_name', 'int')->first();
        $authors = AuthorType::all();
        $sectors = Sector::where('active', 1)->get();
        $genres = Genre::all();
        $ptypes = TypePage::all();
        $newsletters = Newsletter::where('active', 1)->get();
        return view('admin.news.create', compact('means', 'defaulNoteType', 'authors', 'sectors', 'genres', 'ptypes', 'newsletters'));
    }

    public function validator (array $data) {
        return Validator::make($data, [
            'title'             => 'required|string',
            'synthesis'         => 'required|string',
            'author'            => 'required|string',
            'author_type_id'    => 'required|digits_between:1,6',
            'sector_id'         => 'required|numeric',
            'genre_id'          => 'required|digits_between:1,11',
            'source_id'         => 'required|numeric',
            'section_id'        => 'required|numeric',
            'mean_id'           => 'required|digits_between:1,5',
            'news_date'         => 'nullable|date_format:"d-m-Y"',
            'cost'              => 'required|numeric',
            'trend'             => 'required|digits_between:1,3',
            'scope'             => 'required|numeric',
            'news_hour'         => [
                                    Rule::requiredIf(function() use ($data){
                                        $mean = $data['mean_id'];
                                        if ($mean == 1 || $mean == 2 || $mean == 5) {
                                            return true;
                                        } 
                                        return false;
                                    }),
                                    'date_format:"H:i:s"',
                                ],
            'news_duration'     => [
                                    Rule::requiredIf( function() use ($data) {
                                        $mean = $data['mean_id'];
                                        if ($mean == 1 || $mean == 2) {
                                            return true;
                                        } 
                                        return false;
                                    }),
                                    'date_format:"H:i:s"',
                                ],
            'page_number'       => [
                                    Rule::requiredIf( function() use ($data) {
                                        $mean = $data['mean_id'];
                                        if ($mean == 3 || $mean == 4) {
                                            return true;
                                        } 
                                        return false;
                                    }),
                                    'numeric',
                                ],
            'page_type_id'      => [
                                    Rule::requiredIf( function() use ($data) {
                                        $mean = $data['mean_id'];
                                        if ($mean == 3 || $mean == 4) {
                                            return true;
                                        } 
                                        return false;
                                    }),
                                    'digits_between:1,4'
                                ],
            'page_size'         => [
                                    Rule::requiredIf( function() use ($data) {
                                        $mean = $data['mean_id'];
                                        if ($mean == 3 || $mean == 4) {
                                            return true;
                                        } 
                                        return false;
                                    }),
                                    'digits_between:1,100'
                                ],
            'url'               => 'required_if:mean_id,5|url'
        ], [
            'required' => 'El campo es requerido',
            'url.required_if' => 'La URL es requerida',
            'numeric' => 'El campo debe ser un número',
            'date_format' => 'El campo debe de tener el siguiente formato :format',
            'digits_between' => 'Ingresa un número entre :min y :max'
        ]);
    }


    public function create (Request $request) {
        $validate = $this->validator($request->all());
        if($validate->fails()) {
            
            return back()->withErrors($validate)
                ->withInput();
        }

        return 'Todo ok';
    }
}
