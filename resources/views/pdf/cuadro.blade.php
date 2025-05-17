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
<div class="encabezado" style="text-align: center; margin-bottom: 15px;">
        <img src="{{ public_path('Logo/LOGO.png') }}" alt="Logo" style="height: 70px; display: block; margin: 0 auto 5px auto;">
        <h2 style="margin: 0; font-size: 22px; letter-spacing: 1px;">ACADEMIA NACIONAL DE POLICÍA</h2>
        <span style="font-size: 13px;">Cuadro de Notas Consolidado</span>
    </div>

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
                <th>I Parcial</th>
                <th>II Parcial</th>
                <th>III Parcial</th>
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
                    <td>{{ $registro->matricula->estudiante->nombre }} {{ $registro->matricula->estudiante->apellido }}</td>
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
