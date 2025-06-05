<?php

namespace App\Livewire\Nota;

use App\Models\Nota;
use App\Models\AsignaturaEstudiante;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\FormatoNotasExport;
use App\Imports\ActualizarNotas;
use App\Exports\ActualizarNotasExport;
use Illuminate\Http\Request;
use App\Exports\FormatoNotasImport;
use App\Models\Promocion;
use App\Models\Periodo;
use App\Models\Asignatura;
use Illuminate\Support\Facades\DB;
use App\Models\AsignaturaDocente;
use App\Models\ProgramaFormacion;
use App\Models\Matricula;
class Notas extends Component
{
    use WithPagination, WithFileUploads;

    public $showGenerarCuadrosModal = false;
    public $docente_id;
    public $file;
    public $confirmingDelete = false;
    public $IdAEliminar, $nombreAEliminar, $search, $estudiantes, $nota_id;
    public $promedio, $asignatura_estudiante_id, $primerparcial, $segundoparcial, $tercerparcial;
    public $asistencia, $recuperacion, $observacion, $estado = 1, $asignatura_id;
    public $isOpen = false, $viewMode = 'table', $codigo_estudiante, $nombre_estudiante, $apellido_estudiante;
    public $perPage = 9, $notas = [];
    public $cuadroSeleccionado;
    public $nombre_docente;
    public $showVerNotasModal = false;
    public $seccion_id;
    public $mostrarTercerParcial;

    public function placeholder()
    {
        return view('livewire.Placeholder.loader')->layout('layouts.app');
    }

    public function toggleViewMode()
    {
        $this->viewMode = $this->viewMode === 'table' ? 'cards' : 'table';
    }

    public function exportarNotas($codigo_asignatura, $codigo_docente, $seccion_id)
    {
         $asignatura = Asignatura::where('codigo', $codigo_asignatura)->first();
        $nombreAsignatura = $asignatura ? $asignatura->nombre : $codigo_asignatura;
        $nombreArchivo = 'Cuadro de Notas - ' . $nombreAsignatura . ' - ' . now()->format('Y') . '.xlsx';
         $asignaturaDocente = AsignaturaDocente::whereHas('asignatura', function($query) use ($codigo_asignatura) {
                $query->where('codigo', $codigo_asignatura);
            })
            ->whereHas('docente', function($query) use ($codigo_docente) {
                $query->where('codigo', $codigo_docente);
            })
            ->where('seccion_id', $seccion_id)
            ->first();
            
        $mostrarTercerParcial = $asignaturaDocente ? $asignaturaDocente->mostrarTercerParcial : false;
        return Excel::download(new FormatoNotasExport($codigo_asignatura, $codigo_docente, $seccion_id), $nombreArchivo);
    }

