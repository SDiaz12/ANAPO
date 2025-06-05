<?php

namespace App\Livewire\Principal;

use App\Models\AsignaturaEstudiante;
use App\Models\Estudiante;
use App\Models\Matricula;
use App\Models\Nota;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Carbon\Carbon;

class InicioEstudiante extends Component
{
    public $estudiante;
    public $matricula;
    public $asignaturasActuales = [];
    public $asignaturasHistorial = [];
    public $promedioGlobal = 0;
    public $progresoPrograma = 0;
    public $asignaturasAprobadas = 0;
    public $asignaturasTotales = 0;
    public $ultimasNotas = [];
    public $eventosProximos = [];

    public function mount()
    {
        $this->estudiante = Estudiante::where('user_id', Auth::id())->first();
        
        if ($this->estudiante) {
            $this->matricula = Matricula::where('estudiante_id', $this->estudiante->id)
                ->where('estado', 1)
                ->with('programaFormacion')
                ->first();
            
            $this->cargarDatosAcademicos();
        }
    }

    protected function cargarDatosAcademicos()
    {
        if ($this->matricula) {
            $this->asignaturasActuales = AsignaturaEstudiante::where('estudiantes_id', $this->matricula->id)
                ->whereHas('periodo', fn($q) => $q->where('estado', true))
                ->with(['asignaturadocente.asignatura', 'asignaturadocente.docente', 'nota'])
                ->get()
                ->filter(fn($ae) => $ae->nota !== null)
                ->map(function ($ae) {
                    $ae->promedio_calculado = $this->calcularPromedioAsignatura($ae);
                    return $ae;
                });
            
            $this->asignaturasHistorial = AsignaturaEstudiante::where('estudiantes_id', $this->matricula->id)
                ->whereHas('periodo', fn($q) => $q->where('estado', false))
                ->with(['asignaturadocente.asignatura', 'asignaturadocente.docente', 'nota'])
                ->get()
                ->filter(fn($ae) => $ae->nota !== null)
                ->map(function ($ae) {
                    $ae->promedio_calculado = $this->calcularPromedioAsignatura($ae);
                    return $ae;
                });
            
            $this->calcularPromedioGlobal();
            $this->calcularProgresoPrograma();
            
            $this->ultimasNotas = collect($this->asignaturasActuales)
                ->sortByDesc(fn($ae) => $ae->nota->updated_at)
                ->take(3);
        }
    }

    protected function calcularPromedioAsignatura($asignaturaEstudiante)
    {
        $nota = $asignaturaEstudiante->nota;
        $mostrarTercerParcial = $asignaturaEstudiante->asignaturadocente->mostrarTercerParcial ?? false;

        if ($mostrarTercerParcial) {
            $promedio = ($nota->primerparcial + $nota->segundoparcial + $nota->tercerparcial) / 3;
        } else {
            $promedio = ($nota->primerparcial + $nota->segundoparcial) / 2;
        }

        if ($nota->recuperacion > 0) {
            if ($mostrarTercerParcial) {
                $parciales = [$nota->primerparcial, $nota->segundoparcial, $nota->tercerparcial];
                $minParcial = min($parciales);
                $sumaParciales = array_sum($parciales) - $minParcial;
                $promedio = ($sumaParciales + $nota->recuperacion) / 3;
            } else {
                $promedio = max($promedio, $nota->recuperacion);
            }
        }

        return round($promedio, 2);
    }

    protected function calcularPromedioGlobal()
    {
        $suma = 0;
        $contador = 0;

        foreach ($this->asignaturasHistorial as $asignatura) {
            if ($asignatura->promedio_calculado) {
                $suma += $asignatura->promedio_calculado;
                $contador++;
            }
        }

        $this->promedioGlobal = $contador > 0 ? round($suma / $contador, 2) : 0;
    }
    
    protected function calcularProgresoPrograma()
    {
        if ($this->matricula && $this->matricula->programaFormacion) {
            $this->asignaturasTotales = $this->matricula->programaFormacion->asignaturas()->count();
            
            $this->asignaturasAprobadas = collect($this->asignaturasHistorial)
                ->filter(fn($ae) => $ae->promedio_calculado && $ae->promedio_calculado >= 70)
                ->count();

            $this->progresoPrograma = $this->asignaturasTotales > 0 
                ? round(($this->asignaturasAprobadas / $this->asignaturasTotales) * 100, 2) 
                : 0;
        }
    }

    public function render()
    {
        return view('livewire.principal.inicioestudiante')->layout('layouts.app');
    }
}