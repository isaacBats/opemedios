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
  * Type: Coontroller
  * Description: Description
  *
  * For the full copyright and license information, please view the LICENSE
  * file that was distributed with this source code.
  */
        
namespace App\Http\Controllers;

use App\Sector;
use Illuminate\Http\Request;

class SectorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $breadcrumb = array();
        array_push($breadcrumb,['label' => 'Sectores']);

        $paginate = $request->has('paginate') ? $request->input('paginate') : 25;

        $sectors = Sector::name($request->get('name'))
            ->orderBy('id', 'DESC')
            ->paginate($paginate)
            ->appends('name', request('name'));

        return view('admin.sector.index', compact('sectors', 'breadcrumb', 'paginate'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $breadcrumb = array();
        array_push($breadcrumb,['label' => 'Sectores', 'url' => route('admin.sectors')]);
        array_push($breadcrumb,['label' => 'Nuevo Sector']);

        return view('admin.sector.create', compact('breadcrumb'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $data['active'] = 1;
        $sector = Sector::create($data);

        return redirect()->route('admin.sectors')->with('status','¡Sector creado satisfactoriamente!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $sector = Sector::findOrFail($id);

        $breadcrumb = array();
        array_push($breadcrumb,['label' => 'Sectores', 'url' => route('admin.sectors')]);
        array_push($breadcrumb,['label' => "Editar {$sector->name}"]);

        return view('admin.sector.edit', compact('sector', 'breadcrumb'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $sector = Sector::findOrFail($id);
        $data = $request->all();
        $data['active'] = array_key_exists('active', $data) ? 1 : 0;
        $sector->update($data);

        return redirect()->route('admin.sectors')->with('status', '¡Se ha actualizado el sector satisfactoriamente!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sector = Sector::findOrFail($id);
        $name = $sector->name;
        $sector->delete();

        return redirect()->route('admin.sectors')->with('status', "¡El sector {$name} se ha eliminado satisfactoriamente!");
    }
}
