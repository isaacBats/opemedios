<?php

namespace App\Http\Controllers\Auth;

use App\Company;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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

    protected function redirectTo () {
        
        $user = auth()->user();
        $is_client = $user->hasRole('client');
        
        if($is_client) {
            $metas = $user->metas()->where(['meta_key' => 'company_id'])->first();
            $company = Company::find($metas->meta_value);
            $slug = $company->slug;
            session()->put('slug_company', $slug);
            
            return "{$slug}/dashboard";
        }

        return '/panel';
    }
}
