<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Historial Académico</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        .student-info { margin-bottom: 30px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; font-weight: bold; }
        .signature { 
            margin-top: 50px; 
            text-align: center; 
            width: 100%;
        }
        .indices { margin: 15px 0; }
        .indices span { margin-right: 20px; }
        .aprobado { color: green; }
        .reprobado { color: red; }
        .en-curso { color: #666; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Historial Académico</h2>
        <h3>Academia Nacional de Policía</h3>
    </div>
    
    <div class="student-info">
        <p><strong>Estudiante:</strong> {{ $estudiante->nombre }} {{ $estudiante->apellido }}</p>
        <p><strong>Código:</strong> {{ $estudiante->codigo }}</p>
        <p><strong>Programa:</strong> {{ $matricula->programaFormacion->nombre }}</p>
        <p><strong>Fecha de Generación:</strong> {{ now()->format('d/m/Y') }}</p>
    </div>

    <div class="indices">
        <span><strong>Índice Global:</strong> {{ number_format($globalIndice, 2) }}</span>
    </div>
    @if($tieneRegistros)
        <table>
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Asignatura</th>
                    <th>UV</th>
                    <th>Sección</th>
                    <th>Periodo</th>
                    <th>Año</th>
                    <th>Nota Final</th>
                    <th>Observación</th>
                </tr>
            </thead>
            <tbody>
                @foreach($historial as $asignatura)
                @php
                    $nota = $asignatura->notas;
                    $mostrarTercerParcial = $asignatura->asignaturaDocente->mostrarTercerParcial ?? false;
                    $promedio = 0;
                    $claseObservacion = 'en-curso';
                    $observacion = 'En curso';
                    if ($nota) {
                        $p1 = (float)($nota->primerparcial ?? 0);
                        $p2 = (float)($nota->segundoparcial ?? 0);
                        $rec = (float)($nota->recuperacion ?? 0);

                        if ($mostrarTercerParcial) {
                            $p3 = (float)($nota->tercerparcial ?? 0);
                            $promedio = ($p1 + $p2 + $p3) / 3;
                            
                            if ($rec > 0) {
                                $minParcial = min($p1, $p2, $p3);
                                $promedio = ($p1 + $p2 + $p3 - $minParcial + $rec) / 3;
                            }
                        } else {
                            $promedio = ($p1 + $p2) / 2;
                            
                            if ($rec > 0) {
                                $promedio = max($promedio, $rec);
                            }
                        }

                        $promedio = round($promedio, 2);

                        if ($promedio >= 70) {
                            $observacion = 'Aprobado';
                            $claseObservacion = 'aprobado';
                        } elseif ($promedio > 0) {
                            $observacion = 'Reprobado';
                            $claseObservacion = 'reprobado';
                        }
                    }
                @endphp
                <tr>
                    <td>{{ $asignatura->asignaturaDocente->asignatura->codigo ?? 'N/A' }}</td>
                    <td>{{ $asignatura->asignaturaDocente->asignatura->nombre ?? 'N/A' }}</td>
                    <td>{{ $asignatura->asignaturaDocente->asignatura->creditos ?? 0 }}</td>
                    <td>{{ $asignatura->asignaturaDocente->seccion->nombre ?? 'N/A' }}</td>
                    <td>{{ $asignatura->asignaturaDocente->periodo->nombre ?? 'N/A' }}</td>
                    <td>
                        @if($asignatura->asignaturaDocente->periodo)
                            {{ \Carbon\Carbon::parse($asignatura->asignaturaDocente->periodo->fecha_inicio)->format('Y') }}
                        @else
                            N/A
                        @endif
                    </td>
                    <td>{{ $promedio > 0 ? $promedio : 'N/A' }}</td>
                    <td class="{{ $claseObservacion }}">{{ $observacion }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
    <div class="sin-registros">
            No se encontraron registros de asignaturas de periodos finalizados
        </div>
    @endif
    <div class="signature">
        <p>_________________________</p>
        <p>Firma y Sello</p>
        <p>Departamento Académico</p>
    </div>
</body>
</html>