<?php

namespace App\Http\Controllers;

use App\Models\Taller;
use Illuminate\Http\Request;
use App\Models\AsignaTaller;
use App\Models\SeccionTaller;
use App\Models\Respuesta;
use Illuminate\Support\Facades\Auth;

class ReutilizarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($tallerId)
    {
        $taller = Taller::where('id', $tallerId)
            ->where('nombre', 'Reutilizar')
            ->firstOrFail();

        $secciones = SeccionTaller::where('taller_id', $taller->id)
            ->orderBy('orden')
            ->get();

        // Obtener los IDs de secciones que el usuario ya ha respondido
        $respuestas = Respuesta::where('id_alumno', Auth::id())
            ->pluck('id_seccion')
            ->toArray();

        return view('reutilizar.index', compact('taller', 'secciones', 'respuestas'));
    }

    public function Seccion1($id)
    {
        $seccion = SeccionTaller::findOrFail($id);
        return view('reutilizar.secciones.seccion1', compact('seccion'));
    }

    public function guardarActividad(Request $request, $id)
    {
        $request->validate([
            'pregunta1' => 'required|string',
            'pregunta2' => 'required|array|min:3|max:3',
            'pregunta3' => 'required|array|min:5|max:5',
        ]);
        //dd($request->all());

        Respuesta::create([
            'id_seccion' => $id,
            'id_alumno' => Auth::id(),
            'pregunta1' => $request->pregunta1,
            'pregunta2' => $request->pregunta2[0],
            'pregunta3' => $request->pregunta2[1],
            'pregunta4' => $request->pregunta2[2],
            'pregunta5' => implode(', ', $request->pregunta3), // Guardamos objetos como texto separado por comas
        ]);

        return redirect()->route('reutilizar.index', ['taller' => $id]);


    }


    public function Seccion2($id)
    {
        $seccion = SeccionTaller::findOrFail($id);
        return view('reutilizar.secciones.seccion2', compact('seccion'));
    }




    public function Seccion3($id)
    {
        $seccion = SeccionTaller::findOrFail($id);
        return view('reutilizar.secciones.seccion3', compact('seccion'));
    }

// Agrega más según necesites



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
