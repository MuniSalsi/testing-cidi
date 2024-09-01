<?php

use App\Http\Controllers\CidiController;
use Illuminate\Support\Facades\Route;

route::get('/', [CidiController::class, 'validarUsuarioCidi'])->name('cidi.validar_usuario');
Route::view('/login', 'login')->name('login');
Route::get('/logout', [CidiController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/admin', [CidiController::class, 'index'])->name('index');
});
