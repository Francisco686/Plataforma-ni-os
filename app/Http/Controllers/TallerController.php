<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\AsignaTaller;
use App\Models\SeccionTaller;
use App\Models\ProgresoTaller;
use App\Models\Taller;

class TallerController extends Controller
{
    public function misTalleres()
{
    $talleres = Taller::all(); // ← Mostramos todos los talleres sin asignación
    $userId = Auth::id();

    return view('talleres.index', compact('talleres', 'userId'));
}

    public function verTaller($taller_id)
    {
        $asigna = AsignaTaller::where('user_id', Auth::id())->where('taller_id', $taller_id)->firstOrFail();
        $secciones = SeccionTaller::where('taller_id', $taller_id)->orderBy('orden')->get();
        $progreso = ProgresoTaller::where('asigna_taller_id', $asigna->id)->pluck('seccion_taller_id')->toArray();
        return view('talleres.ver', compact('asigna', 'secciones', 'progreso'));
    }

    public function completarSeccion(Request $request)
    {
        ProgresoTaller::updateOrCreate([
            'asigna_taller_id' => $request->asigna_taller_id,
            'seccion_taller_id' => $request->seccion_taller_id
        ], [
            'completado' => true,
            'fecha_completado' => now()
        ]);

        return back()->with('ok', '¡Progreso guardado!');
    }
}
