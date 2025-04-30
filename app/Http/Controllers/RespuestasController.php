<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Respuesta;
use App\Models\SeccionTaller;
use Illuminate\Support\Facades\Auth;

class RespuestasController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'seccion_id' => 'required|exists:seccion_tallers,id',
            'respuesta' => 'required|string|max:255',
        ]);

        Respuesta::create([
            'user_id' => Auth::id(),
            'seccion_id' => $request->seccion_id,
            'respuesta' => $request->respuesta,
        ]);

        return redirect()->back()->with('success', '¡Respuesta enviada correctamente!');
    }
}
