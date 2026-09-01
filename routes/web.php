<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\InicioSesionController;
use App\Http\Controllers\InstructorController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ValoracionController; 
use App\Http\Controllers\ComiteAcademicoController;

// ==========================================
// VERIFICACION INICIO DE SESION 
// ==========================================

Route::get('/', function () {
    return view('InicioSesion.iniciosesion');
})->name('login');

Route::get('/iniciar-sesion', function () {
    return view('InicioSesion.iniciosesion');
});

Route::post('/iniciar-sesion', [InicioSesionController::class, 'iniciarSesion'])->name('login.post');

// Registro de usuarios
Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);

// Cerrar sesión
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');


// ==========================================
// RUTAS PROTEGIDAS POR AUTENTICACIÓN
// ==========================================
Route::middleware(['auth'])->group(function () {

    // Panel Principal / Dashboard
    Route::get('/dashboard', [InstructorController::class, 'index'])
        ->middleware('verified')
        ->name('dashboard');

    // Perfil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Panel Aprendiz
    Route::middleware('rol:aprendiz')->group(function () {
        Route::get('/aprendiz/inicio', function () {
            return view('Aprendiz.inicio'); 
        })->name('aprendiz.inicio');
    });

    // Panel Área de Apoyo 
    Route::middleware('rol:profesional')->group(function () {
        Route::get('/area-apoyo/inicio', [ValoracionController::class, 'create'])->name('area_apoyo.inicio');
    });

    // Panel Instructor
    Route::middleware('rol:instructor')->group(function () {
        Route::get('/instructor/inicio', [InstructorController::class, 'index'])->name('instructor.inicio');
        Route::get('/instructor/aprendices/crear', [InstructorController::class, 'create'])->name('aprendices.create');
        Route::post('/instructor/aprendices/guardar', [InstructorController::class, 'store'])->name('aprendices.store');
    });
    Route::get('/instructor/reporte-pdf', [InstructorController::class, 'generarReporteAprendices'])
    ->name('instructor.reporte.pdf');

    // Panel Comité Académico
    Route::middleware('rol:comite')->group(function () {
    Route::get('/comite-academico/seguimiento', [ComiteAcademicoController::class, 'index'])->name('comite.inicio');
    });

    // Acciones de Valoración
    Route::post('/valoracion/historial', [ValoracionController::class, 'storeHistorial'])->name('valoracion.historial.store');
    Route::post('/valoracion/profesional', [ValoracionController::class, 'storeProfesional'])->name('valoracion.profesional.store');

    // Redirección directa o alias para ver el historial
    Route::get('/valoracion/historial-tabla', function () {
        return redirect()->route('comite.inicio');
    })->name('valoracion.historial.index');
});

require __DIR__.'/auth.php';