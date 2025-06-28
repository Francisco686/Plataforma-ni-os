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

// Actividades públicas
Route::get('/actividades/{sesion}/{actividad}/responder', [ActividadController::class, 'responder'])->name('actividad.responder');
Route::get('/actividades/{sesion}/{actividad}/respuesta', [ActividadController::class, 'verRespuesta'])->name('actividad.respuesta');
Route::post('/actividades/{actividad}/calificar', [ActividadController::class, 'calificar'])->name('actividad.calificar');

// Para docentes
Route::prefix('actividades/actividades')->group(function () {
    Route::get('/actividades', [ActividadController::class, 'ActividadesIndex'])->name('actividades.index.docente');
    Route::get('/actividades/{tallerId}', [ActividadController::class, 'ActividadesIndex'])->name('actividades.taller');
    Route::get('/crear', [ActividadController::class, 'Create'])->name('actividades.create');
    Route::post('/', [ActividadController::class, 'Store'])->name('actividades.store');
    Route::get('/detalle/{sesion}/{actividad}', [ActividadController::class, 'show'])->name('actividades.show.docente');
    Route::get('/reutilizar/{sesion}/{actividad}', [ActividadController::class, 'show'])->name('actividades.show.reutilizar');
    Route::delete('/{sesion}', [ActividadController::class, 'destroy'])->name('actividades.destroy');
});

Route::get('/actividades/{id}/edit', [ActividadController::class, 'edit'])->name('actividades.edit');
Route::get('/evaluaciones/alumno/{id}', [EvaluacionController::class, 'show'])->name('evaluaciones.show');
Route::get('/actividades1', [ActividadController::class, 'index'])->name('actividades1.index');
Route::get('/actividades', [ActividadController::class, 'index'])->name('actividades.index');
Route::post('sesiones/{sesion}/responder/{taller_id}', [ActividadController::class, 'responderStore'])->name('actividades.responder.store');

// Juegos y workshop
Route::get('/workshop', [WorkshopController::class, 'show']);
Route::post('/workshop/combine', [WorkshopController::class, 'combine']);
Route::view('/juegos/combinar', 'juegos.combinar')->name('juegos.combinar');
Route::post('/juegos/combinar', [WorkshopController::class, 'combine']);
Route::view('/juegos/clasificacion', 'juegos.clasificacion')->name('juegos.clasificacion');

// Redirección inicial
Route::redirect('/', '/login');
Route::get('/migrate', fn () => tap(Artisan::call('migrate', ['--force' => true]), fn () => 'Migraciones ejecutadas exitosamente.'));

// Autenticación
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/mis-logros', [LogroController::class, 'index'])->name('logros.index')->middleware('auth');

Route::middleware(['auth'])->group(function () {
    Route::view('/home', 'home')->name('home');

    // Talleres
    Route::resource('talleres', TallerController::class)->except(['show']);
    Route::get('/talleres/agua', [TallerController::class, 'agua'])->name('talleres.agua');
    Route::get('/talleres/reciclaje', [TallerController::class, 'reciclaje'])->name('talleres.reciclaje');
    Route::get('/talleres/reutilizar', [TallerController::class, 'reutilizar'])->name('talleres.reutilizar');
    Route::get('/talleres/{taller}/ver', [TallerController::class, 'show'])->name('talleres.ver');
    Route::get('/talleres/{taller}', [TallerController::class, 'show'])->name('talleres.show');

    // Secciones
    Route::resource('secciones', SeccionController::class)->except(['create', 'store']);
    Route::get('secciones/create/{taller}', [SeccionController::class, 'create'])->name('secciones.create');
    Route::post('secciones/{taller}', [SeccionController::class, 'store'])->name('secciones.store');
    Route::post('/secciones', [SeccionController::class, 'store'])->name('secciones.store');

    // Asignaciones
    Route::get('/talleres/asignar', [TallerController::class, 'asignar'])->name('talleres.asignar');
    Route::post('/talleres/asignar', [TallerController::class, 'storeAsignacion'])->name('talleres.asignar.store');
    Route::delete('/talleres/{taller}/asignar/{usuario}', [TallerController::class, 'destroyAsignacion'])->name('talleres.asignar.destroy');

    // Taller-sección
    Route::resource('talleres.secciones', SeccionTallerController::class);

    // Reutilizar
    Route::get('/reutilizar/{taller}', [ReutilizarController::class, 'index'])->name('reutilizar.index');
    Route::get('/seccion/{id}/seccion/1', [ReutilizarController::class, 'Seccion1'])->name('seccion.1');
    Route::post('/actividad/{id}/guardar', [ReutilizarController::class, 'guardarActividad'])->name('actividad.guardar');
    Route::get('/seccion/{id}/seccion/2', [ReutilizarController::class, 'Seccion2'])->name('seccion.2');

    // Evaluaciones
    Route::get('/evaluaciones', [EvaluacionController::class, 'index'])->name('evaluaciones.index');

    // Docente y alumnos
    Route::post('/usuario/cambiar-grupo', [UserController::class, 'cambiarGrupo'])->name('user.cambiarGrupo');
    Route::post('/docente/cambiar-grupo', [UserController::class, 'cambiarGrupo'])->name('docente.cambiar.grupo');
    Route::resource('alumnos', AlumnoController::class);

    // Respuestas
    Route::post('/respuestas', [RespuestasController::class, 'store'])->name('respuestas.store');

    Route::post('/juegos/completar/{tipo}', [JuegoController::class, 'guardarPartida'])->name('juegos.completar');
});

Route::get('/jugar/{tipo}', [JuegoController::class, 'guardarPartida'])->middleware('auth');
Route::view('/juegos', 'juegos.index')->name('juegos.index');
Route::view('/juegos/memorama', 'juegos.memorama')->name('juegos.memorama');
Route::view('/juegos/sopa', 'juegos.sopa')->name('juegos.sopa');

// Recuperación de contraseña docente
Route::get('/recuperar-docente', [App\Http\Controllers\DocenteController::class, 'mostrarFormularioRecuperacion'])->name('recuperar.form');
Route::post('/recuperar-docente', [App\Http\Controllers\DocenteController::class, 'generarNuevaPassword'])->name('recuperar.enviar');
Route::get('/docente/cambiar-password', [AuthController::class, 'mostrarCambioPassword'])->name('docente.password.cambiar');
Route::post('/docente/cambiar-password', [AuthController::class, 'actualizarPassword'])->name('docente.password.actualizar');

// Acceso a materiales
Route::get('/storage/materiales/{filename}', function ($filename) {
    $path = storage_path('app/public/materiales/' . $filename);
    abort_unless(file_exists($path), 404, 'El archivo no existe');
    return response()->file($path);
});