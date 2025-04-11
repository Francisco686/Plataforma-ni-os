<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TallerController;
use App\Http\Controllers\SeccionController;



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
    Route::get('/talleres', [TallerController::class, 'index'])->name('talleres.index');
    Route::get('/talleres/create', [TallerController::class, 'create'])->name('talleres.create');
    Route::post('/talleres', [TallerController::class, 'store'])->name('talleres.store');
    Route::get('/talleres/{taller}/edit', [TallerController::class, 'edit'])->name('talleres.edit');
    Route::put('/talleres/{taller}', [TallerController::class, 'update'])->name('talleres.update');
    Route::get('/talleres/asignar', [TallerController::class, 'asignar'])->name('talleres.asignar');
    Route::post('/talleres/asignar', [TallerController::class, 'storeAsignacion'])->name('talleres.asignar.store');
    Route::get('/talleres/{taller}', [TallerController::class, 'show'])->name('talleres.ver');
    Route::get('/taller/{id}', [TallerController::class, 'verTaller'])->name('talleres.ver');
    Route::delete('/talleres/{taller}', [TallerController::class, 'destroy'])->name('talleres.destroy');
    Route::post('/secciones', [SeccionController::class, 'store'])->name('secciones.store');


    Route::get('/secciones/{seccion}/edit', [SeccionController::class, 'edit'])->name('secciones.edit');
    Route::put('/secciones/{seccion}', [SeccionController::class, 'update'])->name('secciones.update');
    Route::delete('/secciones/{seccion}', [SeccionController::class, 'destroy'])->name('secciones.destroy');

    Route::post('/taller/completar', [TallerController::class, 'completarSeccion'])->name('talleres.completar');
});
