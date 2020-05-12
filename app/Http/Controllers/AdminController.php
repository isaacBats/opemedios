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
use App\Source;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $count['clients'] = Company::all()->count();
        $count['users'] = User::all()->count();
        $count['news'] = DB::connection('opemediosold')->table('noticia')->count();
        return view('admin.home', compact('count'));
    }

    public function search (Request $request) {
        $value = $request->get('inputValue');
        if($request->get('uri') == 'fuentes') {
            $sources = Source::where('name', 'LIKE', "%{$request->get('query')}%")
                ->orWhere('company', 'LIKE', "%{$request->get('query')}%")
                ->orWhere('comment', 'LIKE', "%{$request->get('query')}%")->paginate(25);

            return view('admin.sources.table_sources', compact('sources'))->render();
        } elseif($request->get('uri') == 'empresas') {
            // ...
        }
    }


}
