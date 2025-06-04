<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\MultimediaController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\AccountController;

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

// Rutas para invitados (no autenticados)
Route::middleware(['web', 'guest'])->group(function () {
Route::get('ingresar', [LoginController::class, 'login'])->name('login');
Route::post('login', [LoginController::class, 'check'])->name('login.check');
Route::get('/register', [RegisterController::class, 'create'])->name('register');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');
});

// Zona para autenticados
Route::middleware(['web', 'auth'])->group(function (){
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

    // Busqueda
    Route::get('search', [SearchController::class, 'performSearch'])->name('search.perform');

    // Perfil
    Route::get('profile', function () {
        return view('profile.profile');
    })->name('profile');

    Route::get('profile/change-password', function () {
        return view('profile.change_password');
    })->name('password.change');

    // Cerrar sesión
    Route::get('salir', [LoginController::class, 'logout'])->name('logout');

    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

    Route::put('/password/update', [PasswordController::class, 'update'])->name('password.update');

    // Ruta para eliminar cuenta
    Route::post('/account/delete', [AccountController::class, 'delete'])->name('account.delete');
});