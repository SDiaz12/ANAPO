<?php

namespace App\Livewire\Principal;

use App\Models\Asignatura;
use App\Models\AsignaturaEstudiante;
use App\Models\Docente;
use App\Models\Estudiante;
use App\Models\Matricula;
use App\Models\ProgramaFormacion;
use App\Models\Promocion;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Livewire\Component;

class InicioAdmin extends Component
{
    public $search, $estudiante_id, $codigo, $dni, $foto, $nombre, $apellido, $fecha_nacimiento, $residencia, $fecha_ingreso, $sexo, $telefono, $correo, $estado = 1, $created_at;
    public $clasesEstudiante = [];
    public $clasesHistorial = [];
    public $data = [];
    public $isOpenDatos = false;
    public function openDatos()
    {
        $this->isOpenDatos = true;
    }

    public function closeDatos()
    {
        $this->isOpenDatos = false;
    }
    public function mount()
    {
        $this->data = [
            'femenino' => Estudiante::where('sexo', 'femenino')->count(),
            'masculino' => Estudiante::where('sexo', 'masculino')->count(),
        ];
    }
    public function mostrarDatos($idEstudiante)
    {
        $this->historialAsignaturasEstudiante($idEstudiante);
        $this->infoEstudiante($idEstudiante);
        $this->openDatos();
    }

    public function historialAsignaturasEstudiante($idEstudiante)
    {
        $this->clasesEstudiante = AsignaturaEstudiante::where('estudiantes_id', $idEstudiante)
            ->whereHas('periodo', function ($query) {
                $query->where('estado', true);
            })
            ->get();

        $this->clasesHistorial = AsignaturaEstudiante::where('estudiantes_id', $idEstudiante)
            ->whereHas('periodo', function ($query) {
                $query->where('estado', false);
            })
            ->get();
    }

    public function infoEstudiante($idEstudiante)
    {
        $estudiante = Estudiante::with('user')->findOrFail($idEstudiante);
        $this->estudiante_id = $idEstudiante;
        $this->codigo = $estudiante->codigo;
        $this->dni = $estudiante->dni;
        $this->foto = $estudiante->foto;
        $this->nombre = $estudiante->nombre;
        $this->apellido = $estudiante->apellido;
        $this->fecha_nacimiento = $estudiante->fecha_nacimiento;
        $this->residencia = $estudiante->residencia;
        $this->fecha_ingreso = $estudiante->fecha_ingreso;
        $this->sexo = $estudiante->sexo;
        $this->telefono = $estudiante->telefono;
        $this->correo = $estudiante->correo;
        $this->estado = $estudiante->estado;
        $this->created_at = $estudiante->created_at;

        if ($estudiante->user) {
            $this->user_email = $estudiante->user->email;
        } else {
            $this->user_email = '';
        }
    }
    protected function calcularIndices($matriculaId)
    {

        $asignaturas = AsignaturaEstudiante::with(['notas', 'asignaturaDocente.asignatura', 'periodo'])
            ->where('estudiantes_id', $matriculaId)
            ->orderBy('periodo_id', 'desc')
            ->get();

        $sumaGlobal = ['ponderada' => 0, 'creditos' => 0];


        foreach ($asignaturas as $asignatura) {
            if (!$asignatura->notas || !$asignatura->asignaturaDocente->asignatura)
                continue;

            $creditos = $asignatura->asignaturaDocente->asignatura->creditos;
            $notaFinal = ($asignatura->notas->primerparcial +
                $asignatura->notas->segundoparcial +
                $asignatura->notas->tercerparcial) / 3;
            $ponderacion = $notaFinal * $creditos;


            $sumaGlobal['ponderada'] += $ponderacion;
            $sumaGlobal['creditos'] += $creditos;



        }

        return [
            'global' => $sumaGlobal['creditos'] > 0 ?
                round($sumaGlobal['ponderada'] / $sumaGlobal['creditos'], 2) : 0,

        ];
    }
    public function estudiantesDestacados($limite = 10)
    {
        $estudiantes = Estudiante::whereHas('matricula', function ($q) {
            $q->where('estado', 1);
        })->get();

        $lista = [];

        foreach ($estudiantes as $estudiante) {
            $matricula = $estudiante->matricula()->where('estado', 1)->first();
            if (!$matricula)
                continue;

            $indice = $this->calcularIndices($matricula->id)['global'];
            $lista[] = [
                'estudiante' => $estudiante,
                'indice' => $indice,
            ];
        }

        // Ordenar de mayor a menor índice
        usort($lista, function ($a, $b) {
            return $b['indice'] <=> $a['indice'];
        });

        // Limitar la cantidad de resultados
        return array_slice($lista, 0, $limite);
    }

