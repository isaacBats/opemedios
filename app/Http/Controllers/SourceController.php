<?php

namespace App\Http\Controllers;

use App\Means;
use App\Source;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
        
        // TODO: crear un metodo para que estos campos (campos extra) se puedan guardad en la base de datos y dependiendo del medio se agregen o quiten campos, de esta forma se guardaian los campos extra sin necesidad de un switch y agregar un case mas en caso de agregar otro medio.
        $extra = $this->saveExtraFields($inputs, $mean);

        $source->extra_fields = serialize($extra);
        $source->save();

        return redirect()->route('sources')->with('status', '¡Exito!. La fuente se ha creado correctamente');
    }

    public function show(Request $request, $id) {

        $source = Source::find($id);
        $means = Means::all();
        $extras = unserialize($source->extra_fields);
        
        return view('admin.sources.show', compact('source', 'means', 'extras'));
    }

    public function update(Request $request, $id) {
        $inputs = $request->all(); 
        $source = Source::find($id);
        $mean = Means::find($source->means_id);

        $source->name = $inputs['name'];
        if(!empty($inputs['company'])) {
            $source->company = $inputs['company'];
        }
        $source->coverage = $inputs['coverage'];
        if(!empty($inputs['comment'])) {
            $source->comment = $inputs['comment'];
        }
        $extra = $this->saveExtraFields($inputs, $mean);
        $source->extra_fields = serialize($extra);
        $source->save();

        return redirect()->route('source.show', ['id' => $source->id])->with('status', '¡Exito!. La fuente se ha editado correctamente');

    }

    private function saveExtraFields($inputs, $mean) {
        $extra = array();
        switch($mean->short_name) {
            case 'tel':
                $extra = [
                    'Conductor' => $inputs['conductor_tv'],
                    'Canal' => $inputs['channel'],
                    'Horario' => $inputs['schedule_tv'],
                    'Señal' => $inputs['signal'],
                ];
                break;
            case 'rad': 
                $extra = [
                    'Conductor' => $inputs['conductor'],
                    'Estación' => $inputs['station'],
                    'Horario' => $inputs['schedule'],
                ];
                break;
            case 'per':
                $extra = ['Tiraje' => $inputs['printing_per'],];
                break;
            case 'rev':
                $extra = ['Tiraje' => $inputs['printing_rev'],];
                break;
            case 'int':
                $extra = ['Url' => $inputs['url'],];
                break;
        }

        return $extra;
    }

    public function updateLogo(Request $request, $id) {
        $source = Source::find($id);
        
        Validator::make($request->all(), [
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|dimensions:max_width=300,max_height=150',
        ], [
            'required' => 'El :attribute es necesario.',
            'dimensions' => 'El logo debe de ser de 300x150 máximo'
        ])->validate();
        try {
            if(Storage::exists($source->logo)) {
                Storage::delete($source->logo);
            } 
            
            $source->logo = $request->file('logo')->store('sources_logos');
            $source->save();
            
        } catch (Exception $e) {
            return back()->with('status', 'Could not update image: ' . $e->getMessage());
        }

        return redirect()->route('source.show', ['id' => $source->id])->with('status', '¡Exito!. Se ha cambiado el logo correctamente');
    }
}
