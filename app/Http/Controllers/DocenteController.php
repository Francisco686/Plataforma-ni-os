<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DocenteController extends Controller
{
    public function mostrarFormularioRecuperacion()
    {
        return view('auth.recuperar');
    }

    public function generarNuevaPassword(Request $request)
    {
        $request->validate(['name' => 'required|string']);
        $user = User::where('name', $request->name)->first();

        if (!$user) {
            return back()->with('error', 'Usuario no encontrado.');
        }

        $nueva = 'Docente' . rand(100, 999);
        $user->password = Hash::make($nueva);
        $user->password_visible = null; // Opcional: seguridad
        $user->password_temporal = true; // 👈 Esta línea es clave
        $user->save();

        return back()->with('success', 'Tu nueva contraseña temporal es: ' . $nueva . ' (Cámbiala al ingresar)');
    }
    public function mostrarCambioPassword()
{
    return view('auth.cambiar_password');
}

}
