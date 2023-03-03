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

use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SectionController extends Controller
{
    const ACTIVE = 1;

    const INACIVE = 0;

    public function create (Request $request) {
        $inputs = $request->all();

        Validator::make($inputs, ['name' => 'required',],['required' => 'El :attribute es necesario.',])->validate();

        $section = new Section();
        $section->name = $inputs['name'];
        $section->author = $inputs['author'];
        $section->description = $inputs['description'];
        $section->active = self::ACTIVE;
        $section->source_id = $inputs['source_id'];
        $section->save();

        return redirect()->route('source.show', ['id' => $inputs['source_id']])->with('status', 'Sección agregada satisfactoriamente');
    }

    public function editForm(Request $request, $id) {
        $section = Section::find($id);

        return view('admin.sections.edit', compact('section'));
    }

    public function update (Request $request, $id) {
        $inputs = $request->all();

        $section = Section::find($id);
        $section->name = $inputs['name'];
        $section->author = $inputs['author'];
        $section->description = $inputs['description'];
        $section->save();

        return redirect()->route('source.show', ['id' => $section->source_id])->with('status', 'Sección editada satisfactoriamente');
    }

    public function delete(Request $request, $id) {
        $section = Section::find($id);
        $sectionName = $section->name;
        $sourceId = $section->source_id;
        $section->delete();

        return redirect()->route('source.show', ['id' => $sourceId])->with('status', "¡La sección: {$sectionName} se ha eliminado satisfactoriamente!");
    }

    public function status(Request $request, $id) {
        $section = Section::find($id);
        try {
            $section->active = $request->input('status');
            $status = $request->input('status') ? 'Activa' : 'Inactiva';
            $section->save();

            return response()->json(['message' => "La sección a quedado {$status}"]);
        } catch (Exception $e) {
            return response()->json(['error' => "Error al actualizar el estatus de la sección"]);
        }
    }

    public function sendSelectHTMLWithSctionsBySource(Request $request) {
        $sections = Section::where([
                ['source_id', '=', $request->input('source_id')],
                ['active', '=', 1],
            ])->orderBy('id', 'desc')
            ->get();

        return view('components.select-form-sections', compact('sections'))->render();
    }
}
