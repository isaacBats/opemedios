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
use App\Models\{AssignedNews, Company, Turn, User, UserMeta, Theme, Artist, ArtistMeans, Book, BookMeans, News, Means, Movie, MovieMeans, TasksBoard, ThemeMeans};
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

        $means = Means::orderBy('name', 'DESC')->get();
        $companies = Company::name($request->get('name'))
            ->orderBy('id', 'DESC')
            ->get();

            
        $libros_id = Turn::where('name', 'Editorial')->first()->id;
        $companies_libros = Company::where('turn_id', $libros_id)->orderBy('name')->get();
        
        $peliculas_id = Turn::where('name', 'Cine')->first()->id;
        $companies_peliculas = Company::where('turn_id', $peliculas_id)->orderBy('name')->get();

        $por_realizar  = TasksBoard::where('column_id', 1)->orderBy('position')->get();
        $fijas         = TasksBoard::where('column_id', 2)->orderBy('position')->get();
        $realizadas    = TasksBoard::where('column_id', 3)->orderBy('position')->get();
        $trash         = TasksBoard::where('column_id', 4)->orderBy('position')->get();


        return view('admin.clientes.index', compact('companies', 'means', 'companies_libros', 'companies_peliculas', 'breadcrumb', 'paginate', 'por_realizar', 'fijas', 'realizadas', 'trash'));
    }

    public function getLibros(Request $request)
    {
        $paginate = $request->has('paginate') ? $request->input('paginate') : 25;

        // $libros_id = Turn::where('name', 'Editorial')->first()->id;
        // $libros = Theme::whereIn('company_id', Company::where('turn_id', $libros_id)->pluck('id'))->with('means','company');
        $libros = Book::whereNotNull('company_id')->with('means','company');

        $search = $request->has('search') ? $request->input('search') : '';
        if(!empty($search)) $libros = $libros->where('name', 'like', '%' . $search . '%');

        $libros = $libros->paginate($paginate);
       
        $html_pag = '' . $libros->links();

        return response()->json(['items' => $libros, 'pagination' => $html_pag]);
    }

    public function getPeliculas(Request $request)
    {
        $paginate = $request->has('paginate') ? $request->input('paginate') : 25;

        // $peliculas_id = Turn::where('name', 'Cine')->first()->id;
        // $peliculas = Theme::whereIn('company_id', Company::where('turn_id', $peliculas_id)->pluck('id'))->with('means', 'company');
        $peliculas = Movie::whereNotNull('company_id')->with('means','company');
                
        $search = $request->has('search') ? $request->input('search') : '';
        if(!empty($search)) $peliculas = $peliculas->where('name', 'like', '%' . $search . '%');

        $peliculas = $peliculas->paginate($paginate);
        $html_pag = '' . $peliculas->links();

        return response()->json(['items' => $peliculas, 'pagination' => $html_pag]);
    }

    public function getArtistas(Request $request)
    {
        $paginate = $request->has('paginate') ? $request->input('paginate') : 25;
        $search = $request->has('search') ? $request->input('search') : '';
        
        if(!empty($search))
        {
            $artistas = Artist::where('name', 'like', '%' . $search . '%')->with('means','company')->paginate($paginate);
        }else{
            $artistas = Artist::with('means','company')->paginate($paginate);
        }

        $html_pag = '' . $artistas->links();

        return response()->json(['items' => $artistas, 'pagination' => $html_pag]);
    }

    public function storeArtist(StoreArtistRequest $request)
    {
        $artist = Artist::create($request->validated());
        
        foreach($request->means_id as $itm)
        {
            $rel = new ArtistMeans;
            $rel->artist_id = $artist->id;
            $rel->mean_id = $itm;
            $rel->save();
        }

        $response['status'] = "El artista: {$artist->name} se ha creado satisfactoriamente!";
        return response()->json($response);
    }
    
    public function updateArtist($id, StoreArtistRequest $request)
    {
        $artist = Artist::find($id);

        $artist->name = $request->name;
        $artist->company_id = $request->company_id;
        $artist->save();

        ArtistMeans::where('artist_id', $id)->delete();
        foreach($request->means_id as $itm)
        {
            $rel = new ArtistMeans;
            $rel->artist_id = $id;
            $rel->mean_id = $itm;
            $rel->save();
        }

        $response['status'] = "El artista: {$artist->name} se ha actualizado satisfactoriamente!";
        return response()->json($response);
    }
    
    public function storeLibro(Request $request)
    {
        $libro = Book::create([
            'name' => $request->name,
            'description' => $request->descripcion,
            'company_id' => $request->company_id,
        ]);
        
        foreach($request->means_id as $itm)
        {
            $rel = new BookMeans;
            $rel->book_id = $libro->id;
            $rel->mean_id = $itm;
            $rel->save();
        }

        $response['status'] = "El libro: {$libro->name} se ha creado satisfactoriamente!";
        return response()->json($response);
    }
    
    public function updateLibro($id, Request $request)
    {
        $libro = Book::find($id);

        $libro->name = $request->name;
        $libro->description = $request->descripcion;
        $libro->company_id = $request->company_id;
        $libro->save();
        
        BookMeans::where('book_id', $id)->delete();
        foreach($request->means_id as $itm)
        {
            $rel = new BookMeans;
            $rel->book_id = $libro->id;
            $rel->mean_id = $itm;
            $rel->save();
        }


        $response['status'] = "El libro: {$libro->name} se ha actualizado satisfactoriamente!";
        return response()->json($response);
    }
    
    
    public function storePelicula(Request $request)
    {
        $pelicula = Movie::create([
            'name' => $request->name,
            'description' => $request->descripcion,
            'company_id' => $request->company_id,
        ]);

        foreach($request->means_id as $itm)
        {
            $rel = new MovieMeans;
            $rel->movie_id = $pelicula->id;
            $rel->mean_id = $itm;
            $rel->save();
        }


        $response['status'] = "La pelicula: {$pelicula->name} se ha creado satisfactoriamente!";
        return response()->json($response);
    }
    
    public function updatePelicula($id, Request $request)
    {
        $pelicula = Movie::find($id);

        $pelicula->name = $request->name;
        $pelicula->description = $request->descripcion;
        $pelicula->company_id = $request->company_id;
        $pelicula->save();

        MovieMeans::where('movie_id', $id)->delete();
        foreach($request->means_id as $itm)
        {
            $rel = new MovieMeans;
            $rel->movie_id = $pelicula->id;
            $rel->mean_id = $itm;
            $rel->save();
        }

        $response['status'] = "La pelicula: {$pelicula->name} se ha actualizado satisfactoriamente!";
        return response()->json($response);
    }
    

    public function saveTask(Request $request)
    {
        $bottom_task = TasksBoard::where('column_id', 1)->orderBy('position', 'desc')->first();

        $task = new TasksBoard;
        $task->position = $bottom_task ? ($bottom_task->position + 1) : 1;
        $task->column_id = 1;
        $task->task = $request->task;
        $task->titulo = $request->titulo;
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

    public function removeLibros(Request $request)
    {
        $id = $request->id;
        
        $itm = Book::find($id);
        $itm->delete();

        $response['status'] = "Ok";
        return response()->json($response);
    }

    public function removePeliculas(Request $request)
    {
        $id = $request->id;
        
        $itm = Movie::find($id);
        $itm->delete();

        $response['status'] = "Ok";
        return response()->json($response);
    }

    public function removeArtistas(Request $request)
    {
        $itm = Artist::find($request->id);
        $itm->delete();

        $response['status'] = "Ok";
        return response()->json($response);
    }

}
