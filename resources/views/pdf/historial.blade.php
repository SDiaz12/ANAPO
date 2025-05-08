<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Historial Académico</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .header { text-align: center; margin-bottom: 20px; }
        .student-info { margin-bottom: 30px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .signature { margin-top: 50px; }
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
        <p><strong>Índice Global:</strong> {{ number_format($globalIndice, 2) }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Código</th>
                <th>Asignatura</th>
                <th>UV</th>
                <th>Periodo</th>
                <th>Año</th>
                <th>Nota Final</th>
            </tr>
        </thead>
        <tbody>
            @foreach($historial as $asignatura)
            @php
                $nota = $asignatura->notas;
                $promedio = $nota ? round(($nota->primerparcial + $nota->segundoparcial + $nota->tercerparcial) / 3, 2) : 0;
            @endphp
            <tr>
                <td>{{ $asignatura->asignatura->codigo }}</td>
                <td>{{ $asignatura->asignatura->nombre }}</td>
                <td>{{ $asignatura->asignatura->creditos }}</td>
                <td>{{ $asignatura->periodo->nombre ?? 'N/A' }}</td>
                <td>{{ $asignatura->periodo ? \Carbon\Carbon::parse($asignatura->periodo->fecha_inicio)->format('Y') : 'N/A' }}</td>
                <td>{{ $promedio }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="signature">
        <p>_________________________</p>
        <p>F/S Departamento Académico</p>
    </div>
   
</body>
</html>