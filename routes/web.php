<?php


use App\Livewire\Asignatura\Asignaturas;
use App\Livewire\Docente\Docentes;
use App\Livewire\Estudiant\Estudiants;
use App\Livewire\Matricula\Matriculas;
use App\Livewire\Principal\Principales;
use Illuminate\Support\Facades\Route;
use App\Livewire\Rol\Roles;
Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {return view('dashboard');})->name('dashboard');
    Route::get('/principal', Principales::class)->name('principal');
    Route::get('/rol', Roles::class)->name('rol');
    Route::get('/docente', Docentes::class)->name('docente');
    Route::get('/estudiante', Estudiants::class)->name('estudiante');
    Route::get('/asignatura', Asignaturas::class)->name('asignatura');
    Route::get('/matricula', Matriculas::class)->name('matricula');
});
