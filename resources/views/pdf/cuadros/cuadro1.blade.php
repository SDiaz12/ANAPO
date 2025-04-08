<!DOCTYPE html>
<html>
<head>
    <title>Cuadro 1 de Notas</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        /* Usar fuentes que soporten UTF-8 */
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
        }
        .header { 
            text-align: center; 
            margin-bottom: 20px;
        }
        .title { 
            font-size: 14px; 
            font-weight: bold;
        }
        .subtitle { 
            font-size: 12px; 
            margin-bottom: 5px;
        }
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 15px;
        }
        th, td { 
            border: 1px solid #000; 
            padding: 5px; 
            text-align: center;
        }
        th { 
            background-color: #f2f2f2; 
            font-weight: bold;
        }
        .text-left { 
            text-align: left;
        }
        .firma { 
            margin-top: 30px; 
            width: 250px; 
            border-top: 1px solid #000;
            text-align: center; 
            margin-left: auto; 
            margin-right: 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">UNIVERSIDAD [NOMBRE]</div>
        <div class="title">FACULTAD DE [NOMBRE]</div>
        <div class="title">CUADRO 1 - NOTAS PARCIALES</div>
        <div class="subtitle">Asignatura: {{ htmlspecialchars($asignatura->nombre) }} ({{ $asignatura->codigo }})</div>
        <div class="subtitle">Docente: {{ htmlspecialchars($docente->nombre) }}</div>
        <div class="subtitle">Periodo: {{ now()->format('Y') }}</div>
        <div class="subtitle">Fecha: {{ $fecha }}</div>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>N°</th>
                <th>Código</th>
                <th class="text-left">Estudiante</th>
                <th>1er Parcial</th>
                <th>2do Parcial</th>
                <th>3er Parcial</th>
                <th>Recuperación</th>
                <th>Promedio</th>
                <th>Asistencia</th>
                <th>Observaciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($notas as $index => $nota)
            @php
                $estudiante = $nota->asignaturaEstudiante->estudiante;
                // Sanitizar los datos antes de mostrarlos
                $apellido = htmlspecialchars($estudiante->apellido);
                $nombre = htmlspecialchars($estudiante->nombre);
                $observacion = htmlspecialchars($nota->observacion ?? '-');
            @endphp
            <tr>
                <td>{{ $index+1 }}</td>
                <td>{{ $estudiante->codigo }}</td>
                <td class="text-left">{{ $apellido }}, {{ $nombre }}</td>
                <td>{{ $nota->primerparcial ?? '-' }}</td>
                <td>{{ $nota->segundoparcial ?? '-' }}</td>
                <td>{{ $nota->tercerparcial ?? '-' }}</td>
                <td>{{ $nota->recuperacion ?? '-' }}</td>
                <td>{{ $nota->promedio ?? '-' }}</td>
                <td>{{ $nota->asistencia ?? '-' }}%</td>
                <td>{{ $observacion }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    @if($incluirFirmas)
    <div class="firma">
        <p>Firma del Docente</p>
        <p>{{ htmlspecialchars($docente->nombre) }}</p>
        <p>C.I. {{ $docente->cedula }}</p>
    </div>
    @endif
</body>
</html>