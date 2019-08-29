<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index() {

        $roles = Role::all();
        return view('admin.roles.index', compact('roles'));
    }

    Public function create (Request $request) {
        $message = new \stdClass();
        try {
            $guardName = $request->input('role_name');
            $name = Str::slug($guardName, '_');
            $role = Role::create(['name' => $name, 'guard_name' => $guardName]);
            $message->type = 'primary';
            $message->message = 'Save';
        } catch (\Exception $e) {
            $message->type = 'warning';
            $message->message = "Error: {$e->getMessage()}";
        }

        return redirect()->route('roles')->with('message', $message);
    }
}