    public function abrirModalGenerarCuadros($codigo_asignatura, $codigo_docente, $seccion_id, $periodo_id = null)
    {
        if (empty($periodo_id)) {
            $periodo_id = Periodo::where('estado', 1)->value('id') ?? abort(404, 'No hay período activo');
        }

        $this->asignatura_id = $codigo_asignatura;
        $this->docente_id = $codigo_docente;
        $this->seccion_id = $seccion_id;
        $this->periodo_id = $periodo_id;
        $this->showGenerarCuadrosModal = true;
    }
    public $periodo_id;
    public function generarCuadro()
    {
        try {
            if (empty($this->periodo_id)) {
                throw new \Exception('Periodo académico no especificado');
            }

            $params = [
                'codigo_asignatura' => $this->asignatura_id,
                'codigo_docente' => $this->docente_id,
                'seccion_id' => $this->seccion_id,
                'periodo_id' => $this->periodo_id
            ];

            return redirect()->route(
                $this->cuadroSeleccionado === 'cuadro_final' ? 'cuadro.pdf' : 'boletas.pdf',
                $params
            );

        } catch (\Exception $e) {
            $this->dispatch('toast', [
                'type' => 'error',
                'message' => $e->getMessage()
            ]);
            return;
        }
    }
    public function create($codigo_asignatura, $codigo_docente, $seccion_id)
    {
        $this->resetInputFields();
        $this->seccion_id = $seccion_id;

        $asignaturaEstudiantes = AsignaturaEstudiante::whereHas('asignaturadocente', function ($query) use ($codigo_asignatura, $codigo_docente, $seccion_id) {
            $query->whereHas('asignatura', function ($query) use ($codigo_asignatura) {
                $query->where('codigo', $codigo_asignatura)
                    ->where('estado', 1);
            })
                ->whereHas('docente', function ($query) use ($codigo_docente) {
                    $query->where('codigo', $codigo_docente);
                })
                ->whereHas('periodo', function ($query) {
                    $query->where('estado', 1);
                })
                ->where('seccion_id', $seccion_id)
                ->where('estado', 1);
        })
            ->with([
                'matricula.estudiante',
                'asignaturadocente.asignatura',
                'asignaturadocente.docente',
                'asignaturadocente.seccion'
            ])
            ->get();

        if ($asignaturaEstudiantes->isEmpty()) {
            session()->flash('error', 'No hay estudiantes matriculados en esta asignatura para la sección seleccionada.');
            return;
        }

        $this->estudiantes = $asignaturaEstudiantes->map(function ($asignaturaEstudiante) {
            $this->notas[$asignaturaEstudiante->matricula->estudiante->id] = [
                'asignatura_estudiante_id' => $asignaturaEstudiante->id,
                'primerparcial' => null,
                'segundoparcial' => null,
                'tercerparcial' => null,
                'asistencia' => '',
                'recuperacion' => null,
                'observacion' => '',
            ];

            return [
                'asignatura_estudiante_id' => $asignaturaEstudiante->id,
                'id' => $asignaturaEstudiante->matricula->estudiante->id,
                'codigo' => $asignaturaEstudiante->matricula->estudiante->codigo,
                'nombre' => $asignaturaEstudiante->matricula->estudiante->nombre,
                'apellido' => $asignaturaEstudiante->matricula->estudiante->apellido,
                'docente' => $asignaturaEstudiante->asignaturadocente->docente->nombre ?? 'Sin docente',
                'seccion' => $asignaturaEstudiante->asignaturadocente->seccion->nombre ?? 'Sin sección',
            ];
        });

        $this->openModal();
    }

    public function store()
    {
        $this->validate([
            'notas.*.asignatura_estudiante_id' => 'required|integer|exists:asignatura_estudiantes,id',
            'notas.*.primerparcial' => 'required|numeric',
            'notas.*.segundoparcial' => 'nullable|numeric',
            'notas.*.tercerparcial' => 'nullable|numeric',
            'notas.*.asistencia' => 'nullable|string|max:255',
            'notas.*.recuperacion' => 'nullable|numeric',
            'notas.*.observacion' => 'nullable|string|max:500',
        ]);

        foreach ($this->notas as $id => $nota) {
            if (empty($nota['asignatura_estudiante_id'])) {
                session()->flash('error', 'El ID de asignatura del estudiante no está disponible.');
                return;
            }

            try {
                Nota::updateOrCreate(
                    ['asignatura_estudiante_id' => $nota['asignatura_estudiante_id']],
                    [
                        'primerparcial' => $nota['primerparcial'],
                        'segundoparcial' => $nota['segundoparcial'],
                        'tercerparcial' => $nota['tercerparcial'],
                        'asistencia' => $nota['asistencia'],
                        'recuperacion' => $nota['recuperacion'],
                        'observacion' => $nota['observacion'],
                        'estado' => $this->estado,
                    ]
                );
            } catch (\Exception $e) {
                session()->flash('error', 'Error al guardar las notas: ' . $e->getMessage());
                return;
            }
        }

        session()->flash('success', 'Notas registradas correctamente.');
        $this->closeModal();
        $this->resetInputFields();
    }

