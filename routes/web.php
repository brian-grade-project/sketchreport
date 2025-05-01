<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\MultimediaController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('inicio');
})->name('inicio');

Route::get('ingresar', [LoginController::class, 'login'])->name('login');
Route::post('login', [LoginController::class, 'check'])->name('login.check');

// Zona para autenticados

Route::middleware('auth')->group(function (){

    // Inicio
    Route::get('inicio', [HomeController::class, 'inicio'])->name('home');
    
    // Reporte
    Route::resource('reporte', ReportController::class);

    // Multimedia
    Route::resource('multimedia', MultimediaController::class);

    // Perfil
    Route::get('perfil', [ProfileController::class, 'show'])->name('profile.show');

    // Cerrar sesión
    Route::get('salir', [LoginController::class, 'logout'])->name('logout');

});