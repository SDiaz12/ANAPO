<?php

namespace App\Livewire\AsignaturaDocente;

use App\Models\AsignaturaDocente;
use App\Models\Docente;
use App\Models\Asignatura;
use App\Models\AsignaturaEstudiante;
use App\Models\Periodo;
use App\Models\Seccion;
use Livewire\Attributes\Lazy;
use Livewire\Component;
use Livewire\WithPagination;
//#[Lazy()]
class AsignaturaDocentes extends Component
{
    use WithPagination;

    public $confirmingDelete = false;
    public $IdAEliminar, $docenteAEliminar;
    public $search, $docente_id, $asignatura_id, $periodo_id, $seccion_id, $estado;
    public $isOpen = false;
    public $viewMode = 'table';  

    public $docentes = [];
    public $asignaturas = [];
    public $secciones = [];
    public $periodos = [];
    public $selectedPeriodos = [];
    public $selectedSecciones = [];
    
    public function placeholder()
    {
        return view('livewire.Placeholder.loader')->layout('layouts.app');
    }

    public function toggleViewMode()
    {
        $this->viewMode = $this->viewMode === 'table' ? 'cards' : 'table';
    }

 
    public function create()
    {
        $this->resetInputFields();
        $this->openModal();
    }

    public function toggleEstado($id)
    {
        $asignatura = AsignaturaDocente::findOrFail($id);
        $asignatura->estado = !$asignatura->estado;
        $asignatura->save();
    }
    public function toggleParcial($id)
    {
        $asignatura = AsignaturaDocente::findOrFail($id);
        $asignatura->mostrarTercerParcial = !$asignatura->mostrarTercerParcial;
        $asignatura->save();
    }
    public $codigoDocente, $nombreCompleto, $error;
    public $selectedAsignaturas = [];
    
    public function toggleAsignaturaSelection($asignaturaId)
    {
        if (in_array($asignaturaId, $this->selectedAsignaturas)) {
            $this->selectedAsignaturas = array_filter($this->selectedAsignaturas, fn($id) => $id !== $asignaturaId);
        } else {
            $this->selectedAsignaturas[] = $asignaturaId;
        }
    }

    public $inputSearchdocente = '';  
    public $searchdocente= [];

    public function updatedInputSearchdocente()
    {
        $this->searchdocente = Docente::where('nombre', 'like', '%' . $this->inputSearchdocente . '%')
            ->where('estado', 1) 
            ->limit(10)
            ->get();
    }

    public function selectdocente($id)
    {
        $docente = Docente::find($id);

        if (!$docente) {
            session()->flash('error', 'Docente no encontrado.');
            $this->searchdocente = [];
            return;
        }

        if ($docente->estado != 1) {
            session()->flash('error', 'Este docente no está activo y no puede ser seleccionado.');
            $this->searchdocente = [];
            return;
        }

        $this->docente_id = $id;
        $this->inputSearchdocente = $docente->nombre;
        $this->searchdocente = [];
    }

    public function openModal()
    {
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
    }

    public function resetInputFields()
    {
        $this->docente_id = '';
        $this->asignatura_id = '';
        $this->periodo_id = '';
        $this->seccion_id = '';
        $this->estado = '';
        $this->mostrarTercerParcial = '';
    }

 
    public function delete()
    {
        if ($this->confirmingDelete) {
            $asignaturaDocente = AsignaturaDocente::find($this->IdAEliminar);

            if (!$asignaturaDocente) {
                session()->flash('error', 'AsignaturaDocente no encontrada.');
                $this->confirmingDelete = false;
                return;
            }

            $asignaturaDocente->forceDelete();
            session()->flash('message', 'AsignaturaDocente eliminada correctamente!');
            $this->confirmingDelete = false;
        }
    }

