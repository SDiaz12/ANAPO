<?php


use App\Http\Controllers\SetRoleController;
use App\Livewire\Asignatura\Asignaturas;
use App\Livewire\Estudiant\EstudiantePorUsuario;
use App\Livewire\Instituto\Instituto;
use App\Livewire\Seccion\Secciones;
use App\Livewire\Periodo\Periodos;
use App\Livewire\AsignaturaEstudiante\AsignaturaEstudiantes;
use App\Livewire\Docente\Docentes;
use App\Livewire\Estudiant\Estudiants;
use App\Livewire\Matricula\Matriculas;
use App\Livewire\Nota\Notas;
use App\Livewire\Nota\HistorialNotas;
use App\Livewire\Nota\EditarNotas;
use App\Livewire\Principal\Principales;
use App\Livewire\ProgramaFormacion\ProgramaFormaciones;
use App\Livewire\Usuario\Usuario;
use App\Livewire\VistaNotasEstudiantes\VistaNotaEstudiantes;
use App\Models\AsignaturaEstudiante;
use App\Http\Controllers\ReporteNotasController;
use Illuminate\Support\Facades\Route;
use App\Livewire\Rol\Roles;
use App\Livewire\AsignaturaDocente\AsignaturaDocentes;
use App\Livewire\Promocion\Promociones;
use App\Livewire\Estudiante\MatriculaAsignaturas;

Route::get('/', function () {
    return view('welcome');
});

/*Route::get('/logout', function () {
    if (Auth::check()) { // Verifica si el usuario está autenticado
        Auth::logout(); // Cierra la sesión
        return redirect('/'); // Redirige al inicio
    }

    return redirect()->route('login'); // Si no está autenticado, redirige a la página de login
})->name('logout');*/

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/cuadro/pdf/{codigo_asignatura}/{codigo_docente}/{seccion_id}/{periodo_id}', [ReporteNotasController::class, 'cuadro'])->name('cuadro.pdf');
    
    Route::get('/boletas/pdf/{codigo_asignatura}/{codigo_docente}/{seccion_id}/{periodo_id}', [ReporteNotasController::class, 'boletas'])->name('boletas.pdf');

    Route::get('/dashboard', function () {return view('dashboard');})
    ->name('dashboard')
    ->middleware('can:estudiante-admin-dashboard');
    
    Route::get('/principal', Principales::class)
    ->name('principal');
    
    Route::get('/notasEstudiante/{asignaturaEstudianteId}', VistaNotaEstudiantes::class)
    ->name('notasEstudiante')
    ->middleware('can:estudiante-admin-notasestudiante');
    
    Route::get('/matricula-asignaturas', MatriculaAsignaturas::class)
    ->name('matricula-asignaturas')
    ->middleware('can:estudiante-admin-matricularasignatura');

    Route::get('/descargar-historial/{matriculaId}', [App\Http\Controllers\PDFController::class, 'generarHistorial'])
     ->name('descargarHistorial')
     ->middleware('auth');
     
    Route::get('/rol', Roles::class)
    ->name('rol')
    ->middleware('can:admin-admin-rol');
    
    Route::get('/instituto', Instituto::class)
    ->name('instituto')
    ->middleware('can:admin-admin-instituto');
    
    Route::get('/notas', Notas::class)
    ->name('notas')
    ->middleware('can:docente-admin-notas');

    Route::get('/historial-notas', HistorialNotas::class)
    ->name('historial-notas')
    ->middleware('can:docente-admin-notas');
    
    Route::get('/editarnotas', Notas::class)
    ->name('editarnotas')
    ->middleware('can:docente-admin-editarnotas');
    
    Route::get('/docente', Docentes::class)
    ->name('docente')
    ->middleware('can:admin-admin-docente');
    
    Route::get('/estudiante', Estudiants::class)
    ->name('estudiante')
    ->middleware('can:admin-admin-estudiante');
    
    Route::get('/userEstudiante', EstudiantePorUsuario::class)
    ->name('userEstudiante')
    ->middleware('can:estudiante-admin-userestudiante');
   
    Route::get('/asignatura', Asignaturas::class)
    ->name('asignatura')
    ->middleware('can:admin-admin-asignatura');
    
    Route::get('/seccion', Secciones::class)
    ->name('seccion')
    ->middleware('can:admin-admin-seccion');

    Route::get('/periodo', Periodos::class)
    ->name('periodo')
    ->middleware('can:admin-admin-periodo');
    
    Route::get('/asignaturaDocente', AsignaturaDocentes::class)
    ->name('asignaturaDocente')
    ->middleware('can:admin-admin-asignaturaDocente');
    
    Route::get('/asignaturaEstudiante', AsignaturaEstudiantes::class)
    ->name('asignaturaEstudiante')
    ->middleware('can:admin-admin-asignaturaestudiante');
    
    Route::get('/matricula', Matriculas::class)
    ->name('matricula')
    ->middleware('can:admin-admin-matricula');
    
    Route::get('/promocion', Promociones::class)
    ->name('promocion')
    ->middleware('can:admin-admin-promocion');
    
    Route::get('/programas', ProgramaFormaciones::class)
    ->name('programas')
    ->middleware('can:admin-admin-programas');
    
    Route::post('/actualizarNotas', [Notas::class, 'actualizarNotas'])
    ->name('actualizarNotas')
    ->middleware('can:docente-admin-actualizarnotas');
    
    Route::post('/importar-notas', [Notas::class, 'import'])
    ->name('notas.import')
    ->middleware('can:docente-admin-importarnotas');
    
    Route::get('/notas/edit/{asignatura_codigo}/{docente_codigo}', Notas::class)
    ->name('notas.edit')
    ->middleware('can:admin-admin-notasedit');

    Route::get('/users', Usuario::class)
    ->name('users')
    ->middleware('can:admin-admin-users');

    Route::get('setPerfil/{role_id}', [SetRoleController::class, 'SetRole'])
        ->name('setrole');
});
