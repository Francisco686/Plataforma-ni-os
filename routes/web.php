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
use App\Http\Controllers\WorkshopController;
use App\Http\Controllers\JuegoController;
use App\Http\Controllers\LogroController;
use App\Http\Controllers\ActividadController;
Route::get('/actividades/{sesion}/{actividad}/responder', [ActividadController::class, 'responder'])->name('actividad.responder');
Route::get('/actividades/{sesion}/{actividad}/respuesta', [ActividadController::class, 'verRespuesta'])->name('actividad.respuesta');
Route::post('/actividades/{actividad}/calificar', [ActividadController::class, 'calificar'])->name('actividad.calificar');


// Para docentes
Route::prefix('actividades/actividades')->group(function() {
    // Para el index de actividades
    Route::get('/actividades', [ActividadController::class, 'ActividadesIndex'])->name('actividades.index');

// Para actividades filtradas por taller
    Route::get('/actividades/{tallerId}', [ActividadController::class, 'ActividadesIndex'])->name('actividades.actividades');
    Route::get('/crear', [ActividadController::class, 'Create'])->name('actividades.create');
    Route::post('/', [ActividadController::class, 'Store'])->name('actividades.store');
// For docente view
    Route::get('actividades/{sesion}/{actividad}', [ActividadController::class, 'show'])
        ->name('actividades.show');

// For alumno view
    Route::get('actividades-reutilizar/{sesion}/{actividad}', [ActividadController::class, 'show'])
        ->name('actividades.show');

    Route::delete('/{sesion}', [ActividadController::class, 'destroy'])->name('actividades.destroy');
});


Route::get('/actividades/{id}/edit', [TuControlador::class, 'edit'])->name('actividades.edit');
Route::get('/evaluaciones/alumno/{id}', [EvaluacionController::class, 'show'])->name('evaluaciones.show');
// Mostrar sesión para responder
Route::get('/actividades1', [ActividadController::class, 'index'])->name('actividades1.index');
Route::get('/actividades', [ActividadController::class, 'index'])->name('actividades.index');

Route::post('sesiones/{sesion}/responder/{taller_id}', [ActividadController::class, 'responderStore'])
    ->name('actividades.responder.store');

Route::get('/workshop', [WorkshopController::class, 'show']);
Route::post('/workshop/combine', [WorkshopController::class, 'combine']);

Route::get('/juegos/combinar', function () {
    return view('juegos.combinar');
})->name('juegos.combinar');
Route::post('/juegos/combinar', [WorkshopController::class, 'combine']);

Route::get('/juegos/clasificacion', function () {
    return view('juegos.clasificacion');
})->name('juegos.clasificacion');

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

Route::get('/mis-logros', [LogroController::class, 'index'])->name('logros.index')->middleware('auth');

