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
use App\User;
use App\UserMeta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Validator;

class CompanyController extends Controller
{
    public function index (Request $request) {

        $companies = Company::name($request->get('name'))
            ->turn($request->get('turn'))
            ->orderBy('id', 'DESC')->paginate(25);
        $turns = Turn::all();
        return view('admin.company.index', compact('companies', 'turns'));
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
            $input['logo'] = $request->file('logo')->store('company_logos', 'local');
        }

        Company::create($input);

        return redirect()->route('companies')->with('alert-success', 'La empresa se ha creado con éxito');
    }

    public function show (Request $request, $id) {

        $company = Company::find($id);
        $turns = Turn::all();

        return view('admin.company.show', compact('company', 'turns'));
    }

    public function getOldCompanies () {

        return DB::connection('opemediosold')->table('empresa')->select('id_empresa as id', 'nombre')->orderBy('nombre')->get();
    }

    public function relations (Request $request) {
        $inputCompany = $request->input('company');
        $company = Company::find($inputCompany);

        if($request->has('old_company_id') && !empty($request->input('old_company_id'))) {
            $company->old_company_id = $request->input('old_company_id');
            $company->save(); 

            return back()->with('status', 'Su cliente ahora esta relacionado con el antiguo cliente');
        }
        
        Log::info("La empresa {$company->name} no se selecciono una empresa del sistema pasado.");
        return back()->with('status', 'No se pudo relacionar. Intentalo mas tarde');
    }

    public function removeUser (Request $request, $userId) {
        $user = User::find($userId);
        $company = Company::find($user->metas()->where('meta_key', 'company_id')->first()->meta_value);
        try {
            $remove = $user->metas()->where('meta_key', 'like', '%company_id')->delete();
            $userName = $user->name;

            return back()->with('status', "Se ha removido al usuario {$userName} de {$company->name} exitosamente.");
            
        } catch (Exception $e) {
            Log::info("Error al borrar metas de usuario: {$e->getMessage()}");
        }
    }

    public function addUserAjax(Request $request) {
        $inputs = $request->all();
        $user = User::find($inputs['user']);
        // $company = Company::find($inputs['company']);

        $meta_company = new UserMeta();
        $meta_company->meta_key = 'company_id';
        $meta_company->meta_value = $inputs['company'];
        $user->metas()->save($meta_company);

        return redirect()->route('company.show', ['id' => $inputs['company']])->with('status', "Se ha agregado el usuario {$user->name} correctamente a esta empresa.");
    }

    public function update (Request $request, $id) {
        $inputs = $request->all();
        $company = Company::find($id);

        $company->name = $inputs['name'];
        $company->address = $inputs['address'];
        $company->turn_id = $inputs['turn_id'];
        $company->save();

        return redirect()->route('company.show', ['id' => $id])->with('status', "¡Exito!. Datos actualizados");
    }

    public function updateLogo (Request $request, $id) {
        $company = Company::find($id);
        try {
            if(Storage::drive('local')->exists($company->logo)) {
                Storage::drive('local')->delete($company->logo);
            } 
            
            $company->logo = $request->file('logo')->store('company_logos', 'local');
            $company->save();
            
        } catch (Exception $e) {
            return back()->with('status', 'Could not update image: ' . $e->getMessage());
        }

        return redirect()->route('company.show', ['id' => $id])->with('status', '¡Exito!. Se ha cambiado el logo correctamente');
    }

    public function getCompaniesAjax (Request $request) {

        return response()->json(['items' => Company::select('id', 'name AS text')->where([
                ['name', 'like', "%{$request->input('q')}%"],
                // ['active', '=', 1],
            ])->get()->toArray()
        ]); 
    }

    public function getAccountsAjax(Request $request) {
        $company = Company::findOrFail($request->input('company_id'));

        return response()->json($company->accounts());
    }
}
