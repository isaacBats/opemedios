<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index($company) {
        return "Felicidades {$company}, estas en tu perfil.";
    }
}
