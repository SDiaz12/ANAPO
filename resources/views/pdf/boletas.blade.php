<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Boleta de Notas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            margin: 40px;
        }

        .boleta {
            page-break-after: always;
        }

        h3 {
            text-align: center;
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th, td {
            border: 1px solid black;
            padding: 6px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        .info-table {
            width: 100%;
            border: none;
        }

        .info-table td {
            border: none;
            vertical-align: top;
            padding: 4px;
        }

       
        .foto {
            width: 90px;
            height: 110px;
            object-fit: cover;
        }

     
        .firmas-table {
            width: 100%;
            margin-top: 50px;
            border: none;
        }

        .firmas-table td {
            border: none;
            text-align: center;
            padding-top: 30px;
        }

        .firma-linea {
            border-top: 1px solid #000;
            width: 100%;
            margin-top: 30px;
            text-align: center;
            padding-top: 5px;
        }
    </style>
</head>
<body>

@foreach ($datos as $registro)
    @if ($registro->notas)
    @php
        $nota = $registro->notas;
        $estudiante = $registro->estudiante;

        $seccion = $registro->asignaturadocente->seccion->nombre ?? '';
        $periodo = $registro->asignaturadocente->periodo->nombre ?? '';
        $promedio = round(($nota->primerparcial + $nota->segundoparcial + $nota->tercerparcial) / 3, 2);
        $totalAsistencias = $nota->asistencia1 + $nota->asistencia2 + $nota->asistencia3;
    @endphp

    <div class="boleta">
        <h3>Boleta de Notas</h3>

       
        <table class="info-table">
            <tr>
                <td style="text-align: left; width: 70%;">
                    <strong>Periodo:</strong> {{ $periodo }}<br>
                    <strong>Sección:</strong> {{ $seccion }}
                </td>
                <td style="text-align: right; width: 30%;">
                    <img src="{{ public_path('storage/' . $estudiante->foto) }}" class="foto" alt="Foto">



                </td>
            </tr>
        </table>

        <!-- Tabla de notas -->
        <table>
            <thead>
                <tr>
                    <th>Parcial</th>
                    <th>{{ $registro->asignaturadocente->asignatura->nombre ?? 'Materia' }}</th>
                    <th>Asistencia</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>I Parcial</td>
                    <td>{{ $nota->primerparcial }}</td>
                    <td>{{ $nota->asistencia1 }}</td>
                </tr>
                <tr>
                    <td>II Parcial</td>
                    <td>{{ $nota->segundoparcial }}</td>
                    <td>{{ $nota->asistencia2 }}</td>
                </tr>
                <tr>
                    <td>III Parcial</td>
                    <td>{{ $nota->tercerparcial }}</td>
                    <td>{{ $nota->asistencia3 }}</td>
                </tr>
                <tr>
                    <th>Promedio</th>
                    <td>{{ $promedio }}</td>
                    <td>{{ $totalAsistencias }}</td>
                </tr>
            </tbody>
        </table>


        <!-- Datos del alumno -->
        <p><strong>Nombre del Alumno:</strong> {{ $estudiante->nombre }} {{ $estudiante->apellido }}</p>
        <p><strong>DNI:</strong> {{ $estudiante->dni }}</p>

        <!-- Firmas sin bordes, alineadas -->
        <table class="firmas-table">
            <tr>
                <td>
                    <div class="firma-linea">Firma del Docente</div>
                </td>
                <td>
                    <div class="firma-linea">Firma del Director</div>
                </td>
            </tr>
        </table>
    </div>
    @endif
@endforeach

</body>
</html>
