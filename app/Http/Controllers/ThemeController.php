<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Theme;
use App\Models\User;
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

    public function show (Request $request, Theme $theme) {
        $accounts = $theme->company->accounts()->merge($theme->company->executives);
        $accounts = $accounts->diff($theme->accounts);
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

    public function sendSelectHTMLWithThemesByCompany(Request $request) {
        $themes = Company::where([
                ['id', '=', $request->input('company_id')],
                // ['active', '=', 1],
            ])->orderBy('id', 'desc')
            ->first()
            ->themes;

        return view('components.select-themes', compact('themes'))->render();
    }

    public function getAccountsAjax(Request $request) {
        $theme = Theme::findOrFail($request->input('theme_id'));

        return response()->json($theme->accounts);
    }

    public function themeUserRemove (Request $request, $id) {
        $theme = Theme::findOrFail($request->input('theme_id'));
        $theme->accounts()->detach($id);
        $user = User::findOrFail($id);

        return back()->with('status', "Se ha removido al usuario {$user->name} del tema {$theme->name}");

    }
}
