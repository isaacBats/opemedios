<?php

namespace App\Http\Controllers;

use App\Turn;
use Illuminate\Http\Request;

class TurnController extends Controller
{
    public function create (Request $request) {

        $turn = Turn::create($request->all());

        return response()->json([
            'id' => $turn->id,
            'name' => $turn->name
        ]);
    }
}
