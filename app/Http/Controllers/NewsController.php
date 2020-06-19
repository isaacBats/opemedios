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
use App\File;
use App\Genre;
use App\Http\Controllers\FileController;
use App\Http\Controllers\NewsletterThemeNewsController;
use App\Means;
use App\News;
use App\Newsletter;
use App\NewsletterThemeNews;
use App\Sector;
use App\TypePage;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class NewsController extends Controller
{
    protected $mediaController;
    
    protected $fileController;

    protected $ntnController;

    public function __construct(MediaController $mediaController, FileController $fileController, NewsletterThemeNewsController $ntnController) {
        $this->mediaController = $mediaController;
        $this->fileController = $fileController;
        $this->ntnController = $ntnController;
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
        
        $fmt = numfmt_create('es_MX', \NumberFormatter::CURRENCY);

        $metas = [
            'Autor' => $new->autor,
            'Alcance' => number_format($new->alcanse),
            'Medio' => $new->medio,
            'Sección' => $new->seccion,
            'Sector' => $new->sector,
            'Tipo Autor' => $new->tipo_autor,
            'Genero' => $new->genero,
            'Tendencia' => $new->tendencia, 
            'Costo' => numfmt_format($fmt, $newComplement->costo),
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

    public function index(Request $request) {

        $paginate = 25;

        if($request->has('new_mean')) {
            $meanId = $request->get('new_mean');
            $news = News::where('mean_id', $meanId)->orderBy('id', 'DESC')->paginate($paginate);
            $news->setPath(route('admin.news', ['new_mean' => $meanId]));
        } else {
            $news = News::orderBy('id', 'DESC')->paginate($paginate);
        }
        
        return view('admin.news.index', compact('news'));
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
        $data = $request->all();
        
        $validate = $this->validator($data);
        if($validate->fails()) {
            return back()->withErrors($validate)
                ->withInput();
        }

        $mean = Means::find($data['mean_id']);
        if ($mean->short_name == 'tel' || $mean->short_name == 'rad') {
            $data['metas_news'] = serialize([
                'news_hour' => $data['news_hour'], 
                'news_duration' => $data['news_duration'],
            ]);
        } elseif ($mean->short_name == 'per' || $mean->short_name == 'rev') {
            $data['metas_news'] = serialize([
                'page_type_id' => $data['page_type_id'], 
                'page_number' => $data['page_number'], 
                'page_size' => $data['page_size'],
            ]);
        } elseif($mean->short_name == 'int') {
            $data['metas_news'] = serialize([
                'news_hour' => $data['news_hour'], 
                'url' => $data['url'], 
            ]);
        }

        $data['news_date'] = Carbon::createFromFormat('d-m-Y', $data['news_date']);
        
        if(array_key_exists('in_newsletter', $data)) {
            $data['in_newsletter'] = 1;
        }

        $data['user_id'] = Auth::user()->id;
        
        $news = News::create($data);
        if(isset($data['files'])){
            $files = explode(',', $data['files']);
            
            for ($loop = 0; $loop < sizeof($files); $loop++) {
                $attachedFile = File::find($files[$loop]);
                if($loop === 0) {
                    $attachedFile->news_id = $news->id;
                    $attachedFile->main_file = 1;
                    $attachedFile->file_from_news = 1;
                } else {
                    $attachedFile->news_id = $news->id;
                    $attachedFile->file_from_news = 1;
                }
                $attachedFile->save();
            }
        }

        if(array_key_exists('in_newsletter', $data) && array_key_exists('newsletter_id', $data) && array_key_exists('newsletter_theme_id', $data)) {
            // Todo: Validar que una noticia no se agregue al mismo newsletter y al mismo tema
            $newsletter = NewsletterThemeNews::create([
                'newsletter_id' => $data['newsletter_id'], 
                'newsletter_theme_id' => $data['newsletter_theme_id'],
                'news_id' => $news->id,
            ]);
        }

        
        return back()->with('status', 'Noticia agregada. Para editar vaya al panel principal');
    }

    public function show (Request $request, $id) {
        $note = News::findOrFail($id);
        $main_file = $note->files->where('main_file', 1)->first();
        $fileTemplate = is_null($main_file) ? 'Esta nota aun no contiene archivos ajuntos' : $this->mediaController->template($main_file);

        return view('admin.news.show', compact('note', 'main_file', 'fileTemplate'));
    }

    public function edit (Request $request, $id) {
        $note = News::findOrFail($id);
        $authors = AuthorType::all();
        $sectors = Sector::where('active', 1)->get();
        $genres = Genre::all();
        $ptypes = TypePage::all();

        return view('admin.news.edit', compact('note', 'authors', 'sectors', 'genres', 'ptypes'));
    }

    public function update (Request $request, $id) {
        $note = News::findOrFail($id);
        $data = $request->all();
        
        if ($note->mean->short_name == 'tel' || $note->mean->short_name == 'rad') {
            $data['metas_news'] = serialize([
                'news_hour' => $data['news_hour'], 
                'news_duration' => $data['news_duration'],
            ]);
        } elseif ($note->mean->short_name == 'per' || $note->mean->short_name == 'rev') {
            $data['metas_news'] = serialize([
                'page_type_id' => $data['page_type_id'], 
                'page_number' => $data['page_number'], 
                'page_size' => $data['page_size'],
            ]);
        } elseif($note->mean->short_name == 'int') {
            $data['metas_news'] = serialize([
                'news_hour' => $data['news_hour'], 
                'url' => $data['url'], 
            ]);
        }
        $data['news_date'] = Carbon::createFromFormat('d-m-Y', $data['news_date']);
        
        $note->update($data);

        return redirect()->route('admin.new.show', ['id' => $note->id])->with('status', '¡Noticia actualizada satisfactoriamente!');
    }

    public function adjuntos (Request $request, $id) {

        $note = News::findOrFail($id);
        
        return view('admin.news.adjuntos', compact('note'));
    }

    public function adjuntosUpload(Request $request, $id) {
        $note = News::findOrFail($id);
        $files = json_decode($this->fileController->uploadFile($request)->getContent());
        foreach ($files->files as $fileId) {
            $attachedFile = File::find($fileId);
            $attachedFile->news_id = $note->id;
            $attachedFile->file_from_news = 1;
            $attachedFile->save();
        }

        return response()->json(['status' => 'ok']);
    }

    public function assignMainFileForNews(Request $request) {
        $note = News::findOrFail($request->query('news'));
        if($noteMainFile = $note->files->where('main_file', 1)->first()) {
            $mainFile = File::first($noteMainFile->id);
            $mainFile->main_file = 0;
            $mainFile->save();
        }

        $newMainFile = File::find($request->query('file'));
        $newMainFile->main_file = 1;
        $newMainFile->save();

        return redirect()->route('admin.new.show', ['id' => $note->id])->with('status', '¡Se ha asignado un nuevo archivo principal!');
    }

    public function removeFile(Request $request) {
        
        $file = File::findOrFail($request->input('file'));
        $newsID = $request->input('news');
        $fileName = $file->original_name; 
        if($this->fileController->removeTrashS3($file)) {
            $file->delete();
            
            return redirect()->route('admin.new.show', ['id' => $newsID])->with('status', "Se ha eliminado el archivo {$fileName} de forma correcta");
        }
        
        return redirect()->route('admin.new.show', ['id' => $newsID])->with('danger', "Algo malo paso !!!");
    }

    public function showNewsletters(Request $request, $id) {

        $note = News::findOrFail($id);
        $newsletters = Newsletter::where('active', 1)->get();

        return view('admin.news.newsletters', compact('note', 'newsletters'));
    }

    public function includeToNewsletters(Request $request, $id) {

        $newsletterId = $request->input('newsletter_id');
        $newsletterThemeId = $request->input('newsletter_theme_id');
        $note = News::findOrFail($id);
        $newsletter = Newsletter::findOrFail($newsletterId);
        $theme = $newsletter->company->themes->where('id', $newsletterThemeId)->first();
        $data = [
            'newsletter_id' => $newsletterId,
            'newsletter_theme_id' => $newsletterThemeId,
            'news_id' => $id,
        ];
        $this->ntnController->create($data);

        return redirect()->route('admin.new.newletter.show', ['id' => $id])->with('status', "Se ha incluido la nota {$note->title} al newsletter de {$newsletter->name} al tema {$theme->name}");
    }

    public function removeNewsletter(Request $request, $id) {
        $note = News::findOrFail($id);
        
        $newsletterThemeNews = $note->newsletters->find($request->input('newsletter_theme_news_id'));
        $NameOfNewsletter = $newsletterThemeNews->newsletter->name;
        $newsletterThemeNews->delete();

        return back()->with('status', "La nota se ha removido de {$NameOfNewsletter}");
    }

    public function notice (Request $request, $id) {
        $note = News::findOrFail($id);
        $mainFile = $note->files->where('main_file', 1)->first();

        return view('admin.news.send', compact('note', 'mainFile'));
    }

}
