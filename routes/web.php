git<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\MultimediaController;

Route::get('/', function () {
    return view('inicio');
});

Route::get('ingresar', [LoginController::class, 'login'])->name('login.view');
Route::post('login', [LoginController::class, 'check'])->name('login.check');

// Zona para autenticados

// Reporte
Route::resource('reporte', ReportController::class);
// Multimedia
Route::resource('multimedia', MultimediaController::class);