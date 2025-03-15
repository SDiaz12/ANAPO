<?php

namespace App\Livewire\Matricula;

use App\Models\Estudiante;
use App\Models\Matricula;
use App\Models\ProgramaFormacion;
use Carbon\Carbon;
use Livewire\Component;

class Matriculas extends Component
{
    public $search, $matricula_id, $fecha_matricula, $programaformacion_id, $estado, $motivo_estado, $observacion_estado, $estudiante_id, $instituto;
    public $dniBusqueda; 
    public $codigoEstudiante;         
    public $nombreCompleto;
    public $error;
    public $errorUnique;
    public $inputSearchProgramaFormacion = '';  
    public $searchProgramasFormacion = []; 
    public $isOpen = 0;

    // Este método se ejecuta automáticamente cuando $dniBusqueda cambia
    public function updatedDniBusqueda($value)
    {
        // Limpia los campos y el mensaje de error cada vez que el DNI cambia
        $this->codigoEstudiante = '';
        $this->nombreCompleto = '';
        $this->estudiante_id = '';
        $this->error = '';

        // Solo busca si el DNI tiene la longitud esperada (por ejemplo, 8 caracteres)
        if (strlen($this->dniBusqueda) === strlen($this->dniBusqueda)) { // Ajusta la longitud si es necesario
            $this->buscarEstudiantePorDNI();
        }
    }

    public function buscarEstudiantePorDNI()
    {
        // Busca al estudiante por su DNI exacto
        $estudiante = Estudiante::where('dni', $this->dniBusqueda)->first();
        
        if ($estudiante) {
            // Si se encuentra, actualiza los campos
            $this->codigoEstudiante = $estudiante->codigo;
            $this->nombreCompleto = $estudiante->nombre . ' ' . $estudiante->apellido;
            $this->estudiante_id = $estudiante->id;
        } else {
            // Si no se encuentra, muestra un mensaje de error
            $this->error = 'No se encontró ningún estudiante con ese DNI.';
        }
    }
    

    public function toggleEstado($id)
    {
        $matricula = Matricula::findOrFail($id);
        $matricula->estado = !$matricula->estado;
        $matricula->save();
    }
    

    public function updatedInputSearchProgramaFormacion()
    {
        
        $this->searchProgramasFormacion = ProgramaFormacion::where('nombre', 'like', '%' . $this->inputSearchProgramaFormacion . '%')
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
            'instituto' => 'required',
        ]);

        // Si no se está actualizando (es creación) verificamos duplicado
        if (!$this->matricula_id) {
            $matriculaExistente = Matricula::where('estudiante_id', $this->estudiante_id)
                ->where('programaformacion_id', $this->programaformacion_id)
                ->first();
            if ($matriculaExistente) {
                $this->errorUnique = 'El estudiante ya está matriculado en ese programa.';
                return;
            }
        }

        $this->fecha_matricula = Carbon::today();
        Matricula::updateOrCreate(
            ['id' => $this->matricula_id],
            [
                'fecha_matricula' => $this->fecha_matricula,
                'programaformacion_id' => $this->programaformacion_id,
                'estado' => 1,
                'motivo_estado' => $this->motivo_estado,
                'observacion_estado' => $this->observacion_estado,
                'estudiante_id' => $this->estudiante_id,
                'instituto' => $this->instituto,
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
        $this->instituto = '';
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
        $this->instituto = $matricula->instituto;
        $this->dniBusqueda = $matricula->estudiante->dni;
        $this->openModal();
    }

    // Método para cargar más asignaturas
    public $perPage = 10;
    public function loadMore($suma)
    {
        $this->perPage = $suma;
    }
    public function render()
    {
        $matriculasCount = Matricula::count();
        $matriculas = Matricula::with(['programaFormacion', 'estudiante'])
    ->where(function ($query) {
        $query->whereHas('estudiante', function ($q) {
            $q->where('nombre', 'like', '%' . $this->search . '%')
              ->orWhere('apellido', 'like', '%' . $this->search . '%')
              ->orWhere('codigo', 'like', '%' . $this->search . '%');// Búsqueda por código del estudiante
        })
        ->orWhereHas('programaFormacion', function ($q) {
            $q->where('nombre', 'like', '%' . $this->search . '%');
        })
        ->orWhere('instituto', 'like', '%' . $this->search . '%'); // Búsqueda por instituto
    })
    ->orderBy('id', 'DESC')
    ->paginate($this->perPage);

        return view('livewire.matricula.matriculas', [
            'matriculas' => $matriculas,
            'matriculasCount' => $matriculasCount,
        ])->layout('layouts.app');
    }
}
