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

use App\AssignedNews;
use App\Company;
use App\Http\Controllers\Auth\RegisterController;
use App\Means;
use App\News;
use App\Theme;
use App\Traits\StadisticsNotes;
use App\User;
use App\UserMeta;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    use StadisticsNotes;
    
    public function __construct(RegisterController $registerController)
    {

        $this->registerController = $registerController;
    }

    /**
     *
     * @method    index View showing all system users
     *
     * @author    Isaac Daniel Batista <daniel@danielbat.com>
     *
     * @param     Request $request
     *
     * @return    View
     */
    public function index(Request $request)
    {
        $paginate = $request->has('paginate') ? $request->input('paginate') : 25;
        
        $breadcrumb = array();
        array_push($breadcrumb, ['label' => 'Usuarios']);
        
        $query = User::query();
        $query->withTrashed()->orderBy('id', 'DESC')
            ->when($request->has('name') && !is_null($request->get('name')), function ($q) use ($request) {
                return $q->where('name', 'like', "%{$request->get('name')}%");
            })
            ->when($request->has('email') && !is_null($request->get('email')), function ($q) use ($request) {
                return $q->where('email', 'like', "%{$request->get('email')}%");
            })
            ->when($request->has('roll') && !is_null($request->get('roll')), function ($q) use ($request) {
                return $q->whereHas('roles', function (Builder $qry) use ($request) {
                            $qry->where('id', $request->get('roll'));
                });
            });
        $users = $query->paginate($paginate)
            ->appends('name', request('name'))
            ->appends('email', request('email'))
            ->appends('roll', request('roll'));
        
        return view('admin.user.index', compact('users', 'breadcrumb', 'paginate'));
    }

    public function show(Request $request, $id)
    {
        $profile = User::withTrashed()->where('id', $id)->first();

        if ($profile->deleted_at) {
            return redirect()->route('admin.user.edit', ['id' => $profile->id]);
        }

        $countNews = array();
        $date = Carbon::now()->toDateString();
        $allNews = News::count();
        $newsToday = News::whereDate('created_at', $date)->count();
        $newsSendToday = AssignedNews::whereDate('created_at', $date)->count();
        $notesActivity = false;
        $paginate = 15;
        $notes = null;
        $notesSent = null;
        $companies = null;
        $themes = null;
        $countNotes = array();
        $breadcrumb = array();


        if ($profile->isAdmin()) {
            $notes = News::orderBy('id', 'asc')->simplePaginate($paginate);
            $companies = Company::orderBy('id', 'asc')->simplePaginate($paginate);
            $themes = Theme::orderBy('name', 'desc')->simplePaginate(50);
            $countNotes = Arr::pluck($this->getNoteCountPerWeek()->toArray(), 'total');
            $countNews = [
                ['label' => 'Todas las noticias', 'value' => $allNews],
                ['label' => 'Noticias de hoy', 'value' => $newsToday],
                ['label' => 'Noticias enviadas hoy', 'value' => $newsSendToday],
                ['label' => 'Noticias sin enviar hoy', 'value' => ($newsToday - $newsSendToday)],
            ];
        } elseif ($profile->isExecutive()) {
            $countNews = [
                ['label' => 'Todas las noticias', 'value' => $allNews],
                ['label' => 'Noticias de hoy', 'value' => $newsToday],
                ['label' => 'Noticias enviadas hoy', 'value' => $newsSendToday],
            ];
            $companiesIds = $profile->companies->pluck('id');
            $notes = AssignedNews::with('news')->whereIn('company_id', $companiesIds)->simplePaginate($paginate);
            $companies = $profile->companies()->orderBy('id', 'asc')->simplePaginate($paginate);
            $themes = Theme::whereIn('company_id', $companiesIds)->simplePaginate(50);
            // $countNotes = Arr::pluck($this->getNoteCountPerWeekAndExecutiveRol($companiesIds));
            $countNotes = $this->getNoteCountPerWeekAndExecutiveRol($companiesIds, '2021-03-08')->toArray();
        } elseif ($profile->isClient()) {
            if ($profile->metas()->where('meta_key', 'company_id')->first()) {
                $countNews = [
                    ['label' => 'Total de noticias', 'value' => $profile->company()->assignedNewsCount()],
                    ['label' => 'Noticias enviadas hoy',
                        'value' => AssignedNews::where('company_id', $profile->company()->id)
                        ->whereDate('created_at', $date)->count()]
                ];
                $notes = AssignedNews::with('news')->where('company_id', $profile->company()->id)
                    ->simplePaginate($paginate);
            } else {
                $countNotes = [
                    ['label' => 'Total de noticias', 'value' => 0],
                    ['label' => 'Noticias enviadas hoy', 'value' => 0],
                ];
                $notes = collect();
            }
        } elseif ($profile->isMonitor()) {
            $countNews = [
                ['label' => 'Noticias capturadas', 'value' => News::where('user_id', $profile->id)->count()],
            ];
            $notes = $profile->news()->simplePaginate($paginate);
            $notesSent = $notes->filter(function ($note) {
                return $note->isAssigned();
            });
        }

        array_push($breadcrumb, ['label' => 'Usuarios', 'url' => route('users')]);
        array_push($breadcrumb, ['label' => $profile->name]);

        return view('admin.user.show', compact('profile', 'countNews', 'notes', 'notesSent', 'companies', 'themes', 'countNotes', 'breadcrumb'));
    }

    public function showFormNewUser()
    {
        
        $companies = Company::all();
        $monitors = Means::select('id', 'name')->get();
        $breadcrumb = array();

        array_push($breadcrumb, ['label' => 'Usuarios', 'url' => route('users')]);
        array_push($breadcrumb, ['label' => 'Nuevo usuario']);
        
        return view('admin.user.create', compact('companies', 'monitors', 'breadcrumb'));
    }

    public function validator($data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'rol' => 'required|integer',
            'user_position' => 'required|string|max:200',
            'monitor_type' => [
                            Rule::requiredIf(function () use ($data) {
                                $rol = $data['rol'];
                                if ($rol == 3) {
                                    return true;
                                }
                                return false;
                            }),
                              ],
            'company_id' => [
                            Rule::requiredIf(function () use ($data) {
                                $rol = $data['rol'];
                                if ($rol == 4) {
                                    return true;
                                }
                                return false;
                            }),
                            ],
        ]);
    }

    public function register(Request $request)
    {

        $inputs = $request->all();

        $this->validator($inputs)->validate();

        $user = $this->registerController->create($inputs);

        $role = Role::find($inputs['rol']);
        $user->assignRole($role);

        $meta_position = new UserMeta();
        $meta_position->meta_key = 'user_position';
        $meta_position->meta_value = $inputs['user_position'];
        $user->metas()->save($meta_position);

        $meta_pass = new UserMeta();
        $meta_pass->meta_key = 'user_password';
        $meta_pass->meta_value = Crypt::encryptString($inputs['password']);
        $user->metas()->save($meta_pass);

        if ($role->name == 'client') {
            $meta_company = new UserMeta();
            $meta_company->meta_key = 'company_id';
            $meta_company->meta_value = $inputs['company_id'];
            $user->metas()->save($meta_company);

            $company = Company::find($inputs['company_id']);
        }

        if ($role->name == 'monitor') {
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

    public function delete(Request $request, $id)
    {

        $user = User::findOrFail($id);
        $name = $user->name;
        $rol = Role::where('name', 'disable')->firstOrFail();
        $user->roles()->detach();
        $user->assignRole($rol);
        $user->delete();

        return redirect()->route('users')->with('status', "El usuario {$name} se ha eliminado satisfactoriamente");
    }

    public function addUserCompany(Request $request, $companyId)
    {
        $breadcrumb = array();
        $role = Role::where('name', 'client')->first();
        $company = Company::find($companyId);
        $accounts = $company->allAccountsOfACompany();
        
        array_push($breadcrumb, ['label' => 'Empresas', 'url' => route('companies')]);
        array_push($breadcrumb, ['label' => $company->name,
            'url' => route('company.show', ['id' => $company->id])]);
        array_push($breadcrumb, ['label' => 'Agregar Cuenta']);

        return view('admin.company.addUser', compact('company', 'role', 'accounts', 'breadcrumb'));
    }

    public function edit(Request $request, $id)
    {

        $user = User::withTrashed()->where('id', $id)->first();
        $monitors = Means::select('id', 'name')->get();
        $breadcrumb = array();
        
        array_push($breadcrumb, ['label' => 'Usuarios', 'url' => route('users')]);
        array_push($breadcrumb, ['label' => $user->name, 'url' => route('user.show', ['id' => $user->id])]);
        array_push($breadcrumb, ['label' => 'Editar']);

        return view('admin.user.edit', compact('user', 'monitors', 'breadcrumb'));
    }

    public function update(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);
            $data = $request->all();
            $user->name = $data['name'];
            if ($user->email != $data['email']) {
                $userValidationEmail = User::where('email', $data['email'])->get();
                if ($userValidationEmail->isEmpty()) {
                    $user->email = $data['email'];
                } else {
                    return back()->withInput()->with('status', "El correo {$data['email']} ya se encuentra registrado en nuestra base de datos, use otro correo.");
                }
            }
            if (!is_null($data['new_password'])) {
                $user->password = Hash::make($data['new_password']);
                $user->metas()->updateOrCreate(
                    ['user_id' => $user->id, 'meta_key' => 'user_password'],
                    ['meta_value' => Crypt::encryptString($data['new_password'])]
                );
            }

            foreach ($data as $key => $value) {
                if (Str::contains($key, 'user_')) {
                    if (!is_null($value)) {
                        $user->metas()->updateOrCreate(
                            ['user_id' => $user->id, 'meta_key' => $key],
                            ['meta_value' => $value]
                        );
                    }
                }
            }

            $user->save();
        } catch (Exception $e) {
            Log::error("User ERROR: {$e->getMessage()}");
        }
        
        return redirect()->route('user.show', ['id' => $user->id])->with('status', "Se ha actualizado la información de {$user->name} de forma correcta");
    }

    public function addCompanyToExecutive(Request $request)
    {
        try {
            $user = User::findOrFail($request->input('user_id'));
            $user->companies()->attach($request->input('company_id'));
            $company = Company::findOrFail($request->input('company_id'));
                
            return back()->with('status', "Se ha asociado al usuario {$user->name} con la empresa {$company->name}");
        } catch (QueryException $e) {
            Log::error("User ERROR: {$e->getMessage()}");
            return back()->with('error', "No se puede asociar");
        }
    }

    public function removeCAssigned(Request $request)
    {
        $user = User::findOrFail($request->input('user_id'));
        $user->companies()->detach($request->input('company_id'));
        $company = Company::findOrFail($request->input('company_id'));

        return back()->with('status', "Se ha desasociado la empresa {$company->name} de la cuenta de {$user->name}");
    }

    /**
     *
     * @method    restore Restore user
     *
     * @author    Isaac Daniel Batista <daniel@danielbat.com>
     *
     * @return    Redirect
     */
    public function restore($id)
    {
        $user = User::withTrashed()->where('id', '=', $id)->first();
        $user->restore();

        return redirect()->route('users')->with("status", "El usuario {$user->name} ha sido restaurado");
    }

    /**
     *
     * @method    forceDelete
     *
     * @author    Isaac Daniel Batista <daniel@danielbat.com>
     *
     * @param     $id   The user ID
     *
     * @return    Redirect
     */
    public function forceDelete($id)
    {
        $user = User::withTrashed()->where('id', '=', $id)->first();
        $user->metas()->delete();
        $user->forceDelete();

        return redirect()->route('users')->with("status", "El usuario se ha eliminado definitivamente");
    }
}
