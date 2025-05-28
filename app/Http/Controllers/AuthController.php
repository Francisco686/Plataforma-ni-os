<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Muestra el formulario de login.
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function username()
    {
        return 'name';
    }

    /**
     * Muestra el formulario de registro.
     */
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    /**
     * Maneja el registro de usuarios.
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = new User();
        $user->role = 'docente'; // Siempre asigna "docente"
        $user->name = $request->name;
        $user->password = Hash::make($request->password);
        $user->password_visible = $request->password;
        $user->password_temporal = false;
        $user->save();

        Auth::login($user);

        return redirect()->route('home')->with('success', 'Registro exitoso.');
    }

    /**
     * Maneja el login de usuarios por nombre y contraseña visible o hash.
     */
    public function login(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'password' => 'required|string',
        ]);

        $nameInput = trim(strtolower($request->name));

        $user = User::get()->first(function ($u) use ($nameInput, $request) {
            return strtolower(trim($u->name)) === $nameInput &&
                ($u->password_visible === $request->password || Hash::check($request->password, $u->password));
        });

        if ($user) {
            Auth::login($user);

            // Si la contraseña es temporal, redirigir a formulario de cambio
            if ($user->password_temporal) {
                return redirect()->route('docente.password.cambiar');
            }

            // Si es docente, contar alumnos del grupo asignado
            if ($user->role === 'docente') {
                $alumnosRegistrados = User::where('role', 'alumno')
                    ->where('grupo_id', $user->grupo_id)
                    ->count();

                return redirect()->route('home')->with([
                    'success' => 'Inicio de sesión exitoso.',
                    'alumnosRegistrados' => $alumnosRegistrados
                ]);
            }

            return redirect()->route('home')->with('success', 'Inicio de sesión exitoso.');
        }

        return back()->withErrors(['name' => 'Nombre o contraseña incorrectos.'])->withInput();
    }

    /**
     * Cierra sesión.
     */
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('success', 'Sesión cerrada correctamente.');
    }

    /**
     * Muestra formulario de cambio obligatorio de contraseña.
     */
    public function mostrarCambioPassword()
    {
        return view('auth.cambiar_password');
    }

    /**
     * Actualiza la contraseña obligatoriamente y cierra sesión.
     */
    public function actualizarPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = Auth::user();
        $user->password = Hash::make($request->password);
        $user->password_visible = null; // opcional: dejarlo en blanco para seguridad
        $user->password_temporal = false;
        $user->save();

        Auth::logout();

        return redirect()->route('login')->with('success', 'Contraseña cambiada correctamente. Inicia sesión con la nueva.');
    }
}
