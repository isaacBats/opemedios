<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreThemeRequest;
use App\Http\Requests\UpdateThemeRequest;
use App\Models\{Company,Theme,User};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ThemeController extends Controller
{
    /**
     * @param StoreThemeRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store (StoreThemeRequest $request): \Illuminate\Http\RedirectResponse
    {
        $theme = Theme::create($request->validated());
        return back()->with('status', "El tema: {$theme->name} se ha creado satisfactoriamente!");
    }

    /**
     * @param Request $request
     * @param Theme $theme
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show (Request $request, Theme $theme)
    {
        $breadcrumb = array();
        array_push($breadcrumb, ['label' => 'Empresas', 'url' => route('companies')]);
        array_push($breadcrumb, ['label' => $theme->company->name, 'url' => route('company.show', ['company' => $theme->company ])]);
        array_push($breadcrumb, ['label' => $theme->name]);

        $accounts = $theme->company->accounts()->merge($theme->company->executives);
        $accounts = $accounts->diff($theme->accounts);
        return view('admin.theme.show', compact('theme', 'accounts', 'breadcrumb'));
    }

    /**
     * @param UpdateThemeRequest $request
     * @param Theme $theme
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update (UpdateThemeRequest $request, Theme $theme): \Illuminate\Http\RedirectResponse
    {
        $theme->update($request->validated());

        return back()->with('status', "¡El tema {$theme->name} se a actualizado correctamente!");
    }

    public function delete (Request $request, $id) {
        $theme = Theme::find($id);
        $company = $theme->company;
        $name = $theme->name;
        $theme->delete();

        return redirect()->route('company.show', ['company' => $company])->with('status', "¡El tema: {$name} se ha eliminado satisfactoriamente!");
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
