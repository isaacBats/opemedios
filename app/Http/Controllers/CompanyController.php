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
use App\Turn;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Validator;

class CompanyController extends Controller
{
    public function index () {

        $companies = Company::all();
        return view('admin.company.index', compact('companies'));
    }

    public function showFormNewCompany() {
        $turns = Turn::all();
        
        return view('admin.company.newcompany', compact('turns'));
    }

    public function create (Request $request) {
        
        $input = $request->all();
        $input['slug'] = Str::slug($input['name']);
        Validator::make($input, [
            'name' => 'required|max:200|',
            'slug' => 'required|unique:companies',
            'turn_id' => 'required'
        ], 
        [
            'turn_id.required' => 'Es necesario elegir un Giro.',
            'required' => 'El :attribute es necesario.'
        ])->validate();
        
        if($file = $request->hasFile('logo')) {
            $input['logo'] = $request->file('logo')->store('company_logos');
        }

        Company::create($input);

        return redirect()->route('companies')->with('alert-success', 'La empresa se ha creado con éxito');
    }

    public function show (Request $request, $id) {

        $company = Company::find($id);

        return view('admin.company.show', compact('company'));
    } 
}