Route::middleware(['auth'])->group(function () {

    // Inicio
    Route::get('/home', fn () => view('home'))->name('home');

    // Talleres
    Route::get('/talleres', [TallerController::class, 'index'])->name('talleres.index');
    Route::get('/talleres/agua', [TallerController::class, 'agua'])->name('talleres.agua');
    Route::get('/talleres/reciclaje', [TallerController::class, 'reciclaje'])->name('talleres.reciclaje');
    Route::get('/talleres/reutilizar', [TallerController::class, 'reutilizar'])->name('talleres.reutilizar');
    Route::post('/talleres', [TallerController::class, 'store'])->name('talleres.store');
    Route::get('/talleres/{taller}/edit', [TallerController::class, 'edit'])->name('talleres.edit');
    Route::put('/talleres/{taller}', [TallerController::class, 'update'])->name('talleres.update');
    Route::delete('/talleres/{taller}', [TallerController::class, 'destroy'])->name('talleres.destroy');
    Route::get('/talleres/{taller}/ver', [TallerController::class, 'show'])->name('talleres.ver');
    Route::get('/talleres/{taller}', [TallerController::class, 'show'])->name('talleres.show');
    Route::get('/talleres/create', [TallerController::class, 'create'])->name('talleres.create');

    // Secciones
    Route::get('secciones/create/{taller}', [SeccionController::class, 'create'])->name('secciones.create');
    Route::post('secciones/{taller}', [SeccionController::class, 'store'])->name('secciones.store');
    Route::post('/secciones', [SeccionController::class, 'store'])->name('secciones.store');
    Route::get('/secciones/{seccion}/edit', [SeccionController::class, 'edit'])->name('secciones.edit');
    Route::put('/secciones/{seccion}', [SeccionController::class, 'update'])->name('secciones.update');
    Route::delete('/secciones/{seccion}', [SeccionController::class, 'destroy'])->name('secciones.destroy');

    // Asignación de talleres
    Route::get('/talleres/asignar', [TallerController::class, 'asignar'])->name('talleres.asignar');
    Route::post('/talleres/asignar', [TallerController::class, 'storeAsignacion'])->name('talleres.asignar.store');
    Route::delete('/talleres/{taller}/asignar/{usuario}', [TallerController::class, 'destroyAsignacion'])->name('talleres.asignar.destroy');

    // Completar sección
    Route::post('/taller/completar', [TallerController::class, 'completarSeccion'])->name('talleres.completar');

    // Secciones tipo taller
    Route::post('/talleres/{taller}/secciones', [SeccionTallerController::class, 'store'])->name('secciones.store.taller');
    Route::get('/talleres/{taller}/secciones/create', [SeccionTallerController::class, 'create'])->name('secciones.create');
    Route::get('/secciones/{id}/edit', [SeccionTallerController::class, 'edit'])->name('secciones.edit.taller');
    Route::put('/secciones/{id}', [SeccionTallerController::class, 'update'])->name('secciones.update.taller');
    Route::delete('/secciones/{id}', [SeccionTallerController::class, 'destroy'])->name('secciones.destroy.taller');

    // Reutilizar
    Route::get('/reutilizar/{taller}', [ReutilizarController::class, 'index'])->name('reutilizar.index');
    Route::get('/seccion/{id}/seccion/1', [ReutilizarController::class, 'Seccion1'])->name('seccion.1');
    Route::post('/actividad/{id}/guardar', [ReutilizarController::class, 'guardarActividad'])->name('actividad.guardar');
    Route::get('/seccion/{id}/seccion/2', [ReutilizarController::class, 'Seccion2'])->name('seccion.2');

    // Evaluaciones
    Route::get('/evaluaciones', [EvaluacionController::class, 'index'])->name('evaluaciones.index');

    // Docente
    Route::get('/docente/talleres', [TallerController::class, 'index'])->name('docente.talleres.index');
    Route::post('/docente/talleres', [TallerController::class, 'store'])->name('docente.talleres.store');

    // Grupos
    Route::post('/usuario/cambiar-grupo', [UserController::class, 'cambiarGrupo'])->name('user.cambiarGrupo');
    Route::post('/docente/cambiar-grupo', [UserController::class, 'cambiarGrupo'])->name('docente.cambiar.grupo');

    // Alumnos
    Route::get('/alumnos', [AlumnoController::class, 'index'])->name('alumnos.index');
    Route::resource('alumnos', AlumnoController::class)->except(['index']);

    // Respuestas
    Route::post('/respuestas', [RespuestasController::class, 'store'])->name('respuestas.store');

    // ✅ Ruta corregida: proteger con auth
    Route::post('/juegos/completar/{tipo}', [JuegoController::class, 'guardarPartida'])->name('juegos.completar');
});

Route::get('/jugar/{tipo}', [JuegoController::class, 'guardarPartida'])->middleware('auth');

Route::get('/juegos', fn () => view('juegos.index'))->name('juegos.index');
Route::get('/juegos/memorama', fn () => view('juegos.memorama'))->name('juegos.memorama');
Route::get('/juegos/sopa', fn () => view('juegos.sopa'))->name('juegos.sopa');

// Recuperación de contraseña docente
Route::get('/recuperar-docente', [App\Http\Controllers\DocenteController::class, 'mostrarFormularioRecuperacion'])->name('recuperar.form');
Route::post('/recuperar-docente', [App\Http\Controllers\DocenteController::class, 'generarNuevaPassword'])->name('recuperar.enviar');
Route::get('/docente/cambiar-password', [App\Http\Controllers\AuthController::class, 'mostrarCambioPassword'])->name('docente.password.cambiar');
Route::post('/docente/cambiar-password', [App\Http\Controllers\AuthController::class, 'actualizarPassword'])->name('docente.password.actualizar');

Route::post('/juegos/completar/{tipo}', [JuegoController::class, 'guardarPartida'])->name('juegos.completar');
Route::get('/logros', [LogroController::class, 'index'])->middleware('auth')->name('logros.index');

Route::post('/juegos/completar/{tipo}', [JuegoController::class, 'guardarPartida'])->name('juegos.completar');

// Acceso a materiales
Route::get('/storage/materiales/{filename}', function ($filename) {
    $path = storage_path('app/public/materiales/' . $filename);
    if (!file_exists($path)) {
        abort(404, 'El archivo no existe');
    }
    return response()->file($path);
});
