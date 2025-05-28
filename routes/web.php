<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\MultimediaController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('inicio');
});

Route::get('ingresar', [LoginController::class, 'login'])->name('login');
Route::post('login', [LoginController::class, 'check'])->name('login.check');

Route::view('register', 'auth.register')->name('register');

// Zona para autenticados
Route::middleware('auth')->group(function (){
    // Inicio
    Route::get('inicio', [HomeController::class, 'inicio'])->name('home');
    
    // Reporte
    Route::resource('reporte', ReportController::class);
    Route::get('reporte/{report}/exportar', [ReportController::class, 'export'])->name('reporte.export');

    // Multimedia
    Route::get('multimedia/exportar', [MultimediaController::class, 'export'])->name('multimedia.export');
    Route::resource('multimedia', MultimediaController::class);

    // Rutas de prueba para validación de archivos multimedia
    Route::get('/test-upload', function () {
        return view('multimedia.test');
    })->name('multimedia.test-view');
    
    Route::post('/test-upload', [MultimediaController::class, 'testUpload'])->name('multimedia.test-upload');

    // Cerrar sesión
    Route::get('salir', [LoginController::class, 'logout'])->name('logout');
});