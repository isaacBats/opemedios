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
  * Type: Class
  * Description: UserController
  *
  * For the full copyright and license information, please view the LICENSE
  * file that was distributed with this source code.
  */
        


namespace App\Http\Controllers;

use App\Company;
use App\Http\Controllers\Auth\RegisterController;
use App\Means;
use App\User;
use App\UserMeta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    
    public function __construct(RegisterController $registerController) {

        $this->registerController = $registerController;
    }

    public function index () {
        
        $users = User::orderBy('id', 'DESC')->paginate(25);

        return view('admin.user.index', compact('users'));
    }

    public function show (Request $request, $id) {
        $profile = User::find($id);

        return view('admin.user.show', compact('profile'));
    }

    public function showFormNewUser() {
        
        $companies = Company::all();

        $monitors = Means::select('id','name')->get();
        
        return view('admin.user.create', compact('companies', 'monitors'));
    }

    public function validator($data) {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'rol' => 'required|integer',
            'user_position' => 'required|string|max:200',
            'monitor_type' => [
                            Rule::requiredIf(function() use ($data){
                                $rol = $data['rol'];
                                if ($rol == 3) {
                                    return true;
                                } 
                                return false;
                            }),
                              ],
            'company_id' => [
                            Rule::requiredIf(function() use ($data){
                                $rol = $data['rol'];
                                if ($rol == 4) {
                                    return true;
                                } 
                                return false;
                            }),
                            ],
        ]);
    }

    public function register (Request $request) {

        $inputs = $request->all();

        $this->validator($inputs)->validate();

        $user = $this->registerController->create($inputs);

        $role = Role::find($inputs['rol']);
        $user->assignRole($role);

        $meta_position = new UserMeta();
        $meta_position->meta_key = 'user_position';
        $meta_position->meta_value = $inputs['user_position'];
        $user->metas()->save($meta_position);

        if($role->name == 'client') {
            $meta_company = new UserMeta();
            $meta_company->meta_key = 'company_id';
            $meta_company->meta_value = $inputs['company_id'];
            $user->metas()->save($meta_company);

            $company = Company::find($inputs['company_id']);

            $oldCompany = DB::connection('opemediosold')->table('empresa')
                ->where('nombre', 'like', "%{$company->name}%")
                ->first();
            
            if($oldCompany) {
                $meta_old_company = new UserMeta();
                $meta_old_company->meta_key = 'old_company_id';
                $meta_old_company->meta_value = $oldCompany->id_empresa;
                $user->metas()->save($meta_old_company);
            }
        }

        if($role->name == 'monitor') {
            $meta_monitor_type = new UserMeta();
            $meta_monitor_type->meta_key = 'user_monitor_type';
            $meta_monitor_type->meta_value = $inputs['monitor_type'];
            $user->metas()->save($meta_monitor_type);
        }

        if ($request->has('company_route')) {
            return redirect()->route('company.show', ['id' => $company->id])->with('status', 'Usuario agregado satisfactoriamente');
        } else {
            return redirect()->route('users')->with('status', 'Usuario creado satisfactoriamente');
        }
    }

    public function delete(Request $request, $id) {

        $user = User::findOrFail($id);
        $name = $user->name;
        $rol = Role::where('name', 'disable')->firstOrFail();
        $user->roles()->detach();
        $user->assignRole($rol);
        // no se eliminan las metas, por si en algun momento se quiere activar
        // $user->metas()->detach();
        $user->delete();

        return redirect()->route('users')->with('status', "El usuario {$name} se ha eliminado satisfactoriamente");
    }

    public function addUserCompany(Request $request, $companyId) {
        $role = Role::where('name', 'client')->first();
        $company = Company::find($companyId);

        $clients = User::role($role)->get();

        return view('admin.company.addUser', compact('company', 'role', 'clients')); 
    }

    public function edit(Request $request, $id) {

        $user = User::findOrFail($id);
        $monitors = Means::select('id','name')->get();

        return view('admin.user.edit', compact('user', 'monitors'));
    }

    public function update(Request $request, $id) {
        $user = User::findOrFail($id);
        $data = $request->all();
        
        $user->name = $data['name'];
        $user->email = $data['email'];

        if(!is_null($data['password']) && !is_null($data['new_password'])) {
            if(Hash::check($data['password'], $user->password)) {
                $user->password = Hash::make($data['new_password']);
            } else {
                Session::flash('error', 'No es posible cambiar la contraseña. Intente mas tarde');
            }
        }
        foreach ($data as $key => $value) {
            if(Str::contains($key, 'user_')) {
                if(!is_null($value)) {
                    $user->metas()->updateOrCreate(
                        ['meta_key' => $key, 'meta_value' => $value]
                    );
                }
            }
        }

        $user->save();
        
        return redirect()->route('user.show', ['id' => $user->id])->with('status', "Se ha actualizado la información de {$user->name} de forma correcta");
    }
}
