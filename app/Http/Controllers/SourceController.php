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

use App\Means;
use App\Section;
use App\Source;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

    public function delete(Request $request, $id) {
        $source = Source::find($id);
        $sourceName = $source->name;
        $source->delete();

        return redirect()->route('sources')->with('status', "¡La fuente: {$sourceName} se ha eliminado satisfactoriamente!");
    }

    public function status(Request $request, $id) {
        $source = Source::find($id);
        try {
            $source->active = $request->input('status');
            $status = $request->input('status') ? 'Activa' : 'Inactiva';
            $source->save();
            
            return response()->json(['message' => "La fuente a quedado {$status}"]);
        } catch (Exception $e) {
            return response()->json(['error' => "Error al actualizar el estatus de la fuente"]);
        }
    }

    public function migrationSources(){
        $oldSources = DB::connection('opemediosold')->table('fuente')->where('id_fuente', '>', 5340)->get();
        $count = array();
        $count['fuentes'] = 0;
        $count['secciones'] = 0;
        try {
            foreach ($oldSources as $oldSource) {
                $source = new Source();
                $source->name = $oldSource->nombre;
                $source->company = $oldSource->empresa;
                $source->comment = $oldSource->comentario;
                $source->active = $oldSource->activo;
                $source->means_id = $oldSource->id_tipo_fuente;
                if($oldSource->id_cobertura == 1)
                    $source->coverage = 'Local';
                elseif($oldSource->id_cobertura == 2)
                    $source->coverage = 'Nacional';
                else
                    $source->coverage = 'Internacional';

                $extra = array();
                if($oldSource->id_tipo_fuente == 1){
                    $extrasTV = DB::connection('opemediosold')->table('fuente_tel')->where('id_fuente', $oldSource->id_fuente)->first();
                    $extra = [
                        'Conductor' => $extrasTV->conductor,
                        'Canal' => $extrasTV->canal,
                        'Horario' => $extrasTV->horario,
                        'Señal' => rand(1,3),
                    ];
                }elseif($oldSource->id_tipo_fuente == 2){
                    $extrasRad = DB::connection('opemediosold')->table('fuente_rad')->where('id_fuente', $oldSource->id_fuente)->first();
                    $extra = [
                        'Conductor' => $extrasRad->conductor,
                        'Estación' => $extrasRad->estacion,
                        'Horario' => $extrasRad->horario,
                    ];
                }elseif($oldSource->id_tipo_fuente == 3){
                    $extrasPer = DB::connection('opemediosold')->table('fuente_per')->where('id_fuente', $oldSource->id_fuente)->first();
                    $extra = ['Tiraje' => $extrasPer->tiraje,];
                }elseif($oldSource->id_tipo_fuente == 4){
                    $extrasRev = DB::connection('opemediosold')->table('fuente_rev')->where('id_fuente', $oldSource->id_fuente)->first();
                    $extra = ['Tiraje' => $extrasRev->tiraje,];
                }elseif($oldSource->id_tipo_fuente == 5){
                    $extrasInt = DB::connection('opemediosold')->table('fuente_int')->where('id_fuente', $oldSource->id_fuente)->first();
                    $extra = ['Url' => $extrasInt->url,];
                }

                $source->extra_fields = serialize($extra);
                $source->save();
                $count['fuentes'] ++;

                $oldSections = DB::connection('opemediosold')->table('seccion')->where('id_fuente', $oldSource->id_fuente)->get();
                foreach ($oldSections as $oldSection) {
                    $section = new Section();
                    $section->name = $oldSection->nombre;
                    $section->description = $oldSection->descripcion;
                    $section->active = $oldSection->activo;
                    $section->source_id = $source->id;
                    $section->save();
                    $count['secciones']++;
                }
            }
        } catch (Exception $e) {
            Log::error("Hay un error con una fuente {$e->getMessage()}");
        }

        echo 'Numero de fuentes y secciones agregadas';
        var_dump($count);
    }
}
