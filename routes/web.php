<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TallerController;
// Redirigir la raíz al login
Route::get('/', function () {
    return redirect()->route('login');
});

// Rutas de autenticación
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Ruta protegida para usuarios autenticados
Route::get('/home', function () {
    return view('home');
})->middleware('auth')->name('home');



Route::middleware(['auth'])->group(function () {
    Route::get('/mis-talleres', [TallerController::class, 'misTalleres'])->name('talleres.index');
    Route::get('/taller/{id}', [TallerController::class, 'verTaller'])->name('talleres.ver');
    Route::post('/taller/completar', [TallerController::class, 'completarSeccion'])->name('talleres.completar');
});

