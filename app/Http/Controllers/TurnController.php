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

use App\Turn;
use Illuminate\Http\Request;

class TurnController extends Controller
{
    public function ajaxCreate (Request $request) {

        $turn = Turn::create($request->all());

        return response()->json([
            'id' => $turn->id,
            'name' => $turn->name
        ]);
    }

    public function index () {
        $turns = Turn::orderBy('id', 'DESC')->paginate(25);
        return view('admin.turn.index', compact('turns'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.turn.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ],[
            'name.required' => 'El nombre del Giro es requerido',
        ]);
        $data = $request->all();
        $sector = Turn::create($data);

        return redirect()->route('admin.turns')->with('status','¡Giro creado satisfactoriamente!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $turn = Turn::findOrFail($id);

        return view('admin.turn.edit', compact('turn'));
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
        $turn = Turn::findOrFail($id);
        $data = $request->all();
        $turn->update($data);

        return redirect()->route('admin.turns')->with('status', '¡Se ha actualizado el giro satisfactoriamente!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $turn = Turn::findOrFail($id);
        $name = $turn->name;
        $turn->delete();

        return redirect()->route('admin.turns')->with('status', "¡El giro {$name} se ha eliminado satisfactoriamente!");
    } 
}
