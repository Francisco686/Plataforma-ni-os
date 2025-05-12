<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function cambiarGrupo(Request $request)
    {
        $request->validate([
            'grupo_id' => 'required|exists:groups,id',
        ]);

        Auth::user()->update(['grupo_id' => $request->grupo_id]);

        return redirect()->route('alumnos.index')->with('success', 'Grupo actualizado correctamente.');
    }
}
