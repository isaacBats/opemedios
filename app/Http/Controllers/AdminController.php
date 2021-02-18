<?php
/**
  *-------------------------------------------------------------------------------------
  * Developer Information
  *-------------------------------------------------------------------------------------
  * @author Isaac Daniel Batista <daniel@danielbat.com>
  * @link https://danielbat.com Web Autor's site
  * @see https://twitter.com/codeisaac <@codeisaac>
  * @copyright 2020
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
use App\News;
use App\Sector;
use App\Source;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $count = array();
        $count['clients'] = Company::count();
        $count['users'] = User::count();
        $count['news'] = News::count();
        $count['sources'] = Source::count();
        $count['sectors'] = Sector::count();
        return view('admin.home', compact('count'));
    }

    public function search (Request $request) {
        $value = $request->get('inputValue');
        if($request->get('uri') == 'fuentes') {
            $sources = Source::where('name', 'LIKE', "%{$request->get('query')}%")
                ->orWhere('company', 'LIKE', "%{$request->get('query')}%")
                ->orWhere('comment', 'LIKE', "%{$request->get('query')}%")
                ->orderBy('id', 'desc')
                ->paginate(25);
            $sources->setPath("/panel/fuentes?query={$request->get('query')}&uri={$request->get('uri')}");

            return view('admin.sources.table_sources', compact('sources'))->render();
        } elseif($request->get('uri') == 'empresas') {
            // ...
        }
    }

    public function managerAccess(Request $request) {

        try {
            $user = $request->user();
            return view('manager', compact('user'));

        } catch (Exception $e) {
            Log::error("Admin ERROR: {$e->getMessage()}");
            return redirect()->route('home')->with('status', 'Paso algo inesperado. Intente más tarde');
        }
    }

    public function redirectTo(Request $request) {

        if(Auth::attempt([$request->input('email'), $request->input('password')])){
            
            if( $request->input('access_type') == 'client' ) {
                $company = Company::findOrFail($request->input('client_id'));
                $slug = $company->slug;
                session()->put('slug_company', $slug);
                return redirect("{$slug}/dashboard");
            }
            
            return redirect()->route('panel');
        }

    }

}
