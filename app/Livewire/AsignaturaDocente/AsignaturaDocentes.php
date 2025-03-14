<?php

namespace App\Livewire\AsignaturaDocente;

use App\Models\AsignaturaDocente;
use App\Models\Docente;
use App\Models\Asignatura;
use App\Models\Periodo;
use App\Models\Seccion;
use Livewire\Component;
use Livewire\WithPagination;

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
    
    // Toggle entre vista de tabla y tarjetas
    public function toggleViewMode()
    {
        $this->viewMode = $this->viewMode === 'table' ? 'cards' : 'table';
    }

    // Abrir modal para crear
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
            ->limit(10)
            ->get();
    }

    public function selectdocente($id)
    {
        $this->docente_id = $id;
        $this->inputSearchdocente = Docente::find($id)->nombre;
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
        $this->docente_id = null;
        $this->asignatura_id = null;
        $this->periodo_id = null;
        $this->seccion_id = null;
        $this->estado = 1;
    }

    // Eliminar AsignaturaDocente
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

    // Almacenar o actualizar AsignaturaDocente
    public function store()
{
    // Asegúrate de que el array no esté vacío antes de usarlo
    if (empty($this->selectedSecciones)) {
        session()->flash('error', 'Por favor, selecciona al menos una sección.');
        return;
    }

    // Validación de los campos
    $this->validate([
        'docente_id' => 'required|integer|exists:docentes,id',
        'selectedAsignaturas' => 'required|array|min:1',
        'selectedAsignaturas.*' => 'integer|exists:asignaturas,id',
        'selectedSecciones' => 'required|array|min:1',
        'selectedSecciones.*' => 'integer|exists:secciones,id',
        'selectedPeriodos' => 'required|array|min:1',
        'selectedPeriodos.*' => 'integer|exists:periodos,id',
    ]);

    // Asegúrate de que los índices coincidan entre los arrays
    if (count($this->selectedAsignaturas) !== count($this->selectedSecciones) || count($this->selectedAsignaturas) !== count($this->selectedPeriodos)) {
        session()->flash('error', 'La cantidad de asignaturas, secciones y períodos debe coincidir.');
        return;
    }

    // Guardar los registros
    foreach ($this->selectedAsignaturas as $key => $asignaturaId) {
        AsignaturaDocente::updateOrCreate(
            [
                'docente_id' => $this->docente_id,
                'asignatura_id' => $asignaturaId,
            ],
            [
                'periodo_id' => $this->selectedPeriodos[$key], 
                'seccion_id' => $this->selectedSecciones[$key],
                'estado' => 1,
            ]
        );
    }
    if (!empty($this->selectedSecciones) && isset($this->selectedSecciones[0])) {
        // Acceder al índice 0
        $firstSeccion = $this->selectedSecciones[0];
    } else {
        // Manejar el caso en que el array está vacío o no tiene índice 0
        session()->flash('error', 'Por favor, selecciona al menos una sección.');
        return;
    }
    

    session()->flash('message', 'Asignaturas asignadas correctamente!');
    $this->resetInputFields();
}

    



    // Editar AsignaturaDocente
    public function edit($id)
    {
        $asignaturaDocente = AsignaturaDocente::findOrFail($id);
        $this->docente_id = $asignaturaDocente->docente_id;
        $this->asignatura_id = $asignaturaDocente->asignatura_id;
        $this->periodo_id = $asignaturaDocente->periodo_id;
        $this->seccion_id = $asignaturaDocente->seccion_id;
        $this->estado = $asignaturaDocente->estado;

        $this->openModal();
    }

    // Confirmar eliminación
    public function confirmDelete($id)
    {
        $asignaturaDocente = AsignaturaDocente::find($id);

        if (!$asignaturaDocente) {
            session()->flash('error', 'AsignaturaDocente no encontrada.');
            return;
        }

        $this->IdAEliminar = $id;
        $this->docenteAEliminar = $asignaturaDocente->docente->nombre;
        $this->confirmingDelete = true;
    }

    // Cargar más AsignaturasDocentes
    public $perPage = 10;
    public function loadMore($suma)
    {
        $this->perPage = $suma;
    }

    public function render()
    {
        $asignaturasDocentes = AsignaturaDocente::with('docente', 'asignatura', 'periodo', 'seccion')
            ->where('docente_id', 'like', '%' . $this->search . '%')
            ->orWhere('asignatura_id', 'like', '%' . $this->search . '%')
            ->orderBy('id', 'DESC')
            ->paginate($this->perPage);

            $this->docentes = Docente::all();
            $this->asignaturas = Asignatura::all();
            $this->periodos = Periodo::all();
            $this->secciones = Seccion::all();

        return view('livewire.asignatura-docente.asignatura-docentes', [
            'asignaturasDocentes' => $asignaturasDocentes,
        ])->layout('layouts.app');
    }
}