    public function edit($codigo_asignatura, $codigo_docente, $seccion_id)
    {
        $this->seccion_id = $seccion_id;

        $notas = Nota::whereHas('asignaturaEstudiante.asignaturadocente', function ($query) use ($codigo_asignatura, $codigo_docente, $seccion_id) {
            $query->whereHas('asignatura', function ($q) use ($codigo_asignatura) {
                $q->where('codigo', $codigo_asignatura)
                    ->where('estado', 1);
            })
            ->whereHas('docente', function ($q) use ($codigo_docente) {
                $q->where('codigo', $codigo_docente);
            })
            ->whereHas('periodo', function ($q) {
                $q->where('estado', 1);
            })
            ->where('seccion_id', $seccion_id)
            ->where('estado', 1);
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

        $asignaturaDocente = $notas->first()->asignaturaEstudiante->asignaturadocente ?? null;
        $this->mostrarTercerParcial = $asignaturaDocente && $asignaturaDocente->mostrarTercerParcial;

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

        $this->openModalEditar('VerNotas');
    }

    protected function normalizeNoteValue($value)
    {
        if ($value === '' || $value === null) {
            return null;
        }
        return max(0, min(100, (float) $value));
    }

    public function storeEditar()
    {
        $this->validate([
            'estudiantes.*.asignatura_estudiante_id' => 'required|integer|exists:asignatura_estudiantes,id',
            'estudiantes.*.primerparcial' => 'required|numeric|min:0|max:100',
            'estudiantes.*.segundoparcial' => 'nullable|numeric|min:0|max:100',
            'estudiantes.*.tercerparcial' => 'nullable|numeric|min:0|max:100',
            'estudiantes.*.asistencia' => 'nullable|string|max:255',
            'estudiantes.*.recuperacion' => 'nullable|numeric|min:0|max:100',
            'estudiantes.*.observacion' => 'nullable|string|max:500',
        ]);

        foreach ($this->estudiantes as $estudiante) {
            try {
                if (empty($estudiante['id_nota'])) {
                    throw new \Exception('ID de nota no disponible para: ' . ($estudiante['nombre'] ?? 'Desconocido'));
                }
                $data = [
                    'primerparcial' => $this->normalizeNoteValue($estudiante['primerparcial']),
                    'segundoparcial' => $this->normalizeNoteValue($estudiante['segundoparcial']),
                    'asistencia' => $estudiante['asistencia'] ?? '',
                    'recuperacion' => $this->normalizeNoteValue($estudiante['recuperacion']),
                    'observacion' => $estudiante['observacion'] ?? '',
                ];

  
                if ($this->mostrarTercerParcial) {
                    $data['tercerparcial'] = $this->normalizeNoteValue($estudiante['tercerparcial']);
                } else {
                    $data['tercerparcial'] = null; 
                }

                $nota = Nota::findOrFail($estudiante['id_nota']);
                $nota->update($data);

            } catch (\Exception $e) {
                session()->flash('error', 'Error al actualizar notas: ' . $e->getMessage());
                continue;
            }
        }

        session()->flash('success', 'Notas actualizadas correctamente.');
        $this->closeModal();
        $this->resetInputFields();
    }

    public function hasNotas($codigo_asignatura, $codigo_docente, $seccion_id)
    {
        return Nota::whereHas('asignaturaEstudiante.asignaturadocente', function ($query) use ($codigo_asignatura, $codigo_docente, $seccion_id) {
            $query->whereHas('asignatura', function ($query) use ($codigo_asignatura) {
                $query->where('codigo', $codigo_asignatura)
                    ->where('estado', 1);
            })
                ->whereHas('docente', function ($query) use ($codigo_docente) {
                    $query->where('codigo', $codigo_docente);
                })
                ->whereHas('periodo', function ($query) {
                    $query->where('estado', 1);
                })
                ->where('seccion_id', $seccion_id)
                ->where('estado', 1);
        })->exists();
    }

    public function actualizarNotas(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048',
        ]);

        try {
            Excel::import(new ActualizarNotas, $request->file('file'));
            return back()->with('success', 'Notas actualizadas exitosamente.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al actualizar notas: ' . $e->getMessage());
        }
    }

   public function exportNotas($codigo_asignatura, $codigo_docente, $seccion_id)
    {
        $asignatura = Asignatura::where('codigo', $codigo_asignatura)->first();
        $nombreAsignatura = $asignatura ? $asignatura->nombre : $codigo_asignatura;
        
       
        $asignaturaDocente = AsignaturaDocente::whereHas('asignatura', function($query) use ($codigo_asignatura) {
                $query->where('codigo', $codigo_asignatura);
            })
            ->whereHas('docente', function($query) use ($codigo_docente) {
                $query->where('codigo', $codigo_docente);
            })
            ->where('seccion_id', $seccion_id)
            ->first();
            
        $mostrarTercerParcial = $asignaturaDocente ? $asignaturaDocente->mostrarTercerParcial : false;
    
        
        $nombreArchivo = 'Cuadro de Notas - ' . $nombreAsignatura . ' - ' . now()->format('Y') . '.xlsx';

        return Excel::download(
            new ActualizarNotasExport($codigo_asignatura, $codigo_docente, $seccion_id),
            $nombreArchivo
        );
    }

    protected $tieneTercerParcial;

