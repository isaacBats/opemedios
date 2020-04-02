<?php

namespace App\Http\Controllers;

use App\Means;
use App\Source;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SourceController extends Controller
{
    public function index() {

        $sources = Source::all();
        return view('admin.sources.index', compact('sources'));
    }

    public function showForm() {
        $means = Means::all();

        return view('admin.sources.create', compact('means'));
    }

    public function create(Request $request) {
        $inputs = $request->all();

        Validator::make($inputs, [
            'name' => 'required|max:150',
            'coverage' => 'required',
            'means_id' => 'required',
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|dimensions:max_width=300,max_height=150',
        ], [
            'name.required' => 'El nombre de la fuente es requerido.',
            'required' => 'El :attribute es necesario.',
            'dimensions' => 'El logo debe de ser de 300x150 máximo'
        ])->validate();

        $mean = Means::find($inputs['means_id']);
        $source = new Source();
        $source->name = $inputs['name'];
        if(!empty($inputs['company'])) {
            $source->company = $inputs['company'];
        }
        $source->means_id = $inputs['means_id'];
        $source->coverage = $inputs['coverage'];
        if(!empty($inputs['comment'])) {
            $source->comment = $inputs['comment'];
        }
        $source->active = 1;
        $source->logo = $request->file('logo')->store('sources_logos');
        $extra = array();
        // TODO: crear un metodo para que estos campos (campos extra) se puedan guardad en la base de datos y dependiendo del medio se agregen o quiten campos, de esta forma se guardaian los campos extra sin necesidad de un switch y agregar un case mas en caso de agregar otro medio.
        switch($mean->short_name) {
            case 'tel':
                $extra = [
                    'conductor_tv' => $inputs['conductor_tv'],
                    'channel' => $inputs['channel'],
                    'schedule_tv' => $inputs['schedule_tv'],
                    'signal' => $inputs['signal'],
                ];
                break;
            case 'rad': 
                $extra = [
                    'conductor' => $inputs['conductor'],
                    'station' => $inputs['station'],
                    'schedule' => $inputs['schedule'],
                ];
                break;
            case 'per':
                $extra = ['printing_per' => $inputs['printing_per'],];
                break;
            case 'rev':
                $extra = ['printing_rev' => $inputs['printing_rev'],];
                break;
            case 'int':
                $extra = ['url' => $inputs['url'],];
                break;
        }

        $source->extra_fields = serialize($extra);
        $source->save();

        return redirect()->route('sources')->with('status', '¡Exito!. La fuente se ha creado correctamente');
    }
}