    public function DestacadosMayor84()
    {
        // Suponiendo que ya tienes el método para obtener los destacados
        $todos = $this->estudiantesDestacados(10); 

        // Filtrar solo los que tengan índice mayor a 85
        return collect($todos)->filter(function ($item) {
            return $item['indice'] > 84;
        })->values();
    }

    public function getEstudiantesPorPrograma()
    {
        return ProgramaFormacion::withCount('matriculaprograma')->get();
    }

    public function getUsuariosActivos()
    {
        $minutos = 5; // Considera activo si tuvo actividad en los últimos 5 minutos
        $limite = Carbon::now()->subMinutes($minutos)->timestamp;

        return DB::table('sessions')
            ->where('last_activity', '>=', $limite)
            ->distinct('user_id')
            ->whereNotNull('user_id')
            ->count('user_id');
    }


    public function render()
    {
        $programas = ProgramaFormacion::all();
        $labelsProgramas = [];
        $dataActivos = [];
        $dataBajas = [];
        $usuariosActivos = $this->getUsuariosActivos();

        foreach ($programas as $programa) {
            $labelsProgramas[] = $programa->nombre;
            $dataActivos[] = $programa->matriculaprograma()->where('estado', 1)->count();
            $dataBajas[] = $programa->matriculaprograma()->where('estado', 0)->count();
        }
        $destacados = $this->DestacadosMayor84();
        $estudiantesPorPrograma = $this->getEstudiantesPorPrograma();
        //contadores
        $docentesCount = Docente::count();
        $estudiantesCount = Estudiante::count();
        $asignaturasCount = Asignatura::count();
        $promocionesCount = Promocion::count();
        $programasCount = ProgramaFormacion::count();
        $matriculasCount = Matricula::where('estado', 1)->count();

        // Obtener las 10 últimas matrículas 
        $recentMatriculas = Matricula::with(['programaFormacion', 'estudiante'])
            ->where(function ($query) {
                $query->whereHas('estudiante', function ($q) {
                    $q->where('nombre', 'like', '%' . $this->search . '%')
                        ->orWhere('apellido', 'like', '%' . $this->search . '%')
                        ->orWhere('codigo', 'like', '%' . $this->search . '%');// Búsqueda por código del estudiante
                })
                    ->orWhereHas('programaFormacion', function ($q) {
                        $q->where('nombre', 'like', '%' . $this->search . '%');
                    });
            })
            ->orderBy('created_at', 'DESC')
            ->paginate(10);

        // Lista de departamentos de Honduras
        $departamentos = [
            'Atlántida',
            'Colón',
            'Comayagua',
            'Copán',
            'Cortés',
            'Choluteca',
            'El Paraíso',
            'Francisco Morazán',
            'Gracias a Dios',
            'Intibucá',
            'Islas de la Bahía',
            'La Paz',
            'Lempira',
            'Ocotepeque',
            'Olancho',
            'Santa Bárbara',
            'Valle',
            'Yoro'
        ];

        // Inicializar conteo
        $conteo = array_fill_keys($departamentos, 0);

        // Obtener todas las residencias
        $residencias = Estudiante::pluck('residencia');

        foreach ($residencias as $texto) {
            foreach ($departamentos as $dep) {
                // Buscar el nombre del departamento como palabra completa, sin importar mayúsculas/minúsculas
                if (preg_match('/\b' . preg_quote($dep, '/') . '\b/i', $texto)) {
                    $conteo[$dep]++;
                    break; // Solo contar una vez por estudiante
                }
            }
        }

        // Preparar para el gráfico
        $departamentosGrafico = array_keys($conteo);
        $cantidadPorDepartamento = array_values($conteo);

        return view('livewire.principal.inicioadmin', [
            'docentesCount' => $docentesCount,
            'estudiantesCount' => $estudiantesCount,
            'asignaturasCount' => $asignaturasCount,
            'promocionesCount' => $promocionesCount,
            'programasCount' => $programasCount,
            'matriculasCount' => $matriculasCount,
            'recentMatriculas' => $recentMatriculas,
            'destacados' => $destacados,
            'labelsProgramas' => $labelsProgramas,
            'dataActivos' => $dataActivos,
            'dataBajas' => $dataBajas,
            'usuariosActivos' => $usuariosActivos,
            'estudiantesPorPrograma' => $estudiantesPorPrograma,
            'departamentos' => $departamentosGrafico,
            'cantidadPorDepartamento' => $cantidadPorDepartamento,
            'data' => $this->data,
        ])->layout('layouts.app');
    }
}