    public function __construct($codigo_asignatura = null, $codigo_docente = null, $seccion_id = null, $tieneTercerParcialManual = null)
    {
        if ($codigo_asignatura && $codigo_docente && $seccion_id) {
            $asignaturaDocente = AsignaturaDocente::whereHas('asignatura', function ($q) use ($codigo_asignatura) {
                $q->where('codigo', $codigo_asignatura)->where('estado', 1);
            })
            ->whereHas('docente', function ($q) use ($codigo_docente) {
                $q->where('codigo', $codigo_docente);
            })
            ->where('seccion_id', $seccion_id)
            ->where('estado', 1)
            ->first();

            $this->tieneTercerParcial = $asignaturaDocente ? $asignaturaDocente->mostrarTercerParcial : false;
        } else {
            $this->tieneTercerParcial = $tieneTercerParcialManual ?? false;
        }
    }
    
   public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv'
        ]);

        try {
            Excel::import(new FormatoNotasImport, $request->file('file'));

            return back()->with('success', 'Notas importadas exitosamente.');
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();

            return back()->withErrors(['file' => 'Error de validación en el archivo.'])->with('failures', $failures);
        } catch (\Exception $e) {
            \Log::error('Error durante la importación de notas: ' . $e->getMessage());

            return back()->withErrors(['file' => 'Ocurrió un error al importar el archivo.']);
        }
    }

    public function openModal()
    {
        $this->isOpen = true;
    }

    public function openModalEditar($modal = 'default')
    {
        if ($modal === 'VerNotas') {
            $this->showVerNotasModal = true;
        }
    }

    public function closeModal()
    {
        $this->isOpen = false;
        $this->showVerNotasModal = false;
        $this->showGenerarCuadrosModal = false;
    }

    public function resetInputFields()
    {
        $this->nota_id = null;
        $this->asignatura_estudiante_id = null;
        $this->primerparcial = '';
        $this->segundoparcial = '';
        $this->tercerparcial = '';
        $this->asistencia = '';
        $this->recuperacion = '';
        $this->promedio = '';
        $this->observacion = '';
        $this->estado = 1;
        $this->seccion_id = null;
    }

    public function delete()
    {
        if ($this->confirmingDelete) {
            Nota::find($this->IdAEliminar)?->delete();
            session()->flash('message', 'Nota eliminada correctamente!');
            $this->confirmingDelete = false;
        }
    }

    public function toggleEstado($id)
    {
        $nota = Nota::findOrFail($id);
        $nota->estado = !$nota->estado;
        $nota->save();
    }

    public function loadMore($suma)
    {
        $this->perPage = $suma;
    }

    public function mount()
    {
        $this->estudiantes = collect();
    }
    public function render()
    {
        $this->verificarPromociones();

        $user = auth()->user();

        $query = AsignaturaEstudiante::query()
            ->with([
                'asignaturadocente.asignatura',
                'asignaturadocente.docente',
                'asignaturadocente.periodo',
                'asignaturadocente.seccion',
                'matricula.estudiante',
                'matricula.programaformacion'
            ])
            ->whereHas('asignaturadocente.asignatura', function ($query) {
                $query->where('estado', 1);
            })
            ->whereHas('asignaturadocente.periodo', function ($query) {
                $query->where('estado', 1);
            })
            ->whereHas('asignaturadocente', function ($query) {
                $query->where('estado', 1);
            });

        if ($user && !$user->hasRole('root')) {
            $query->whereHas('asignaturadocente.docente', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            });
        }

        $asignaturas = $query->selectRaw('
                asignaturadocentes.id as asignatura_docente_id,
                asignaturadocentes.asignatura_id, 
                asignaturadocentes.docente_id,
                asignaturadocentes.seccion_id, 
                asignaturadocentes.mostrarTercerParcial,
                COUNT(asignatura_estudiantes.id) as estudiantes_count,
                asignaturas.codigo as asignatura_codigo,
                asignaturas.nombre as asignatura_nombre,
                docentes.codigo as docente_codigo,
                docentes.nombre as docente_nombre,
                secciones.nombre as seccion_nombre,
                periodos.nombre as periodo_nombre
            ')
            ->join('asignaturadocentes', 'asignatura_estudiantes.asignatura_id', '=', 'asignaturadocentes.id')
            ->join('asignaturas', 'asignaturadocentes.asignatura_id', '=', 'asignaturas.id')
            ->join('docentes', 'asignaturadocentes.docente_id', '=', 'docentes.id')
            ->join('secciones', 'asignaturadocentes.seccion_id', '=', 'secciones.id')
            ->join('periodos', 'asignaturadocentes.periodo_id', '=', 'periodos.id')
            ->groupBy(
                'asignaturadocentes.id',
                'asignaturadocentes.asignatura_id',
                'asignaturadocentes.docente_id',
                'asignaturadocentes.seccion_id',
                'asignaturadocentes.mostrarTercerParcial',
                'asignaturas.codigo',
                'asignaturas.nombre',
                'docentes.codigo',
                'docentes.nombre',
                'secciones.nombre',
                'periodos.nombre'
            )
            ->paginate($this->perPage);

        if ($user && !$user->hasRole('root') && $asignaturas->isEmpty()) {
            session()->flash('info', 'No tiene asignaturas asignadas activas en el periodo actual.');
        }

        return view('livewire.nota.notas', [
            'asignaturas' => $asignaturas,
        ])->layout('layouts.app');
    }
    public function redirectToHistorial()
    {
        return redirect()->route('historial-notas');
    }

    public function toggleParcial($asignaturaDocenteId)
    {
        try {
            $asignaturaDocente = AsignaturaDocente::find($asignaturaDocenteId);
            
            if ($asignaturaDocente) {
                $asignaturaDocente->mostrarTercerParcial = !$asignaturaDocente->mostrarTercerParcial;
                $asignaturaDocente->save();

                $this->dispatch('toast', 
                    type: 'success', 
                    message: 'Configuración actualizada: ' . ($asignaturaDocente->mostrarTercerParcial ? '3 parciales' : '2 parciales')
                );
            } else {
                $this->dispatch('toast', 
                    type: 'error', 
                    message: 'No se encontró la asignación docente'
                );
            }
        } catch (\Exception $e) {
            $this->dispatch('toast', 
                type: 'error', 
                message: 'Error: ' . $e->getMessage()
            );
        }
    }
   protected function verificarPromociones()
{
    $periodoActual = Periodo::where('estado', 1)->first();
    
    if (!$periodoActual) {
        logger()->error('No hay período activo para verificar promociones');
        return;
    }

    $programas = ProgramaFormacion::with(['asignaturas' => function($q) {
        $q->where('estado', 1);
    }])->where('estado', 1)->get();

    foreach ($programas as $programa) {
        $matriculas = Matricula::where('programaformacion_id', $programa->id)
            ->where('estado', 1)
            ->with(['estudiante', 'asignaturasEstudiantes' => function($query) {
                $query->with(['nota', 'asignaturadocente.asignatura']);
            }])
            ->get();

        foreach ($matriculas as $matricula) {
            $estudianteId = $matricula->estudiante_id;
            
            if (Promocion::where('estudiante_id', $estudianteId)
                ->where('programaformacion_id', $programa->id)
                ->exists()) {
                continue;
            }

            $asignaturasRequeridas = $programa->asignaturas->pluck('id')->toArray();
            $asignaturasAprobadas = [];

            foreach ($matricula->asignaturasEstudiantes as $asignaturaEst) {
                if (!$asignaturaEst->nota) continue;

                $nota = $asignaturaEst->nota;
                $asignaturaId = $asignaturaEst->asignaturadocente->asignatura_id;

                $aprobada = false;
                
                if ($asignaturaEst->asignaturadocente->mostrarTercerParcial) {
                    $promedio = ($nota->primerparcial + $nota->segundoparcial + $nota->tercerparcial) / 3;
                    $aprobada = $promedio >= 70 || $nota->recuperacion >= 70;
                } else {
                    $promedio = ($nota->primerparcial + $nota->segundoparcial) / 2;
                    $aprobada = $promedio >= 70 || $nota->recuperacion >= 70;
                }

                if ($aprobada) {
                    $asignaturasAprobadas[] = $asignaturaId;
                }
            }

            $asignaturasFaltantes = array_diff($asignaturasRequeridas, array_unique($asignaturasAprobadas));
            
            if (empty($asignaturasFaltantes)) {
                Promocion::firstOrCreate([
                    'estudiante_id' => $estudianteId,
                    'programaformacion_id' => $programa->id,
                ], [
                    'nombre' => 'Promoción ' . now()->year,
                    'periodo_id' => $periodoActual->id,
                    'fecha_promocion' => now()->month(11)->day(30),
                    'estado' => 1
                ]);

                logger()->info("Estudiante {$matricula->estudiante->nombre} promovido en programa {$programa->nombre}");
            }
        }
    }
}
}