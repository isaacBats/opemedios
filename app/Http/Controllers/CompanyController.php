<?php

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
        $turns = Turn::latest()->limit(5)->get();
        
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
            $input['logo'] = $request->file('logo')->store('public/company/logos');
        }

        Company::create($input);

        return redirect()->route('companies')->with('alert-success', 'La empresa se ha creado con éxito');
    } 
}
