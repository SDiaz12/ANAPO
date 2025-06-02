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
    public $mostrarTercerParcial = true;

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
        $nombreArchivo = 'Asignatura_' . $codigo_asignatura . 'Docente' . $codigo_docente . 'Seccion' . $seccion_id . '_Notas.xlsx';
        return Excel::download(new FormatoNotasExport($codigo_asignatura, $codigo_docente, $seccion_id), $nombreArchivo);
    }

    public function abrirModalGenerarCuadros($codigo_asignatura, $codigo_docente, $seccion_id)
    {
        $this->asignatura_id = $codigo_asignatura;
        $this->docente_id = $codigo_docente;
        $this->seccion_id = $seccion_id;
        $this->showGenerarCuadrosModal = true;
    }

    public function generarCuadro()
    {
        if ($this->cuadroSeleccionado === 'cuadro_final') {
            return redirect()->route('cuadro.pdf', [
                'codigo_asignatura' => $this->asignatura_id,
                'codigo_docente' => $this->docente_id,
                'seccion_id' => $this->seccion_id
            ]);
        } elseif ($this->cuadroSeleccionado === 'boletas') {
            return redirect()->route('boletas.pdf', [
                'codigo_asignatura' => $this->asignatura_id,
                'codigo_docente' => $this->docente_id,
                'seccion_id' => $this->seccion_id
            ]);
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

    public function storeEditar()
    {
        // Convertir valores vacíos en valores válidos - Usa & para crear referencias
        foreach ($this->estudiantes as &$estudiante) {
            // Si mostrarTercerParcial está desactivado, establecer tercerparcial como null
            if (!$this->mostrarTercerParcial) {
                $estudiante['tercerparcial'] = null;
            } else {
                $estudiante['tercerparcial'] = $estudiante['tercerparcial'] === '' ? null : $estudiante['tercerparcial'];
            }
            //$estudiante['tercerparcial'] = $estudiante['tercerparcial'] === '' ? null : $estudiante['tercerparcial'];
            $estudiante['segundoparcial'] = $estudiante['segundoparcial'] === '' ? null : $estudiante['segundoparcial'];
            $estudiante['asistencia'] = $estudiante['asistencia'] === '' ? '' : $estudiante['asistencia']; // Usa cadena vacía en lugar de null
            $estudiante['observacion'] = $estudiante['observacion'] === '' ? '' : $estudiante['observacion']; // Usa cadena vacía en lugar de null
            $estudiante['primerparcial'] = $estudiante['primerparcial'] === '' ? null : $estudiante['primerparcial'];
            $estudiante['recuperacion'] = $estudiante['recuperacion'] === '' ? null : $estudiante['recuperacion'];
        }
        // Importante: Desreferenciar después del bucle
        unset($estudiante);

        $this->validate([
            'estudiantes.*.asignatura_estudiante_id' => 'required|integer|exists:asignatura_estudiantes,id',
            'estudiantes.*.primerparcial' => 'required|numeric',
            'estudiantes.*.segundoparcial' => 'nullable|numeric',
            'estudiantes.*.tercerparcial' => 'nullable|numeric',
            'estudiantes.*.asistencia' => 'nullable|string|max:255',
            'estudiantes.*.recuperacion' => 'nullable|numeric',
            'estudiantes.*.observacion' => 'nullable|string|max:500',
        ]);

        foreach ($this->estudiantes as $estudiante) {
            // Verifica que el registro tenga un ID válido
            if (!isset($estudiante['id_nota']) || empty($estudiante['id_nota'])) {
                session()->flash('error', 'El ID de la nota no está disponible para el estudiante: ' . $estudiante['nombre']);
                continue;
            }

            $nota = Nota::find($estudiante['id_nota']);

            if ($nota) {
                $nota->update([
                    'primerparcial' => $estudiante['primerparcial'],
                    'segundoparcial' => $estudiante['segundoparcial'],
                    'tercerparcial' => $this->mostrarTercerParcial ? $estudiante['tercerparcial'] : null,
                    'asistencia' => $estudiante['asistencia'],
                    'recuperacion' => $estudiante['recuperacion'],
                    'observacion' => $estudiante['observacion'],
                ]);
            } else {
                session()->flash('error', 'No se encontró la nota con ID: ' . $estudiante['id_nota']);
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
        $nombreArchivo = 'Asignatura_' . $codigo_asignatura . '_Seccion' . $seccion_id . '_Notas.xlsx';

        // Usar el valor actual de $this->mostrarTercerParcial
        return Excel::download(
            new ActualizarNotasExport($codigo_asignatura, $codigo_docente, $seccion_id, $this->mostrarTercerParcial),
            $nombreArchivo
        );
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv',
        ]);

        Excel::import(new FormatoNotasImport, $request->file('file'));

        return back()->with('success', 'Notas importadas exitosamente.');
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
                asignaturadocentes.asignatura_id, 
                asignaturadocentes.seccion_id, 
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
            ->groupBy('asignaturadocentes.asignatura_id', 'asignaturadocentes.seccion_id', 'asignaturas.codigo', 'asignaturas.nombre', 'docentes.codigo', 'docentes.nombre', 'secciones.nombre', 'periodos.nombre')
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
    protected function verificarPromociones()
    {
        $periodoActual = Periodo::where('estado', 1)->first();
        if (!$periodoActual)
            return;
        $estudiantes = AsignaturaEstudiante::whereHas('asignaturadocente.periodo', function ($q) use ($periodoActual) {
            $q->where('id', $periodoActual->id);
        })
            ->with([
                'matricula.estudiante',
                'matricula.programaformacion.asignaturas' => function ($query) {
                    $query->where('estado', 1);
                },
                'nota',
                'asignaturadocente.asignatura'
            ])
            ->get()
            ->groupBy('matricula.estudiante_id');

        foreach ($estudiantes as $estudianteId => $asignaturasEstudiante) {
            $programa = $asignaturasEstudiante->first()->matricula->programaformacion;

            $yaPromovido = Promocion::where('estudiante_id', $estudianteId)
                ->where('programaformacion_id', $programa->id)
                ->exists();

            if ($yaPromovido)
                continue;
            $asignaturasRequeridas = $programa->asignaturas->pluck('id')->unique()->toArray();
            $asignaturasAprobadas = Nota::whereHas('asignaturaEstudiante', function ($query) use ($estudianteId) {
                $query->whereHas('matricula', function ($q) use ($estudianteId) {
                    $q->where('estudiante_id', $estudianteId);
                });
            })
                ->where(function ($query) {
                    $query->whereRaw('(primerparcial + segundoparcial + tercerparcial) / 3 >= 70')
                        ->orWhere('recuperacion', '>=', 70);
                })
                ->with('asignaturaEstudiante.asignaturadocente.asignatura')
                ->get()
                ->pluck('asignaturaEstudiante.asignaturadocente.asignatura_id')
                ->unique()
                ->toArray();
            $todasAprobadas = empty(array_diff($asignaturasRequeridas, $asignaturasAprobadas));

            if ($todasAprobadas) {
                $estudiante = $asignaturasEstudiante->first()->matricula->estudiante;

                Promocion::firstOrCreate([
                    'estudiante_id' => $estudianteId,
                    'programaformacion_id' => $programa->id,
                ], [
                    'nombre' => 'Promoción ' . now()->year,
                    'periodo_id' => $periodoActual->id,
                    'fecha_promocion' => now()->month(11)->day(30),
                    'estado' => 1
                ]);
            }
        }
    }
}