<?php
/**
  *-------------------------------------------------------------------------------------
  * Developer Information
  *-------------------------------------------------------------------------------------
  * @author Josue Martinez <mtzarenas2012@gmail.com>
  * @copyright 2023
  * @version 1.0.0
  * @package App\
  * Type: Controller
  * Description: Description
  *
  * For the full copyright and license information, please view the LICENSE
  * file that was distributed with this source code.
  */

namespace App\Http\Controllers;


use App\Models\SocialNetworks;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SocialNetworkController extends Controller
{
    public function index(Request $request) {
        $paginate = $request->has('paginate') ? $request->input('paginate') : 25;

        $breadcrumb = array();
        array_push($breadcrumb,['label' => 'Redes sociales']);

        $redes_sociales = SocialNetworks::name($request->get('name'))
            ->orderBy('id', 'desc')
            ->paginate($paginate)
            ->appends('name', request('name'));

        return view('admin.social_networks.index', compact('redes_sociales', 'paginate', 'breadcrumb'));
    }

    public function showForm() {
        $breadcrumb = array();

        array_push($breadcrumb, ['label' => 'Redes sociales', 'url' => route('social_networks')]);
        array_push($breadcrumb, ['label' => 'Nueva Red social']);

        return view('admin.social_networks.create', compact('breadcrumb'));
    }

    public function create(Request $request) {
        $inputs = $request->all();

        Validator::make($inputs, [
            'name' => 'required|max:150',
        ], [
            'name.required' => 'El nombre de la fuente es requerido.',
            'required' => 'El :attribute es necesario.',
        ])->validate();

        $red_social = new SocialNetworks();
        $red_social->name = $inputs['name'];
        $red_social->save();

        return redirect()->route('social_networks')->with('status', '¡Exito!. La red social se ha creado correctamente');
    }

    public function show(Request $request, $id) {

        $social_network = SocialNetworks::find($id);
        $breadcrumb = array();

        array_push($breadcrumb, ['label' => 'Redes sociales', 'url' => route('social_networks')]);
        array_push($breadcrumb, ['label' => $social_network->name]);

        return view('admin.social_networks.show', compact('social_network', 'breadcrumb'));
    }

    public function update(Request $request, $id) {
        $inputs = $request->all();
        $red_social = SocialNetworks::find($id);

        $red_social->name = $inputs['name'];
        $red_social->save();

        return redirect()->route('social_network.show', ['id' => $red_social->id])->with('status', '¡Exito!. La red social se ha editado correctamente');
    }

    public function delete(Request $request, $id) {
        $red_social = SocialNetworks::find($id);
        $socialNetworkName = $red_social->name;
        $red_social->delete();

        return redirect()->route('social_networks')->with('status', "¡La red social: {$socialNetworkName} se ha eliminado satisfactoriamente!");
    }

}
