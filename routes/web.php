<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TallerController;
use App\Http\Controllers\SeccionController;
use App\Http\Controllers\ReutilizarController;
use App\Http\Controllers\AlumnoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EvaluacionController;
use App\Http\Controllers\SeccionTallerController;
use App\Http\Controllers\RespuestasController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/migrate', function () {
    Artisan::call('migrate', ['--force' => true]);
    return 'Migraciones ejecutadas exitosamente.';
});

// Rutas de autenticación
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {

    // Inicio
    Route::get('/home', fn () => view('home'))->name('home');

    // Talleres
    Route::get('/talleres', [TallerController::class, 'index'])->name('talleres.index');
    Route::post('/talleres', [TallerController::class, 'store'])->name('talleres.store');
    Route::get('/talleres/{taller}/edit', [TallerController::class, 'edit'])->name('talleres.edit');
    Route::put('/talleres/{taller}', [TallerController::class, 'update'])->name('talleres.update');
    Route::delete('/talleres/{taller}', [TallerController::class, 'destroy'])->name('talleres.destroy');
    Route::get('/talleres/{taller}/ver', [TallerController::class, 'show'])->name('talleres.ver');
    Route::get('/talleres/{taller}', [TallerController::class, 'show'])->name('talleres.show');
    Route::get('/talleres/create', 'TallerController@create')->name('talleres.create');

    Route::get('secciones/create/{taller}', [SeccionController::class, 'create'])->name('secciones.create');
    Route::post('secciones/{taller}', [SeccionController::class, 'store'])->name('secciones.store');

    // Asignación de talleres
    Route::get('/talleres/asignar', [TallerController::class, 'asignar'])->name('talleres.asignar');
    Route::post('/talleres/asignar', [TallerController::class, 'storeAsignacion'])->name('talleres.asignar.store');
    Route::delete('/talleres/{taller}/asignar/{usuario}', [TallerController::class, 'destroyAsignacion'])->name('talleres.asignar.destroy');

    // Completar sección
    Route::post('/taller/completar', [TallerController::class, 'completarSeccion'])->name('talleres.completar');

    // Secciones (de SeccionController)
    Route::post('/secciones', [SeccionController::class, 'store'])->name('secciones.store');
    Route::get('/secciones/{seccion}/edit', [SeccionController::class, 'edit'])->name('secciones.edit');
    Route::put('/secciones/{seccion}', [SeccionController::class, 'update'])->name('secciones.update');
    Route::delete('/secciones/{seccion}', [SeccionController::class, 'destroy'])->name('secciones.destroy');

    // Reutilizar
    Route::get('/reutilizar/{taller}', [ReutilizarController::class, 'index'])->name('reutilizar.index');
    Route::get('/seccion/{id}/seccion/1', [ReutilizarController::class, 'Seccion1'])->name('seccion.1');
    Route::post('/actividad/{id}/guardar', [ReutilizarController::class, 'guardarActividad'])->name('actividad.guardar');
    Route::get('/seccion/{id}/seccion/2', [ReutilizarController::class, 'Seccion2'])->name('seccion.2');

    // Evaluaciones
    Route::get('/evaluaciones', [EvaluacionController::class, 'index'])->name('evaluaciones.index');

    // Rutas específicas para docente
    Route::get('/docente/talleres', [TallerController::class, 'index'])->name('docente.talleres.index');
    Route::post('/docente/talleres', [TallerController::class, 'store'])->name('docente.talleres.store');

    // Gestión de grupo
    Route::post('/usuario/cambiar-grupo', [UserController::class, 'cambiarGrupo'])->name('user.cambiarGrupo');
    Route::post('/docente/cambiar-grupo', [UserController::class, 'cambiarGrupo'])->name('docente.cambiar.grupo');

    // Secciones (de SeccionTallerController)
    Route::post('/talleres/{taller}/secciones', [SeccionTallerController::class, 'store'])->name('secciones.store.taller');
    Route::get('/talleres/{taller}/secciones/create', [SeccionTallerController::class, 'create'])->name('secciones.create');
    Route::get('/secciones/{id}/edit', [SeccionTallerController::class, 'edit'])->name('secciones.edit.taller');
    Route::put('/secciones/{id}', [SeccionTallerController::class, 'update'])->name('secciones.update.taller');
    Route::delete('/secciones/{id}', [SeccionTallerController::class, 'destroy'])->name('secciones.destroy.taller');

    // Alumnos
    Route::get('/alumnos', [AlumnoController::class, 'index'])->name('alumnos.index');
    Route::resource('alumnos', AlumnoController::class)->except(['index']);

    // Respuestas
    Route::post('/respuestas', [RespuestasController::class, 'store'])->name('respuestas.store');
});

// Zona de juegos
Route::get('/juegos', function () {
    return view('juegos.index');
})->name('juegos.index');

// Archivos de materiales
Route::get('/storage/materiales/{filename}', function ($filename) {
    $path = storage_path('app/public/materiales/' . $filename);
    if (!file_exists($path)) {
        abort(404, 'El archivo no existe');
    }
    return response()->file($path);
});
