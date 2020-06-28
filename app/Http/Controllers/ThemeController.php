<?php

namespace App\Http\Controllers;

use App\Theme;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ThemeController extends Controller
{
    public function create (Request $request) {

        $inputs = $request->all();

        Validator::make($inputs, [
            'name' => 'required',
            'description' => 'required',
            'company_id' => 'required',
        ], [
            'name.required' => '¡El nombre del tema es necesario!',
            'description.required' => '¡La descripción del tema es necesario!',
        ])->validate();

        $theme = Theme::create($inputs);

        return back()->with('status', "El tema: {$theme->name} se ha creado satisfactoriamente!");
    }

    public function show (Request $request, $id) {
        $theme = Theme::find($id);
        $accounts = $theme->company->accounts()->diff($theme->accounts);

        return view('admin.theme.show', compact('theme', 'accounts'));
    }

    public function update (Request $request, $id) {
        $theme = Theme::find($id);

        $theme->name = !empty($request->input('name')) ? $request->input('name') : $theme->name;
        $theme->description = !empty($request->input('description')) ? $request->input('description') : $theme->description;

        $theme->save();

        return back()->with('status', "¡El tema {$theme->name} se a actualizado correctamente!");
    }

    public function delete (Request $request, $id) {
        $theme = Theme::find($id);
        $company = $theme->company;
        $name = $theme->name;
        $theme->delete();

        return redirect()->route('company.show', ['id' => $company->id])->with('status', "¡El tema: {$name} se ha eliminado satisfactoriamente!");
    }

    public function themeUser (Request $request) {
        $theme = Theme::findOrFail($request->input('theme_id'));
        $theme->accounts()->attach($request->input('user_id'));
        $user = User::findOrFail($request->input('user_id'));

        return back()->with('status', "Se ha asociado al usuario {$user->name} al tema {$theme->name}");
    }
}
