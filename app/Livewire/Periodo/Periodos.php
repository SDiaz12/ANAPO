<?php

namespace App\Livewire\Periodo;

use App\Models\Periodo;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class Periodos extends Component
{
    use WithPagination;

    public $confirmingDelete = false;
    public $IdAEliminar, $nombreAEliminar;
    public $search, $periodo_id, $nombre, $fecha_inicio, $fecha_fin, $estado = 0; 
    public $isOpen = false;
    public $viewMode = 'table';  
    public $perPage = 9;

    public function placeholder()
    {
        return view('livewire.Placeholder.loader')->layout('layouts.app');
    }

    public function mount()
    {
        $this->verificarEstadoPeriodos();
    }

    protected function verificarEstadoPeriodos()
    {
        $now = Carbon::now();
        
       
        Periodo::query()->update(['estado' => 0]);
        
        $periodoAActivar = Periodo::where('fecha_inicio', '<=', $now->copy()->addWeeks(2))
            ->where('fecha_fin', '>=', $now->copy()->subWeeks(2))
            ->orderBy('fecha_inicio')
            ->first();
            
        if ($periodoAActivar) {
            $periodoAActivar->update(['estado' => 1]);
        }
    }

    public function create()
    {
        $this->resetInputFields();
        $this->openModal();
    }

    public function openModal()
    {
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
        $this->resetInputFields();
    }

    public function resetInputFields()
    {
        $this->periodo_id = null;
        $this->nombre = '';
        $this->fecha_inicio = '';
        $this->fecha_fin = '';
        $this->estado = 0;
    }

    public function store()
    {
        $this->validate([
            'nombre' => 'required|string|max:255',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
        ]);

        $this->estado = 0;

        try {
            $periodo = Periodo::updateOrCreate(
                ['id' => $this->periodo_id],
                [
                    'nombre' => $this->nombre,
                    'fecha_inicio' => $this->fecha_inicio,
                    'fecha_fin' => $this->fecha_fin,
                    'estado' => $this->estado,
                ]
            );

            $this->verificarEstadoPeriodos();

            session()->flash(
                'message',
                $this->periodo_id ? '¡Período actualizado correctamente!' : '¡Período creado correctamente!'
            );

            $this->closeModal();
            $this->resetPage(); 
        } catch (\Exception $e) {
            session()->flash('error', 'Error al guardar: ' . $e->getMessage());
        }
    }
   
    public function edit($id)
    {
        $periodo = Periodo::findOrFail($id);
        $this->periodo_id = $id;
        $this->nombre = $periodo->nombre;
        $this->fecha_inicio = $periodo->fecha_inicio;
        $this->fecha_fin = $periodo->fecha_fin;
        $this->estado = $periodo->estado;
        $this->openModal();
    }
    
    public function delete()
    {
        if ($this->confirmingDelete) {
            $periodo = Periodo::find($this->IdAEliminar);

            if (!$periodo) {
                session()->flash('error', 'Período no encontrado.');
                $this->confirmingDelete = false;
                return;
            }

            $periodo->delete();

            $this->verificarEstadoPeriodos();
            
            session()->flash('message', 'Período eliminado correctamente!');
            $this->confirmingDelete = false;
        }
    }

   public function toggleEstado($id)
    {
        $periodo = Periodo::findOrFail($id); 
        if (!$periodo->estado) {
            Periodo::where('id', '!=', $id)->update(['estado' => 0]);
        }
        
        $periodo->estado = !$periodo->estado;
        $periodo->save();
    }

    public function loadMore($suma)
    {
        $this->perPage = $suma;
    }

    public function confirmDelete($id)
    {
        $periodo = Periodo::find($id);
    
        if (!$periodo) {
            session()->flash('error', 'Período no encontrado.');
            return;
        }
    
        $this->IdAEliminar = $id;
        $this->nombreAEliminar = $periodo->nombre;
        $this->confirmingDelete = true;
    }

    public function render()
    {
        $this->verificarEstadoPeriodos();
        $periodosCount = Periodo::count();
        $periodos = Periodo::where('nombre', 'like', '%' . $this->search . '%')
            ->orderBy('fecha_inicio', 'DESC')
            ->paginate($this->perPage);
            
        return view('livewire.periodo.periodos', [
            'periodosCount' => $periodosCount,
            'periodos' => $periodos
        ])->layout('layouts.app');
    }
}