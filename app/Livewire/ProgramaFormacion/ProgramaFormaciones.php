<?php

namespace App\Livewire\ProgramaFormacion;

use App\Models\ProgramaFormacion;
use Livewire\Component;

class ProgramaFormaciones extends Component
{
    public $search, $programaformacion_id, $codigo, $nombre, $fecha_aprobación, $fecha_final, $hora_finalizacion, $instituto, $tipo_programa, $procentaje_aprobacion, $estado;

    public $confirmingDelete = false;
    public $IdAEliminar, $nombreAEliminar;
    public $isOpen = false;
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
    }

    public function resetInputFields()
    {
        $this->programaformacion_id = '';
        $this->codigo = '';
        $this->nombre = '';
        $this->fecha_aprobación = '';
        $this->fecha_final = '';
        $this->hora_finalizacion = '';
        $this->instituto = '';
        $this->tipo_programa = '';
        $this->procentaje_aprobacion = '';
        $this->estado = '';
    }

    public function toggleEstado($id)
    {
        $programa = ProgramaFormacion::findOrFail($id);
        $programa->estado = !$programa->estado;
        $programa->save();
    }

    public function store()
    {
        $this->validate([
            'codigo' => 'required',
            'nombre' => 'required',
            'fecha_aprobación' => 'required',
            'fecha_final' => 'required',
            'hora_finalizacion' => 'required',
            'instituto' => 'required',
            'tipo_programa' => 'required',
            'procentaje_aprobacion' => 'required'
        ]);

        ProgramaFormacion::updateOrCreate(['id' => $this->programaformacion_id], [
            'codigo' => $this->codigo,
            'nombre' => $this->nombre,
            'fecha_aprobacion' => $this->fecha_aprobación,
            'fecha_final' => $this->fecha_final,
            'hora_finalizacion' => $this->hora_finalizacion,
            'instituto' => $this->instituto,
            'tipo_programa' => $this->tipo_programa,
            'procentaje_aprobacion' => $this->procentaje_aprobacion,
            'estado' => 1,
        ]);
        session()->flash(
            'message',
            $this->programaformacion_id ? 'Programa de Formación actualizado correctamente!' : 'Programa de Formación creado correctamente!'
        );

        $this->closeModal();
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $programa = ProgramaFormacion::findOrFail($id);
        $this->programaformacion_id = $programa->id;
        $this->codigo = $programa->codigo;
        $this->nombre = $programa->nombre;
        $this->fecha_aprobación = $programa->fecha_aprobacion;
        $this->fecha_final = $programa->fecha_final;
        $this->hora_finalizacion = $programa->hora_finalizacion;
        $this->instituto = $programa->instituto;
        $this->tipo_programa = $programa->tipo_programa;
        $this->procentaje_aprobacion = $programa->procentaje_aprobacion;
        $this->estado = $programa->estado;
        $this->openModal();
    }

    public function delete()
    {
        if ($this->confirmingDelete) {
            $programa = ProgramaFormacion::find($this->IdAEliminar);

            if (!$programa) {
                session()->flash('error', 'Programa de formación no encontrado.');
                $this->confirmingDelete = false;
                return;
            }

            $programa->forceDelete();
            session()->flash('message', 'Programa de formación eliminado correctamente!');
            $this->confirmingDelete = false;
        }
    }

    public function confirmDelete($id)
    {
        $programa = ProgramaFormacion::find($id);

        if (!$programa) {
            session()->flash('error', 'Programa de formación no encontrado.');
            return;
        }
        if ($programa->asignaturas()->exists()) {
            session()->flash('error', 'No se puede eliminar Programa de formación:  ' . $programa->nombre . ', porque está enlazado a una o más estudiantes actualmente.');
            return;
        }

        $this->IdAEliminar = $id;
        $this->nombreAEliminar = $programa->nombre;
        $this->confirmingDelete = true;
    }
    public function placeholder()
    {
        return view('livewire.Placeholder.loader')->layout('layouts.app');
    }
    public $perPage = 10;
    public function loadMore($suma)
    {
        $this->perPage = $suma;
    }
    public function render()
    {
        $programas = ProgramaFormacion::where('nombre', 'like', '%' . $this->search . '%')
            ->orWhere('tipo_programa', 'like', '%' . $this->search . '%')
            ->orWhere('codigo', 'like', '%' . $this->search . '%')
            ->orderBy('id', 'DESC')
            ->paginate($this->perPage);

        $programasCount = ProgramaFormacion::count();
        return view('livewire.programa-formacion.programa-formaciones', [
            'programas' => $programas,
            'programasCount' => $programasCount,
        ])->layout('layouts.app');
    }
}
