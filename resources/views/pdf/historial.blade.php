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
                $promedio = $nota ? round(($nota->primerparcial + $nota->segundoparcial + $nota->tercerparcial) / 3, 2) : 0;
                $observacion = $nota->observacion ?? ($promedio >= 70 ? 'Aprobado' : ($promedio > 0 ? 'Reprobado' : 'En curso'));
            @endphp
            <tr>
                <td>{{ $asignatura->asignaturaDocente->asignatura->codigo ?? '' }}</td>
                <td>{{ $asignatura->asignaturaDocente->asignatura->nombre ?? '' }}</td>
                <td>{{ $asignatura->asignaturaDocente->asignatura->creditos ?? 0 }}</td>
                <td>{{ $asignatura->asignaturaDocente->seccion->nombre ?? '' }}</td>
                <td>{{ $asignatura->asignaturaDocente->periodo->nombre ?? '' }}</td>
                <td>{{ $asignatura->asignaturaDocente->periodo ? \Carbon\Carbon::parse($asignatura->asignaturaDocente->periodo->fecha_inicio)->format('Y') : '' }}</td>
                <td>{{ $promedio > 0 ? $promedio : 'N/A' }}</td>
                <td>{{ $observacion }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

     <div class="signature">
        <p>_________________________</p>
        <p>Firma y Sello</p>
        <p>Departamento Académico</p>
    </div>
</body>
</html>