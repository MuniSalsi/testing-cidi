<?php

use App\Http\Controllers\CidiController;
use Illuminate\Support\Facades\Route;

route::get('/validar-usuario', [CidiController::class, 'validarUsuarioCidi'])->name('cidi.validar_usuario');
