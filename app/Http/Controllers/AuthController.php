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
        // Validación de datos
        $request->validate([
            'role' => 'required|in:alumno,docente',
            'name' => 'required|string|max:255',
            'curp' => 'required|string|size:18|unique:users,curp|regex:/^[A-Z0-9]{18}$/',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // Crear usuario
        $user = new User();
        $user->role = $request->role;
        $user->name = $request->name;
        $user->curp = strtoupper($request->curp);
        $user->password = Hash::make($request->password);
        $user->save();

        // Iniciar sesión automáticamente después del registro
        Auth::login($user);

        return redirect()->route('home')->with('success', 'Registro exitoso.');
    }

    /**
     * Maneja el login de usuarios con CURP y contraseña.
     */
    public function login(Request $request)
    {
        $request->validate([
            'curp' => 'required|string|size:18|regex:/^[A-Z0-9]{18}$/',
            'password' => 'required|string',
        ]);

        if (Auth::attempt(['curp' => strtoupper($request->curp), 'password' => $request->password])) {
            return redirect()->route('home')->with('success', 'Inicio de sesión exitoso.');
        }

        return back()->withErrors(['curp' => 'Credenciales incorrectas.'])->withInput();
    }

    /**
     * Maneja el logout.
     */
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('success', 'Sesión cerrada correctamente.');
    }
}
