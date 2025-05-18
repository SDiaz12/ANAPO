<?php

namespace App\Livewire\Matricula;

use App\Models\Instituto;
use App\Models\Estudiante;
use App\Models\Matricula;
use App\Models\ProgramaFormacion;
use Carbon\Carbon;
use Livewire\Attributes\Lazy;
use Livewire\Component;
//#[Lazy()]
class Matriculas extends Component
{
    public $search, $matricula_id, $dni, $fecha_matricula, $programaformacion_id, $estado = 1, $motivo_estado, $observacion_estado, $estudiante_id, $instituto_id;
    public $dniBusqueda; 
    public $codigoEstudiante;         
    public $nombreCompleto;
    public $error;
    public $errorUnique;
    public $inputSearchProgramaFormacion = '';  
    public $searchProgramasFormacion = []; 
    public $isOpen = 0;
    public $showBajaModal = false;
    public $matriculaBajaId;
    public $motivoBaja;
    public $observacionBaja;
    public $nuevoEstado; 
    public function placeholder()
    {
        return view('livewire.Placeholder.loader')->layout('layouts.app');
    }


    public function updatedDniBusqueda($value)
    {
       
        $this->codigoEstudiante = '';
        $this->nombreCompleto = '';
        $this->estudiante_id = '';
        $this->error = '';

       
        if (strlen($this->dniBusqueda) === strlen($this->dniBusqueda)) { 
            $this->buscarEstudiantePorDNI();
        }
    }

    public function buscarEstudiantePorDNI()
    {
        $estudiante = Estudiante::where('dni', $this->dniBusqueda)
            ->where('estado', 1) 
            ->first();
        if ($estudiante) {
            
            $this->codigoEstudiante = $estudiante->codigo;
            $this->nombreCompleto = $estudiante->nombre . ' ' . $estudiante->apellido;
            $this->estudiante_id = $estudiante->id;
        } else {
            
            $this->error = 'No se encontró ningún estudiante con ese DNI.';
        }
    }
    
    public $matriculaParaBaja; 
    public function toggleEstado($id)
    {
        $this->matricula_id = $id;
        $matricula = Matricula::findOrFail($id);
        
        if($matricula->estado == 1) {
            $this->motivo_estado = $matricula->motivo_estado ?? '';
            $this->observacion_estado = $matricula->observacion_estado ?? '';
            $this->showBajaModal = true;
        } else {
            $matricula->update([
                'estado' => 1,
                'motivo_estado' => null,
                'observacion_estado' => null
            ]);
            session()->flash('success', 'Matrícula reactivada correctamente!');
        }
    }

    public function confirmarBaja()
    {
        $this->validate([
            'motivo_estado' => 'required|string|max:255',
            'observacion_estado' => 'nullable|string|max:500',
        ]);

        Matricula::find($this->matricula_id)->update([
            'estado' => 0,
            'motivo_estado' => $this->motivo_estado,
            'observacion_estado' => $this->observacion_estado,
        ]);

        $this->resetBajaModal();
        session()->flash('success', 'Matrícula dada de baja correctamente!');
    }

    public function cancelarBaja()
    {
        $this->resetBajaModal();
    }

    protected function resetBajaModal()
    {
        $this->showBajaModal = false;
        $this->matricula_id = null;
        $this->motivo_estado = '';
        $this->observacion_estado = '';
    }
    public function updatedInputSearchProgramaFormacion()
    {
        $this->searchProgramasFormacion = ProgramaFormacion::where('nombre', 'like', '%' . $this->inputSearchProgramaFormacion . '%')
            ->where('estado', 1)    
            ->limit(10)
            ->get();
    }

    public function selectProgramaFormacion($id)
    {
        $this->programaformacion_id = $id;
        $this->inputSearchProgramaFormacion = ProgramaFormacion::find($id)->nombre;
        $this->searchProgramasFormacion = [];
    }
    
    public function openModal()
    {
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
    }

    public function create()
    {
        $this->resetInputFields();
        $this->openModal();
    }

    public function store()
    {
        $this->validate([
            'programaformacion_id' => 'required|integer|exists:programaformaciones,id',
            'motivo_estado' => 'nullable|string',
            'observacion_estado' => 'nullable|string',
            'estudiante_id' => 'required|integer|exists:estudiantes,id',
            'instituto_id'         => 'required|integer|exists:instituto,id',
        ]);

        $query = Matricula::where('estudiante_id', $this->estudiante_id)
                    ->where('programaformacion_id', $this->programaformacion_id);
        if ($this->matricula_id) {
            $query->where('id', '!=', $this->matricula_id);
        }
        $matriculaExistente = $query->first();
        if ($matriculaExistente) {
            $this->errorUnique = 'El estudiante ya está matriculado en ese programa.';
            return;
        }

        $this->fecha_matricula = Carbon::today();
        Matricula::updateOrCreate(
            ['id' => $this->matricula_id],
            [
                'fecha_matricula' => $this->fecha_matricula,
                'programaformacion_id' => $this->programaformacion_id,
                'estado'             => $this->estado,
                'motivo_estado'      => $this->motivo_estado,
                'observacion_estado' => $this->observacion_estado,
                'estudiante_id'      => $this->estudiante_id,
                'instituto_id'      => $this->instituto_id,
            ]
        );

        session()->flash(
            'message',
            $this->matricula_id ? 'Matricula actualizada correctamente!' : 'Estudiante matriculado correctamente!'
        );
        $this->resetInputFields();
        $this->closeModal();
    }

    public function resetInputFields()
    {
        $this->programaformacion_id = '';
        $this->dni= '';
        $this->codigoEstudiante = '';
        $this->nombreCompleto = '';
        $this->error = '';
        $this->dniBusqueda = '';
        $this->inputSearchProgramaFormacion = '';
        $this->motivo_estado = '';
        $this->observacion_estado = '';
        $this->estudiante_id = '';
        $this->instituto_id = '';
    }

    public function edit($id)
    {
        $matricula = Matricula::with('programaFormacion', 'estudiante')->findOrFail($id); 
        $this->matricula_id = $id;
        $this->programaformacion_id = $matricula->programaformacion_id;
        $this->inputSearchProgramaFormacion = $matricula->programaFormacion->nombre;
        $this->codigoEstudiante = $matricula->estudiante->codigo;
        $this->nombreCompleto = $matricula->estudiante->nombre . ' ' . $matricula->estudiante->apellido;
        $this->estudiante_id = $matricula->estudiante->id;
        $this->instituto_id = $matricula->instituto_id;
        $this->dniBusqueda = $matricula->estudiante->dni;
        $this->openModal();
    }
    public $perPage = 10;
    public function loadMore($suma)
    {
        $this->perPage = $suma;
    }
    public function render()
    {

        $institutos = Instituto::where('estado', 1)->get();
        


        $matriculasCount = Matricula::count();
        $matriculas = Matricula::with(['programaFormacion', 'estudiante'])
    ->where(function ($query) {
        $query->whereHas('estudiante', function ($q) {
            $q->where('nombre', 'like', '%' . $this->search . '%')
              ->orWhere('apellido', 'like', '%' . $this->search . '%')
              ->orWhere('codigo', 'like', '%' . $this->search . '%');
        })
        ->orWhereHas('programaFormacion', function ($q) {
            $q->where('nombre', 'like', '%' . $this->search . '%');
        });
    })
    ->orderBy('id', 'DESC')
    ->paginate($this->perPage);

        return view('livewire.matricula.matriculas', [
            'matriculas' => $matriculas,
            'institutos' => $institutos,
            'matriculasCount' => $matriculasCount,
        ])->layout('layouts.app');
    }
}
