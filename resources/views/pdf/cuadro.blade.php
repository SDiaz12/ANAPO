<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Cuadro de Notas Consolidado</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
        }
        th, td {
            border: 1px solid black;
            padding: 6px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

    <h2>Cuadro de Notas Consolidado</h2>

    @php
        $docente = $datos->first()?->asignaturadocente->docente->nombre ?? '';
        $asignatura = $datos->first()?->asignaturadocente->asignatura->nombre ?? '';
        $seccion = $datos->first()?->asignaturadocente->seccion->nombre ?? '';
        $periodo = $datos->first()?->asignaturadocente->periodo->nombre ?? '';
    @endphp

    <p><strong>Asignatura:</strong> {{ $asignatura }}</p>
    <p><strong>Docente:</strong> {{ $docente }}</p>
    <p><strong>Sección:</strong> {{ $seccion }}</p>
    <p><strong>Período:</strong> {{ $periodo }}</p>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Estudiante</th>
                <th>1er Parcial</th>
                <th>2do Parcial</th>
                <th>3er Parcial</th>
                <th>Asistencia</th>
                <th>Recuperación</th>
                <th>Promedio</th>
                <th>Observación</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($datos as $i => $registro)
                @php
                    $nota = $registro->notas;
                    $promedio = $nota
                        ? round(($nota->primerparcial + $nota->segundoparcial + $nota->tercerparcial) / 3, 2)
                        : null;
                @endphp
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $registro->estudiante->nombre }} {{ $registro->estudiante->apellido }}</td>
                    <td>{{ $nota->primerparcial ?? '-' }}</td>
                    <td>{{ $nota->segundoparcial ?? '-' }}</td>
                    <td>{{ $nota->tercerparcial ?? '-' }}</td>
                    <td>{{ $nota->asistencia ?? '-' }}</td>
                    <td>{{ $nota->recuperacion ?? '-' }}</td>
                    <td>{{ $promedio ?? '-' }}</td>
                    <td>{{ $nota->observacion ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
