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
use App\User;
use App\UserMeta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    
    public function __construct(RegisterController $registerController) {

        $this->registerController = $registerController;
    }

    public function index () {
        
        $users = User::select()->paginate(25);

        return view('admin.user.index', compact('users'));
    }

    public function show (Request $request, $id) {
        $profile = User::find($id);

        return view('admin.user.show', compact('profile'));
    }

    public function showFormNewUser() {
        
        $companies = Company::all();
        
        return view('admin.user.create', compact('companies'));
    }

    public function register (Request $request) {

        $inputs = $request->all();

        $this->registerController->validator($inputs)->validate();

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
}
