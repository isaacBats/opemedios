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

use App\Models\Means;
use App\Models\Source;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SourceController extends Controller
{
    public function index(Request $request) {
        $paginate = $request->has('paginate') ? $request->input('paginate') : 25;

        $breadcrumb = array();
        array_push($breadcrumb,['label' => 'Fuentes']);

        $sources = Source::name($request->get('name'))
            ->company($request->get('company'))
            ->orderBy('id', 'desc')
            ->paginate($paginate)
            ->appends('name', request('name'))
            ->appends('company', request('company'));

        return view('admin.sources.index', compact('sources', 'paginate', 'breadcrumb'));
    }

    public function showForm() {
        $means = Means::all();
        $breadcrumb = array();

        array_push($breadcrumb, ['label' => 'Fuentes', 'url' => route('sources')]);
        array_push($breadcrumb, ['label' => 'Nueva Fuente']);

        return view('admin.sources.create', compact('means', 'breadcrumb'));
    }

    public function create(Request $request) {
        $inputs = $request->all();

        Validator::make($inputs, [
            'name' => 'required|max:150',
            'coverage' => 'required',
            'means_id' => 'required',
        ], [
            'name.required' => 'El nombre de la fuente es requerido.',
            'required' => 'El :attribute es necesario.',
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

        if($request->file('logo')){
            $source->logo = $request->file('logo')->store('sources_logos', 'local');
        } else {
            $source->logo = 'sources_logos/default.png';
        }

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
        $breadcrumb = array();

        array_push($breadcrumb, ['label' => 'Fuentes', 'url' => route('sources')]);
        array_push($breadcrumb, ['label' => $source->name]);

        return view('admin.sources.show', compact('source', 'means', 'extras', 'breadcrumb'));
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
            'logo' => 'required|mimes:jpeg,png,jpg,svg,bmp,webp|dimensions:max_width=300,max_height=150',
        ], [
            'required' => 'El :attribute es necesario.',
            'dimensions' => 'El logo debe de ser de 300x150 máximo'
        ])->validate();
        try {
            if(Storage::drive('local')->exists($source->logo)) {
                Storage::drive('local')->delete($source->logo);
            }

            $source->logo = $request->file('logo')->store('sources_logos', 'local');
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

    public function sendSelectHTMLWithSourcesByMeanType(Request $request) {

        $sources = Source::where([
                ['means_id', '=', $request->input('mean_id')],
                ['active', '=', 1],
            ])->orderBy('id', 'desc')
            ->limit(150)->get();

        return view('components.select-form-sources', compact('sources'))->render();
    }

    public function getSourceByAjax (Request $request) {

        return response()->json(['items' => Source::select('id', 'name AS text')->where([
                ['name', 'like', "%{$request->input('q')}%"],
                ['means_id', '=', $request->input('mean_id')],
                ['active', '=', 1],
            ])->get()->toArray()
        ]);
    }
}
