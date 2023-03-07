<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    // protected $redirectTo = '/panel';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view('auth.custom-login');
    }

    protected function redirectTo()
    {

        $user = auth()->user();

        $role = Role::find(1);
        $user->assignRole($role);

        if ($user->isClient()) {
            $metas = $user->metas()->where(['meta_key' => 'company_id'])->first();
            $company = Company::find($metas->meta_value);
            $slug = $company->slug;
            session()->put('slug_company', $slug);

            return "{$slug}/mis-noticias";
        }

        if ($user->hasRole('admin') || $user->hasRole('manager')) {
            $path = '/panel';
        } elseif ($user->hasRole('monitor')) {
            $path = '/panel/noticias';
        }

        return $path;
    }

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateLogin(Request $request)
    {
        $request->validate(
            [
                $this->username() => 'required|string',
                'password' => 'required|string',
                'g-recaptcha-response'  => 'required|captcha'
            ],
            [
                'g-recaptcha-response.required' => 'Es necesario el captcha.',
                'g-recaptcha-response.captcha'  => 'Captcha error! Prueba de nuevo mas tarde.'
            ]
        );
    }
}
