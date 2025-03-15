<?php


use App\Livewire\Asignatura\Asignaturas;
use App\Livewire\AsignaturaEstudiante\AsignaturaEstudiantes;
use App\Livewire\Docente\Docentes;
use App\Livewire\Estudiant\Estudiants;
use App\Livewire\Matricula\Matriculas;
use App\Livewire\Nota\Notas;
use App\Livewire\Principal\Principales;
use App\Livewire\ProgramaFormacion\ProgramaFormaciones;
use App\Livewire\VistaNotasEstudiantes\VistaNotaEstudiantes;
use App\Models\AsignaturaEstudiante;
use Illuminate\Support\Facades\Route;
use App\Livewire\Rol\Roles;
use App\Livewire\AsignaturaDocente\AsignaturaDocentes;

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
    Route::get('/notasEstudiante/{asignaturaEstudianteId}', VistaNotaEstudiantes::class)->name('notasEstudiante');
    Route::get('/rol', Roles::class)->name('rol');
    Route::get('/notas', Notas::class)->name('notas');
    Route::get('/docente', Docentes::class)->name('docente');
    Route::get('/estudiante', Estudiants::class)->name('estudiante');
    Route::get('/asignatura', Asignaturas::class)->name('asignatura');
    Route::get('/asignaturaDocente', AsignaturaDocentes::class)->name('asignaturaDocente');
    Route::get('/asignaturaEstudiante', AsignaturaEstudiantes::class)->name('asignaturaEstudiante');
    Route::get('/matricula', Matriculas::class)->name('matricula');
    Route::get('/programas', ProgramaFormaciones::class)->name('programas');
});
