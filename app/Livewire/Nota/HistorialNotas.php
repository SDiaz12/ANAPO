<?php

namespace App\Livewire\Nota;

use App\Models\Nota;
use App\Models\AsignaturaEstudiante;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Periodo;

class HistorialNotas extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 9;
    public $viewMode = 'table';
    public $periodo_id;
    public $periodos;
    public $showGenerarCuadrosModal = false;
    public $showVerNotasModal = false;
    public $docente_id, $seccion_id, $asignatura_id;
    public $estudiantes = [];
    public $cuadroSeleccionado;

    public function mount()
    {
        $this->periodos = Periodo::orderBy('nombre', 'desc')->get();
    }

    public function toggleViewMode()
    {
        $this->viewMode = $this->viewMode === 'table' ? 'cards' : 'table';
    }

    public function loadMore($suma)
    {
        $this->perPage = $suma;
    }

    public function abrirModalGenerarCuadros($codigo_asignatura, $codigo_docente, $seccion_id, $periodo_id)
    {
        $this->asignatura_id = $codigo_asignatura;
        $this->docente_id = $codigo_docente;
        $this->seccion_id = $seccion_id;
        $this->periodo_id = $periodo_id;
        $this->showGenerarCuadrosModal = true;
    }

    public function generarCuadro()
    {
        if ($this->cuadroSeleccionado === 'cuadro_final') {
            return redirect()->route('cuadro.pdf', [
                'codigo_asignatura' => $this->asignatura_id,
                'codigo_docente' => $this->docente_id,
                'seccion_id' => $this->seccion_id,
                'periodo_id' => $this->periodo_id
            ]);
        } elseif ($this->cuadroSeleccionado === 'boletas') {
            return redirect()->route('boletas.pdf', [
                'codigo_asignatura' => $this->asignatura_id,
                'codigo_docente' => $this->docente_id,
                'seccion_id' => $this->seccion_id,
                'periodo_id' => $this->periodo_id
            ]);
        }
    }

    public function verNotas($codigo_asignatura, $codigo_docente, $seccion_id, $periodo_id)
    {
        $this->seccion_id = $seccion_id;
        
        $notas = Nota::whereHas('asignaturaEstudiante.asignaturadocente', function ($query) use ($codigo_asignatura, $codigo_docente, $seccion_id, $periodo_id) {
            $query->whereHas('asignatura', function ($q) use ($codigo_asignatura) {
                $q->where('codigo', $codigo_asignatura);
            })
            ->whereHas('docente', function ($q) use ($codigo_docente) {
                $q->where('codigo', $codigo_docente);
            })
            ->where('seccion_id', $seccion_id)
            ->whereHas('periodo', function($q) use ($periodo_id) {
                $q->where('id', $periodo_id);
            });
        })
        ->with([
            'asignaturaEstudiante.matricula.estudiante',
            'asignaturaEstudiante.asignaturadocente.seccion'
        ])
        ->get();

        if ($notas->isEmpty()) {
            session()->flash('error', 'No hay notas registradas para esta asignatura en la sección seleccionada.');
            return;
        }
    
        $this->estudiantes = $notas->map(function ($nota) {
            return [
                'asignatura_estudiante_id' => $nota->asignatura_estudiante_id,
                'id' => $nota->asignaturaEstudiante->matricula->estudiante->id,
                'codigo' => $nota->asignaturaEstudiante->matricula->estudiante->codigo,
                'nombre' => $nota->asignaturaEstudiante->matricula->estudiante->nombre,
                'apellido' => $nota->asignaturaEstudiante->matricula->estudiante->apellido,
                'id_nota' => $nota->id,
                'primerparcial' => $nota->primerparcial,
                'segundoparcial' => $nota->segundoparcial,
                'tercerparcial' => $nota->tercerparcial,
                'asistencia' => $nota->asistencia,
                'recuperacion' => $nota->recuperacion,
                'observacion' => $nota->observacion,
                'seccion' => $nota->asignaturaEstudiante->asignaturadocente->seccion->nombre ?? 'Sin sección',
            ];
        })->toArray();
    
        $this->showVerNotasModal = true;
    }

    public function closeModal()
    {
        $this->showVerNotasModal = false;
        $this->showGenerarCuadrosModal = false;
    }

    public function render()
    {
        $user = auth()->user();
        
        $query = AsignaturaEstudiante::query()
            ->with([
                'asignaturadocente.asignatura', 
                'asignaturadocente.docente', 
                'asignaturadocente.periodo',
                'asignaturadocente.seccion',
                'matricula.estudiante',
                'nota'
            ])
            ->whereHas('nota')
            ->whereHas('asignaturadocente.periodo', function($q) {
                $q->where('estado', '0'); 
            });

        if ($this->periodo_id) {
            $query->whereHas('asignaturadocente.periodo', function($q) {
                $q->where('id', $this->periodo_id);
            });
        }

        if ($user && !$user->hasRole('root')) {
            $query->whereHas('asignaturadocente.docente', function($q) use ($user) {
                $q->where('user_id', $user->id);
            });
        }

        $asignaturas = $query->selectRaw('
            asignaturadocentes.asignatura_id, 
            asignaturadocentes.seccion_id, 
            COUNT(asignatura_estudiantes.id) as estudiantes_count,
            asignaturas.codigo as asignatura_codigo,
            asignaturas.nombre as asignatura_nombre,
            docentes.codigo as docente_codigo,
            docentes.nombre as docente_nombre,
            secciones.nombre as seccion_nombre,
            periodos.nombre as periodo_nombre,
            periodos.id as periodo_id,
            periodos.estado as periodo_estado,
            asignaturadocentes.estado as asignatura_docente_estado 
        ')
            ->join('asignaturadocentes', 'asignatura_estudiantes.asignatura_id', '=', 'asignaturadocentes.id')
            ->join('asignaturas', 'asignaturadocentes.asignatura_id', '=', 'asignaturas.id')
            ->join('docentes', 'asignaturadocentes.docente_id', '=', 'docentes.id')
            ->join('secciones', 'asignaturadocentes.seccion_id', '=', 'secciones.id')
            ->join('periodos', 'asignaturadocentes.periodo_id', '=', 'periodos.id')
            ->groupBy(
                'asignaturadocentes.asignatura_id', 
                'asignaturadocentes.seccion_id', 
                'asignaturas.codigo', 
                'asignaturas.nombre', 
                'docentes.codigo', 
                'docentes.nombre', 
                'secciones.nombre', 
                'periodos.nombre',
                'periodos.id',
                'periodos.estado',
                'asignaturadocentes.estado'
            )
            ->orderBy('periodos.id', 'DESC')
            ->paginate($this->perPage);

        $periodoActivo = Periodo::where('estado', '1')->exists();

        return view('livewire.nota.historial-notas', [
            'asignaturas' => $asignaturas,
            'periodoActivo' => $periodoActivo
        ])->layout('layouts.app');
    }

    public function redirectToNotas()
    {
        return redirect()->route('notas');
    }
}