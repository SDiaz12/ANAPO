<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ResidenciaController;

Route::get('/residencias', [ResidenciaController::class, 'index'])->name('residencias.index');