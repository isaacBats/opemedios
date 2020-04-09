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

use App\Section;
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
}
