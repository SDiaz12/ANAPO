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
        $estudiante = $registro->matricula->estudiante;

        $seccion = $registro->asignaturadocente->seccion->nombre ?? '';
        $periodo = $registro->asignaturadocente->periodo->nombre ?? '';
        $promedio = round(($nota->primerparcial + $nota->segundoparcial + $nota->tercerparcial) / 3, 2);
        $totalAsistencias = $nota->asistencia;
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
        <table class="w-full border border-gray-200 dark:border-gray-700">
            <thead>
                <tr>
                    <th class="px-4 py-2 border">Parcial</th>
                    <th class="px-4 py-2 border">{{ $registro->asignaturadocente->asignatura->nombre ?? 'Materia' }}</th>
                    <th class="px-4 py-2 border">Asistencia</th>
                </tr>
            </thead>
            <tbody>
              
                <tr>
                    <td class="px-4 py-2 border">I Parcial</td>
                    <td class="px-4 py-2 border">{{ $nota->primerparcial ?? 'N/A' }}</td>
                    <td class="px-4 py-2 border" rowspan="4">
                        {{ $nota->asistencia ?? 'N/A' }} %
                        @if($nota && $nota->asistencia)
                            <div class="w-full bg-gray-200 rounded-full h-2.5 mt-1 dark:bg-gray-700">
                                <div class="bg-blue-600 h-2.5 rounded-full" 
                                    style="width: {{ $nota->asistencia }}%"></div>
                            </div>
                        @endif
                    </td>
                </tr>
                
             
                <tr>
                    <td class="px-4 py-2 border">II Parcial</td>
                    <td class="px-4 py-2 border">{{ $nota->segundoparcial ?? 'N/A' }}</td>
                </tr>
                

                <tr>
                    <td class="px-4 py-2 border">III Parcial</td>
                    <td class="px-4 py-2 border">{{ $nota->tercerparcial ?? 'N/A' }}</td>
                </tr>
                
             
                <tr>
                    <td class="px-4 py-2 border">Promedio</td>
                    <td class="px-4 py-2 border">{{ $promedio ?? 'N/A' }}</td>
                </tr>
                
            </tbody>
        </table>

        <p><strong>Nombre del Alumno:</strong> {{ $estudiante->nombre }} {{ $estudiante->apellido }}</p>
        <p><strong>DNI:</strong> {{ $estudiante->dni }}</p>

     
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
