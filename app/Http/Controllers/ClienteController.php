<?php
/**
  *-------------------------------------------------------------------------------------
  * Developer Information
  *-------------------------------------------------------------------------------------
  * @author Josue Martinez <mtzarenas2012@gmail.com>
  * @copyright 2024
  * @version 1.0.0
  * @package App\
  * Type: Controller
  * Description: Description
  *
  * For the full copyright and license information, please view the LICENSE
  * file that was distributed with this source code.
  */

namespace App\Http\Controllers;

use App\Http\Requests\StoreArtistRequest;
use App\Models\{AssignedNews, Company, Turn, User, UserMeta, Theme, Artist, News, Means, TasksBoard};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Log,Storage};
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Validator;
use Illuminate\Support\Facades\{DB, URL};

class ClienteController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
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


        $por_realizar  = TasksBoard::where('column_id', 1)->orderBy('position')->get();
        $fijas         = TasksBoard::where('column_id', 2)->orderBy('position')->get();
        $realizadas    = TasksBoard::where('column_id', 3)->orderBy('position')->get();
        $trash         = TasksBoard::where('column_id', 4)->orderBy('position')->get();


        return view('admin.clientes.index', compact('companies', 'breadcrumb', 'paginate', 'por_realizar', 'fijas', 'realizadas', 'trash'));
    }

    public function getLibros(Request $request)
    {
        $paginate = $request->has('paginate') ? $request->input('paginate') : 25;

        $libros_id = Turn::where('name', 'Editorial')->first()->id;
        $libros = Theme::whereIn('company_id', Company::where('turn_id', $libros_id)->pluck('id'))->paginate($paginate);

        // $html = '';
        // foreach($libros as $itm)
        // {
        //     $html .= '' .
        //     '<li>' .
        //         '<a href="' . route('theme.show', ['theme' => $itm ]) . '">'. $itm->name . '</a>' .
        //     '</li>';
        // }
        // $html = '<div class="table-responsive"><ul class="tag-list">' . $html .'</ul></div>' . $libros->links();

        // return response()->json($html);
        
        $html = '';
        foreach($libros as $itm)
        {
            $html .= '<tr>' .
            '<td>' .
                '<a href="' . route('theme.show', ['theme' => $itm ]) . '">'. $itm->name . '</a>' .
            '</td>';

            $qry = 'select means.id, means.name from means join news on means.id = news.mean_id
                join assigned_news ass_n on ass_n.news_id = news.id where ass_n.company_id = '.$itm->company_id.' and ass_n.theme_id = '.$itm->id.' group by means.id, means.name;';

            $means = DB::select($qry);
            $html .= '<td>'.
                    '<ul class="tag-list">';
            foreach($means as $it)
            {
                $html .= 
                    '<li>' .
                        $it->name .
                    '</li>';
            }
            $html .= '</ul></td>';

            $html .= '</tr>';
        }
        $html = '<div class="table-responsive"><table class="table table-bordered table-primary table-striped nomargin"><thead><tr><th>Libros</th><th>Medios</th></tr></thead><tbody>' . $html .'</tbody></table></div>' . $libros->links();

        return response()->json($html);
    }

    public function getPeliculas(Request $request)
    {
        $paginate = $request->has('paginate') ? $request->input('paginate') : 25;

        $peliculas_id = Turn::where('name', 'Cine')->first()->id;
        $peliculas = Theme::whereIn('company_id', Company::where('turn_id', $peliculas_id)->pluck('id'))->paginate($paginate);
                
        $html = '';
        foreach($peliculas as $itm)
        {
            $html .= '<tr>' .
            '<td>' .
                '<a href="' . route('theme.show', ['theme' => $itm ]) . '">'. $itm->name . '</a>' .
            '</td>';

            $qry = 'select means.id, means.name from means join news on means.id = news.mean_id
                join assigned_news ass_n on ass_n.news_id = news.id where ass_n.company_id = '.$itm->company_id.' group by means.id, means.name;';

            $means = DB::select($qry);
            $html .= '<td>'.
                    '<ul class="tag-list">';
            foreach($means as $it)
            {
                $html .= 
                    '<li>' .
                        $it->name .
                    '</li>';
            }
            $html .= '</ul></td>';

            $html .= '</tr>';
        }
        $html = '<div class="table-responsive"><table class="table table-bordered table-primary table-striped nomargin"><thead><tr><th>Peliculas</th><th>Medios</th></tr></thead><tbody>' . $html .'</tbody></table></div>' . $peliculas->links();

        return response()->json($html);
    }

    public function getArtistas(Request $request)
    {
        $paginate = $request->has('paginate') ? $request->input('paginate') : 25;
        $search = $request->has('search') ? $request->input('search') : '';
        
        if(!empty($search))
        {
            $artistas = Artist::where('name', 'like', '%' . $search . '%')->paginate($paginate);
        }else{
            $artistas = Artist::paginate($paginate);
        }

        $html = '';
        foreach($artistas as $itm)
        {
            $html .= '' .
            '<tr>' .
                '<td>' .
                    //'<a href="' . route('theme.show', ['theme' => $itm ]) . '">'. $itm->name . '</a>' .
                    $itm->name .
                '</td>' .
                '<td>' .
                    $itm->company->name .
                '</td>' .
                '<td>' .
                    //$itm->company->name .
                '</td>' .
            '</tr>';
        }
        $html = '<div class="table-responsive"><table class="table table-bordered table-primary table-striped nomargin"><thead><tr><th>Artista</th><th>Compañia</th><th>Medios</th></tr></thead><tbody>' . $html .'</tbody></table></div>' . $artistas->links();

        return response()->json($html);
    }

    public function storeArtist(StoreArtistRequest $request)
    {
        $artist = Artist::create($request->validated());
        $response['status'] = "El artista: {$artist->name} se ha creado satisfactoriamente!";
        return response()->json($response);
    }

    public function saveTask(Request $request)
    {
        $bottom_task = TasksBoard::where('column_id', 1)->orderBy('position', 'desc')->first();

        $task = new TasksBoard;
        $task->position = $bottom_task ? ($bottom_task->position + 1) : 1;
        $task->column_id = 1;
        $task->task = $request->task;
        $task->company_id = $request->company_id;
        $task->user_id = auth()->user()->id;
        $task->save();

        $response['id'] = $task->id;
        $response['status'] = "Ok";
        return response()->json($response);
    }

    public function updateTask(Request $request)
    {
        if($request->bottom_task)
        {
            $bottom_task = TasksBoard::find($request->bottom_task);
            $move_task = TasksBoard::find($request->task_id);

            $move_task->position = $bottom_task->position;
            $move_task->column_id = $request->new_section;
            $move_task->save();
            
            $bottom_task->position = $move_task->position + 1;
            $bottom_task->save();
        }else{

            $bottom_task = TasksBoard::where('column_id', $request->new_section)->orderBy('position', 'desc')->first();
            $move_task = TasksBoard::find($request->task_id);

            $move_task->position = $bottom_task ? ($bottom_task->position + 1) : 1;
            $move_task->column_id = $request->new_section;
            $move_task->save();
            
        }

        $response['status'] = "Ok";
        return response()->json($response);
    }

}
