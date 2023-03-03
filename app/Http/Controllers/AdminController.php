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

use App\Models\Company;
use App\Models\News;
use App\Models\Sector;
use App\Models\Source;
use App\Models\User;
use App\Traits\StadisticsNotes;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    use StadisticsNotes;
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
        $day = \Carbon\Carbon::now()->format('Y-m-d');

        $monitores = $this->getNewsForMonitor($day);

        return view('admin.home', compact('count', 'monitores', 'day'));
    }

    public function notesPerDay() {

        return response()->json($this->getNoteCountPerWeek());
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

    public function redirectTo(Request $request) {

        $company = Company::findOrFail($request->input('company'));
        $slug = $company->slug;
        session()->put('slug_company', $slug);
        return redirect()->action('ClientController@index', ['company' => $slug]);
    }

    public function notesPerMean() {
        $notas = $this->getNotesForMeanAndWeek();

        return response()->json(['labels' => array_keys($notas->toArray()), 'data' => array_values($notas->toArray())]);
    }

}
