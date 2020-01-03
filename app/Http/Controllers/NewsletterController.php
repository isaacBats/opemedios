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
use App\Mail\NewsletterEmail;
use App\Newsletter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class NewsletterController extends Controller
{
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

      $newsletter = Newsletter::with('company')->find(1);
    
      $company = $newsletter->company;
      $emails = $company->emailsNewsLetters();
      
      $news = DB::connection('opemediosold')->table('noticia')
            ->select('noticia.encabezado', 'fuente.nombre', 'fuente.logo', 'noticia.fecha', 'noticia.autor', 'fuente.empresa', 'noticia.sintesis', 'noticia.id_noticia')
            ->join('fuente', 'noticia.id_fuente', '=', 'fuente.id_fuente')
            ->join('asigna', 'noticia.id_noticia', '=', 'asigna.id_noticia')
            ->where([
                ['asigna.id_empresa', '=', '699'],
                ['noticia.fecha', '=', '2019-12-23']])
            ->orderBy('fecha', 'desc')
            ->get();

      Mail::to($emails)->send(new NewsletterEmail($newsletter, $news));
      return 'Aqui se va a enviar el mail';
    }
}
