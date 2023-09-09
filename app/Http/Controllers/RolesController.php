<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RolesController extends Controller
{
    public function index()
    {
        $roles = Role::all();

        return response()->json($roles);

    }

    public function show($id)
    {
        $role = Role::findOrFail($id);
        return response()->json($role);
    }
}