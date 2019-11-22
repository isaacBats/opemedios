<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index () {
        $users = User::all();

        return view('admin.user.index', compact('users'));
    }

    public function show (Request $request, $id) {
        $profile = User::find($id);

        return view('admin.user.show', compact('profile'));

    }
}