    public $cantidad_materias; 
   public function updatedCantidadMaterias()
    {
        $cantidad = intval($this->cantidad_materias);

        if ($cantidad > 0) {
            $this->selectedAsignaturas = array_fill(0, $cantidad, null);
            $this->selectedPeriodos = array_fill(0, $cantidad, null);
            $this->selectedSecciones = array_fill(0, $cantidad, null);
            $this->mostrarTercerParcial = array_fill(0, $cantidad, false);
        } else {
            $this->selectedAsignaturas = [];
            $this->selectedPeriodos = [];
            $this->selectedSecciones = [];
            $this->mostrarTercerParcial = [];
        }
    }

    
    public $mostrarTercerParcial = [];
  public function store()
    {
        $this->validate([
            'docente_id' => 'required|integer|exists:docentes,id',
            'selectedAsignaturas' => 'required|array|min:1',
            'selectedAsignaturas.*' => 'integer|exists:asignaturas,id',
            'selectedSecciones' => 'required|array|min:1',
            'selectedSecciones.*' => 'integer|exists:secciones,id',
            'selectedPeriodos' => 'required|array|min:1',
            'selectedPeriodos.*' => 'integer|exists:periodos,id',
        ]);

        
        $combinaciones = [];
        foreach ($this->selectedAsignaturas as $key => $asignaturaId) {
            $periodoId = $this->selectedPeriodos[$key];
            $seccionId = $this->selectedSecciones[$key];
            
            $clave = "$periodoId-$seccionId";
            if (in_array($clave, $combinaciones)) {
                session()->flash('error', 'No puedes asignar al docente a la misma sección y período más de una vez.');
                return;
            }
            $combinaciones[] = $clave;
        }

        foreach ($this->selectedAsignaturas as $key => $asignaturaId) {
            $periodoId = $this->selectedPeriodos[$key];
            $seccionId = $this->selectedSecciones[$key];

            $existeAsignacion = AsignaturaDocente::where('docente_id', $this->docente_id)
                ->where('periodo_id', $periodoId)
                ->where('seccion_id', $seccionId)
                ->exists();
                
            if ($existeAsignacion) {
                $periodo = Periodo::find($periodoId)->nombre;
                $seccion = Seccion::find($seccionId)->nombre;
                
                session()->flash('error', "El docente ya tiene una asignación en la sección $seccion del período $periodo.");
                return;
            }
            $existeCombinacionExacta = AsignaturaDocente::where('docente_id', $this->docente_id)
                ->where('asignatura_id', $asignaturaId)
                ->where('periodo_id', $periodoId)
                ->where('seccion_id', $seccionId)
                ->exists();
                
            if ($existeCombinacionExacta) {
                $asignatura = Asignatura::find($asignaturaId)->nombre;
                session()->flash('error', "El docente ya tiene asignada la materia $asignatura en esta sección y período.");
                return;
            }
        }

        foreach ($this->selectedAsignaturas as $key => $asignaturaId) {
            AsignaturaDocente::create([
                'docente_id' => $this->docente_id,
                'asignatura_id' => $asignaturaId,
                'periodo_id' => $this->selectedPeriodos[$key],
                'seccion_id' => $this->selectedSecciones[$key],
                'estado' => 1,
               'mostrarTercerParcial' => !empty($this->mostrarTercerParcial[$key]) ? 1 : 0,
            ]);
        }

        session()->flash('message', 'Asignaturas asignadas correctamente!');
        $this->resetInputFields();
        $this->closeModal();
    }
    public function syncEstadoConPeriodo()
    {
      
        $periodos = Periodo::select('id', 'estado')->get();

        foreach ($periodos as $periodo) {
            AsignaturaDocente::where('periodo_id', $periodo->id)
            ->update(['estado' => $periodo->estado]);
        }
    }
    public function confirmDelete($id)
    {
        $asignaturaDocente = AsignaturaDocente::find($id);
       
        if (!$asignaturaDocente) {
            session()->flash('error', 'AsignaturaDocente no encontrada.');
            return;
        }
        $tieneEstudiantes = AsignaturaEstudiante::whereHas('asignaturaDocente', function ($query) use ($asignaturaDocente) {
            $query->where('id', $asignaturaDocente->id);
        })->exists();
        
        if ($tieneEstudiantes) {
            session()->flash('error', 'No se puede eliminar la asignación porque tiene estudiantes asociados al docente y la asignatura.');
            return;
        }
        
    
        $this->IdAEliminar = $id;
        $this->docenteAEliminar = $asignaturaDocente->docente->nombre;
        $this->confirmingDelete = true;
    }

    
    public $perPage = 9;
    public function loadMore($suma)
    {
        $this->perPage = $suma;
    }
    public function mount()
    {
        $this->syncEstadoConPeriodo();
    }
    public function render()
    {
        $this->syncEstadoConPeriodo(); 

        $asignaturasDocentes = AsignaturaDocente::with('docente', 'asignatura', 'periodo', 'seccion')
            ->where(function($query) {
                $query->whereHas('docente', function($q) {
                    $q->where('nombre', 'like', '%' . $this->search . '%');
                })
                ->orWhereHas('asignatura', function($q) {
                    $q->where('nombre', 'like', '%' . $this->search . '%')
                    ->orWhere('codigo', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy('id', 'DESC')
            ->paginate($this->perPage);
    
       
        $this->asignaturas = Asignatura::where('estado', 1)
            ->orderBy('nombre', 'asc')
            ->get();
    
        $this->docentes = Docente::where('estado', 1)
            ->orderBy('nombre', 'asc')
            ->get();
    
        $this->periodos = Periodo::where('estado', 1)
            ->orderBy('nombre', 'asc')
            ->get();
    
        $this->secciones = Seccion::where('estado', 1)
            ->orderBy('nombre', 'asc')
            ->get();
    
        return view('livewire.asignatura-docente.asignatura-docentes', [
            'asignaturasDocentes' => $asignaturasDocentes,
        ])->layout('layouts.app');
    }
}
