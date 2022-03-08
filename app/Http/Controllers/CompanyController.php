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

use App\AssignedNews;
use App\Company;
use App\Turn;
use App\User;
use App\UserMeta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Validator;

class CompanyController extends Controller
{
    public function index (Request $request) {
        $paginate = $request->has('paginate') ? $request->input('paginate') : 25;

        $breadcrumb = array();
        array_push($breadcrumb,['label' => 'Empresas']);

        $companies = Company::name($request->get('name'))
            ->turn($request->get('turn'))
            ->orderBy('id', 'DESC')
            ->paginate($paginate)
            ->appends('name', request('name'))
            ->appends('turn', request('turn'));

        return view('admin.company.index', compact('companies', 'breadcrumb', 'paginate'));
    }

    public function showFormNewCompany(Request $request) {
        $breadcrumb = array();
        $turns = Turn::all();
        $companies = Company::all();
        $father = $request->has('father') ? Company::find($request->get('father')) : null;
        $subAccount = $request->has('subcompany') ? true : false;

        array_push($breadcrumb, ['label' => 'Empresas', 'url' => route('companies')]);
        array_push($breadcrumb, ['label' => 'Nueva Empresa']);
        
        return view('admin.company.newcompany', compact('turns', 'companies', 'breadcrumb', 'father', 'subAccount'));
    }

    public function create (Request $request) {
        
        $input = $request->all();
        $input['slug'] = Str::slug($input['name']);
        Validator::make($input, [
            'name' => 'required|max:200|',
            'slug' => 'required|unique:companies',
            'turn_id' => 'required',
            'parent' => [
                Rule::requiredIf(function() use ($input){
                    if(isset($input['is_parent'])) {
                        return true;
                    }

                    return false;
                }),
                'numeric'
            ]
        ], 
        [
            'turn_id.required' => 'Es necesario elegir un Giro.',
            'required' => 'El :attribute es necesario.',
            'parent.required' => 'Es requerido el padre'
        ])->validate();
        
        if($file = $request->hasFile('logo')) {
            $input['logo'] = $request->file('logo')->store('company_logos', 'local');
        }

        Company::create($input);

        return redirect()->route('companies')->with('alert-success', 'La empresa se ha creado con éxito');
    }

    public function show (Request $request, $id) {
        $breadcrumb = array();
        $company = Company::find($id);
        $turns = Turn::all();

        $company->setRelation('assignedNews', $company->assignedNews()->paginate(25));
        $accounts = $company->accounts()->merge($company->executives);
        $companies = Company::where('id', '<>', $id)->get();

        array_push($breadcrumb, ['label' => 'Empresas', 'url' => route('companies')]);
        array_push($breadcrumb, ['label' => $company->name]);

        return view('admin.company.show', compact('company', 'turns', 'accounts', 'companies', 'breadcrumb'));
    }

    public function relateSubcompany(Request $request) {
        $input = $request->all();
        $company = Company::find($input['company_id']);
        
        if(!is_null($company->parent)) {
            return back()->with('status', "{$company->name} ya es subcuenta de {$company->father->name}");
        }
        
        $company->parent = $input['parent'];
        $company->save();

        return redirect()->route('company.show', ['id' => $company->id])->with('status', "La empresa {$company->name} ahora es una subcuenta de {$company->father->name}");

    }

    public function removeUser (Request $request, $userId) {
        $user = User::find($userId);
        $company = Company::find($request->input('companyid'));
        
        try {
            $metaCompany = $user->metas()->where('meta_key', 'company_id')->first();
            if($metaCompany) {
                $metaCompany->delete();
            }

            $userRelation = $user->companies()->where('company_id', $company->id)->first();
            if($userRelation) {
                $user->companies()->where('company_id', $company->id)->detach();
            }

            return back()->with('status', "Se ha removido al usuario {$user->name} de {$company->name} exitosamente.");
            
        } catch (Exception $e) {
            Log::info("Error al borrar metas de usuario: {$e->getMessage()}");
        }
    }

    public function addUserAjax(Request $request) {
        $inputs = $request->all();
        $user = User::find($inputs['user']);
        // $company = Company::find($inputs['company']);
        if($user->metas()->where('meta_key', 'company_id')->first()) {
            $user->companies()->attach($request->input('company'));
            return redirect()->route('company.show', ['id' => $inputs['company']])->with('status', "Se ha agregado el usuario {$user->name} correctamente a esta empresa.");
        } 

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
        $accounts = $company->accounts()->merge($company->executives);

        return response()->json($accounts);
    }

    public function delete (Request $request, $id) {
        $company = Company::findOrFail($id);
        $name = $company->name;
        
        $company->assignedNews()->delete();
        
        $company->newsletter->delete();
        
        $company->themes()->delete();

        if($company->children->isNotEmpty()){
            $company->children->each(function ($son){ 
                $son->parent = NULL;
                $son->save();
            });
        }

        
        if($company->accounts()->isNotEmpty()) {
            $company->accounts()->each(function ($user, $key){
                $metaCompany = $user->metas()->where('meta_key', 'company_id')->first();
                $metaCompany->delete();
            });
        }
        
        $company->delete();

        return redirect()->route('admin.sectors')->with('status', "¡La empresa {$name} se ha eliminado satisfactoriamente!. Asi como sus usuarios, temas,newsletters y noticias relacionadas");
    }

    public function updateAssignedNote(Request $request, $id) {

        $assigned = AssignedNews::findOrFail($id);
        $assigned->theme_id = $request->input('theme_id');
        $assigned->save();

        return back()->with('status', 'Se ha actualizado la nota');
    }
}
