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

use App\Company;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\NewsController;
use App\Mail\NewsletterEmail;
use App\Newsletter;
use App\NewsletterSend;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class NewsletterController extends Controller
{
    
    protected $newsController;

    protected $mediaController;

    public function __construct(NewsController $newsController, MediaController $mediaController) {

        $this->newsController = $newsController;
        $this->mediaController = $mediaController;

    }

    public function index(){
        $newsletters = Newsletter::all();

        return view('admin.newsletter.index', compact('newsletters'));
    }

    public function showFormCreateNewsletter () {

        $companies = Company::all();

        return view('admin.newsletter.create', compact('companies'));
    }

    public function create (Request $request) {

        $data = $request->all();
        Validator::make($data, 
            ['name' => 'required|max:200|',], 
            ['name.required' => 'Es necesario elegir un nombre para el Newsletter.',]
        )->validate();
        
        if($file = $request->hasFile('banner')) {
            $data['banner'] = $request->file('banner')->store('newsletters');
        }
        $data['active'] = 1; // Newsletter active by default

        Newsletter::create($data);

        return redirect()->route('newsletters')->with('alert-success', 'El newsletter se ha creado con éxito');
    }

    public function sendMail() {

        $newsletters = Newsletter::all();
        $yesterday = \Carbon\Carbon::yesterday();
        try {
            if($newsletters->count() > 0) {
                foreach ($newsletters as $newsletter) {
                    $company = $newsletter->company;
                    $emails = $company->emailsNewsLetters();
                    $companyOld = $company->getOldCompanyId();              
                    if($companyOld){
                        $news = DB::connection('opemediosold')->table('noticia')
                            ->select('noticia.encabezado', 'fuente.nombre as fuente', 'fuente.logo', 'noticia.fecha', 'noticia.autor', 'fuente.empresa', 'noticia.sintesis', 'noticia.id_noticia', 'tema.nombre as tema', 'tipo_fuente.descripcion as medio')
                            ->join('fuente', 'noticia.id_fuente', '=', 'fuente.id_fuente')
                            ->join('asigna', 'noticia.id_noticia', '=', 'asigna.id_noticia')
                            ->join('tema', 'asigna.id_tema', '=', 'tema.id_tema')
                            ->join('tipo_fuente', 'noticia.id_tipo_fuente', '=', 'tipo_fuente.id_tipo_fuente')
                            ->where([
                                ['asigna.id_empresa', '=', $companyOld],
                                ['noticia.fecha', '=', $yesterday->format('Y-m-d')]])
                            ->orderBy('fecha', 'desc')
                            ->get();

                        if($news->count() > 0){
                            Mail::to($emails)->send(new NewsletterEmail($newsletter, $news, $company));
                            $newsIds = $news->map(function($new) {
                                return $new->id_noticia;
                            });
                            NewsletterSend::create([
                                'newsletter_id' => $newsletter->id,
                                'status' => 1,
                                'news_ids' => serialize($newsIds),
                                'num_notes' => $news->count(),
                                'num_email' => sizeof($emails),
                            ]);
                        } else {
                            Log::info("The number of news for the ${$newsletter->name} is insufficient");
                            continue;
                        }
                    } else {
                        Log::info('There is no related company');
                        continue;
                    }
                }
            } else {
                Log::info('There are no newsletters to send.');
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }

        Log::info("Newsletters of the day {$yesterday} have been sent");

        return 'Se ha enviado la noticia con satisfacción';
    }

    public function showNew(Request $request) {

        if(!$request->has('qry')) {
            return redirect()->route('home');
        }
        
        try {

            $data = explode('-',Crypt::decryptString($request->get('qry')));

        } catch (DecryptException $e) {
            return abort(403, 'Noticia no encontrada');
        }
        $company = Company::find(end($data));
        $newId = $data[0];
        $new = $this->newsController->getNewById($newId);
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
                                            :"<a href='{$path}' download='{$adj->nombre}' target='_blank'>Descargar Archivo Secundario</a>"; 
                });

        $metadata = $this->newsController->getMetaNew($new);

        return view('newsletter.shownew', compact('new', 'metadata', 'adjuntosHTML', 'company'));

    }
}
