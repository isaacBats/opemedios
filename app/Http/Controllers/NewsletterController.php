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
use App\Newsletter;
use Illuminate\Http\Request;
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
}
