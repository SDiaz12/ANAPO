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
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header img {
            height: 80px;
            margin-bottom: 10px;
        }

        .header h1 {
            margin: 5px 0;
            font-size: 18px;
        }

        .header p {
            margin: 5px 0;
            font-size: 14px;
        }

        .info-alumno {
            margin-top: 15px;
            margin-bottom: 10px;
        }

        .info-alumno p {
            margin: 5px 0;
        }

        .firmas {
            margin-top: 40px;
            width: 100%;
        }

        .firma {
            display: inline-block;
            width: 45%;
            text-align: center;
            margin-top: 50px;
        }

        .linea-firma {
            border-top: 1px solid #000;
            width: 80%;
            margin: 0 auto;
            padding-top: 5px;
        }
    </style>
</head>
<body>

@foreach ($datos as $registro)
    @if ($registro->notas)
    @php
        $nota = $registro->notas;
        $estudiante = $registro->matricula->estudiante;
        $seccion = $registro->asignaturadocente->seccion->nombre ?? '';
        $periodo = $registro->asignaturadocente->periodo->nombre ?? '';
        $promedio = $nota->promedio_calculado ?? 0;
    @endphp

    <div class="boleta">
        <div class="header">
            <img src="{{ public_path('Logo/LOGO.png') }}" alt="Logo">
            <h1>ACADEMIA NACIONAL DE POLICÍA</h1>
            <p>Boleta de Calificaciones</p>
            <p><strong>Asignatura:</strong> {{ $asignatura }}</p>
        </div>

        <div class="info-alumno">
            <p><strong>Periodo:</strong> {{ $periodo }}</p>
            <p><strong>Sección:</strong> {{ $seccion }}</p>
            <p><strong>Docente:</strong> {{ $docente }}</p>
            <p><strong>Nombre del Alumno:</strong> {{ $estudiante->nombre }} {{ $estudiante->apellido }}</p>
            <p><strong>DNI:</strong> {{ $estudiante->dni }}</p>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Evaluación</th>
                    <th>Nota</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>I Parcial</td>
                    <td>{{ $nota->primerparcial ?? 'N/A' }}</td>
                </tr>
                
                <tr>
                    <td>II Parcial</td>
                    <td>{{ $nota->segundoparcial ?? 'N/A' }}</td>
                </tr>
                
                @if($mostrarTercerParcial)
                <tr>
                    <td>III Parcial</td>
                    <td>{{ $nota->tercerparcial ?? 'N/A' }}</td>
                </tr>
                @endif
                
                @if($nota->tiene_recuperacion)
                <tr>
                    <td>Recuperación</td>
                    <td>{{ $nota->recuperacion }}</td>
                </tr>
                @endif
                
                <tr style="font-weight: bold;">
                    <td>Promedio Final</td>
                    <td>{{ number_format($promedio, 2) }} %</td>
                </tr>
            </tbody>
        </table>

        <div class="firmas">
            <div class="firma" style="float: left;">
                <div class="linea-firma">Firma del Docente</div>
            </div>
            <div class="firma" style="float: right;">
                <div class="linea-firma">Firma del Director</div>
            </div>
            <div style="clear: both;"></div>
        </div>
    </div>
    @endif
@endforeach

</body>
</html>