<?php

namespace App\Exports;

use App\Models\Nota;
use App\Models\AsignaturaEstudiante;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class ActualizarNotasExport implements FromCollection, WithHeadings, WithStyles, WithEvents
{
    protected $codigo_asignatura;
    protected $codigo_docente;
    protected $seccion_id;

    public function __construct($codigo_asignatura, $codigo_docente, $seccion_id)
    {
        $this->codigo_asignatura = $codigo_asignatura;
        $this->codigo_docente = $codigo_docente;
        $this->seccion_id = $seccion_id;
    }

    public function headings(): array
    {
        return [
            'Nº',
            'Nº Cuenta',
            'Nombres y Apellidos',
            '1era. Prueba parcial 100%',
            '2da. Prueba parcial 100%',
            '3era. Prueba parcial 100%',
            'Nota promedio 100%',
            'Prueba de Recuperación 100%',
            'Nota promedio 100%',
            'Nota final',
            'Calificación'
        ];
    }

    public function collection()
    {
        return AsignaturaEstudiante::whereHas('asignaturadocente', function ($query) {
            $query->whereHas('asignatura', function ($query) {
                $query->where('codigo', $this->codigo_asignatura);
            })
                ->whereHas('docente', function ($query) {
                    $query->where('codigo', $this->codigo_docente);
                })
                ->whereHas('seccion', function ($query) {
                    $query->where('id', $this->seccion_id);
                });
        })
            ->with(['matricula.estudiante', 'asignaturadocente.asignatura', 'notas'])
            ->get()
            ->map(function ($item) {

                $nota = $item->notas;

                return [
                    'asignatura_estudiante_id' => $item->id ?? 'Sin código',
                    'codigo_estudiante' => $item->matricula->estudiante->codigo ?? 'Sin código',
                    'nombre_estudiante' => $item->matricula->estudiante->nombre . ' ' . $item->matricula->estudiante->apellido ?? 'Sin Nombre',
                    'primer_parcial' => $nota->primerparcial ?? 0,
                    'segundo_parcial' => $nota->segundoparcial ?? 0,
                    'tercer_parcial' => $nota->tercerparcial ?? 0,
                    'nota_promedio' => $nota->tercerparcial ?? 0,
                    'recuperacion' => $nota->recuperacion ?? 0,
                    'nota_promedio_recuperacion' => $nota->recuperacion ?? 0,
                    'nota_final' => $nota->recuperacion ?? 0,
                    'calificacion' => $nota->observacion ?? ' ',
                ];
            });
    }

    public function styles($sheet)
    {
        $sheet->getStyle('A1:L' . $sheet->getHighestRow())
            ->getFont()
            ->setName('Calibri')
            ->setSize(11);

        $sheet->getStyle('A1:L1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['argb' => 'FFFFFF'],
            ],
            'alignment' => [
                'horizontal' => 'center',
                'vertical' => 'center',
            ],
            'fill' => [
                'fillType' => 'solid',
                'startColor' => ['argb' => '4F81BD'],
            ],
        ]);

        $sheet->getStyle('A1:L' . $sheet->getHighestRow())
            ->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        // Aplica bordes dobles solo a los exteriores
        $sheet->getStyle('A1:L' . $sheet->getHighestRow())
            ->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
        $sheet->getStyle('A1:L' . $sheet->getHighestRow())
            ->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
        $sheet->getStyle('A1:L' . $sheet->getHighestRow())
            ->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);

        $sheet->getStyle('A1:L' . $sheet->getHighestRow())
            ->getAlignment()->setHorizontal('center');
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {

                $asignaturaEstudiante = AsignaturaEstudiante::whereHas('asignaturadocente', function ($query) {
                    $query->whereHas('asignatura', function ($query) {
                        $query->where('codigo', $this->codigo_asignatura);
                    })
                        ->whereHas('docente', function ($query) {
                            $query->where('codigo', $this->codigo_docente);
                        })
                        ->whereHas('seccion', function ($query) {
                            $query->where('id', $this->seccion_id);
                        });
                })->first();
                $sheet = $event->sheet->getDelegate();
                // Establecer el nombre de la hoja
                $sheet->setTitle('Calificaciones');
                // Configurar la orientación de la página y los márgenes
                $sheet->getPageSetup()
                    ->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE) // Orientación horizontal
                    ->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_LETTER) // Tamaño de papel carta (22x28 cm)
                    ->setFitToWidth(1) // Ajustar al ancho de una página
                    ->setFitToHeight(0); // Ajustar al alto automático
    
                $sheet->getPageMargins()
                    ->setTop(0.6) // Margen superior
                    ->setRight(0.4) // Margen derecho
                    ->setLeft(0.9) // Margen izquierdo
                    ->setBottom(0.4) // Margen inferior
                    ->setHeader(0.4) // Margen del encabezado
                    ->setFooter(0.4); // Margen del pie de página
    

                // Establecer el altura de las filas
                $sheet->getDefaultRowDimension()->setRowHeight(16);

                // Insertar filas para el encabezado de tabla (11 filas)
                $sheet->insertNewRowBefore(1, 12);

                // Escribir los encabezados manualmente en la fila 12
                $headings = $this->headings();
                $col = 'A';
                foreach ($headings as $heading) {
                    if ($col === 'D') {
                        // Salta la columna D porque ahora está combinada con C
                        $col = 'E';
                    }
                    $sheet->setCellValue($col . '12', $heading);
                    $sheet->getStyle($col . '12')->getFont()->setName('Cambria')->setBold(true)->setSize(8);
                    $sheet->getStyle($col . '12')->getAlignment()
                        ->setHorizontal('center') // Centrar horizontalmente
                        ->setVertical('center')   // Centrar verticalmente
                        ->setWrapText(true);      // Ajustar texto automáticamente
                    $col++;
                }

                // Determinar la fila inicial y final de los registros
                $startRow = 14; // los registros comienzan en la fila 14
                $endRow = $sheet->getHighestRow(); // Última fila con datos
                // Obtener los datos de la colección
                $datos = $this->collection()->toArray(); // Convierte la colección en un array
                // Escribir los registros directamente en las posiciones correctas
                $row = $startRow;
                foreach ($datos as $dato) {
                    $col = 'A';
                    foreach ([$dato['asignatura_estudiante_id'], // Nº
                        $dato['codigo_estudiante'],        // Código
                        $dato['nombre_estudiante'],        // Nombres y Apellidos
                        $dato['primer_parcial'],           // 1era. Prueba parcial 100%
                        $dato['segundo_parcial'],          // 2da. Prueba parcial 100%
                        $dato['tercer_parcial'],           // 3era. Prueba parcial 100%
                        $dato['nota_promedio'],            // Nota promedio 100%
                        $dato['recuperacion'],             // Prueba de Recuperación 100%
                        $dato['nota_promedio_recuperacion'], // Nota promedio 100%
                        $dato['nota_final'],               // Nota final
                        $dato['calificacion']              // Calificación
                    ] as $value) {
                        if ($col === 'D') {
                            // Salta la columna D porque ahora está combinada con C
                            $col = 'E';
                        }
                        $sheet->setCellValue($col . $row, $value); // Escribe el valor real en la celda
                        $col++;
                    }
                    $row++;
                }

                // Combinar registros
                for ($row = $startRow; $row <= $endRow; $row++) {
                    $range = "C{$row}:D{$row}";
                    if (!isset($sheet->getMergeCells()[$range])) {
                        $sheet->mergeCells($range); // Combina C y D
                    }
                }

                /// Unir celdas de encabezado para que ocupen dos filas
                foreach (range('A', 'L') as $col) {
                    if ($col === 'C') {
                        $sheet->mergeCells('C12:D13'); // Combina C y D
                    } else {
                        $sheet->mergeCells("{$col}12:{$col}13");
                    }
                    $sheet->getStyle("{$col}12")->getAlignment()->setVertical('center')->setHorizontal('center');
                    // Color de letra blanco y negrita
                    $sheet->getStyle("{$col}12")->getFont()->setName('Cambria')->setBold(true)->getColor()->setARGB('000000');
                }


                // Aplicar bordes delgados a todo el rango de encabezados
                $sheet->getStyle('A12:L13')
                    ->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

                // Aplicar bordes dobles solo a los exteriores
                $sheet->getStyle('A12:L13')
                    ->getBorders()->getOutline()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);

                // Títulos principales (centrados, de B1 a I4)
                $sheet->mergeCells('B1:L1');
                $sheet->setCellValue('B1', 'REPUBLICA DE HONDURAS');
                $sheet->getStyle('B1')->getFont()->setName('Cambria')->setBold(true)->setSize(12);
                $sheet->getStyle('B1')->getAlignment()->setHorizontal(horizontalAlignment: 'center');

                $sheet->mergeCells('B2:L2');
                $sheet->setCellValue('B2', 'SECRETARIA DE SEGURIDAD');
                $sheet->getStyle('B2')->getFont()->setName('Cambria')->setBold(true)->setSize(12);
                $sheet->getStyle('B2')->getAlignment()->setHorizontal('center');

                $sheet->mergeCells('B3:L3');
                $sheet->setCellValue('B3', 'UNIVERSIDAD NACIONAL DE LA POLICIA DE HONDURAS (UNPH)');
                $sheet->getStyle('B3')->getFont()->setName('Cambria')->setBold(true)->setSize(12);
                $sheet->getStyle('B3')->getAlignment()->setHorizontal('center');

                $sheet->mergeCells('B4:L4');
                $sheet->setCellValue('B4', 'FACULTAD DE CIENCIAS SOCIALES Y DERECHO (ANAPO)');
                $sheet->getStyle('B4')->getFont()->setName('Cambria')->setBold(true)->setSize(12);
                $sheet->getStyle('B4')->getAlignment()->setHorizontal('center');

                // Licenciatura (A6:B6)
                $sheet->mergeCells('A6:B6');
                $sheet->setCellValue('A6', 'Licenciatura: ');
                $sheet->getStyle('A6')->getFont()->setName('Arial')->setBold(true)->setSize(10);
                $sheet->mergeCells("C6:F6");
                $sheet->setCellValue('C6', ($asignaturaEstudiante->asignaturadocente->asignatura->programaFormacion->nombre ?? ''));
                $sheet->getStyle('C6')->getAlignment()->setHorizontal('center');
                $sheet->getStyle('C6')->getAlignment()->setVertical('center'); // Centrar verticalmente el contenido
                $sheet->getRowDimension('6')->setRowHeight(20);
                $sheet->getStyle('C6:F6')->getFont()->setName('Cambria')->setBold(true)->setSize(10);
                // Aplicar estilo de borde grueso a las celdas combinadas
                $sheet->getStyle('C6:F6')->getBorders()->getOutline()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);

                // Asignatura (A8:B8)
                $sheet->mergeCells('A8:B8');
                $sheet->setCellValue('A8', 'Asignatura: ');
                $sheet->getStyle('A8')->getFont()->setName('Arial')->setBold(true)->setSize(10);
                $sheet->mergeCells('C8:F8');
                $sheet->setCellValue('C8', ($asignaturaEstudiante->asignaturadocente->asignatura->nombre ?? ''));
                $sheet->getStyle('C8')->getAlignment()->setHorizontal('center');
                $sheet->getStyle('C8')->getAlignment()->setVertical('center'); // Centrar verticalmente el contenido
                $sheet->getRowDimension('8')->setRowHeight(20);
                $sheet->getStyle('C8:F8')->getFont()->setName('Cambria')->setBold(true)->setSize(10);
                // Aplicar estilo de borde grueso a las celdas combinadas
                $sheet->getStyle('C8:F8')->getBorders()->getOutline()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);

                // Catedrártico (A6:B6)
                $sheet->mergeCells('A10:B10');
                $sheet->setCellValue('A10', 'Catedrático (a): ');
                $sheet->getStyle('A10')->getFont()->setName('Arial')->setBold(true)->setSize(10);
                $sheet->mergeCells('C10:F10');
                $sheet->setCellValue('C10', ($asignaturaEstudiante->asignaturadocente->docente->nombre ?? ''));
                $sheet->getStyle('C10')->getAlignment()->setHorizontal('center');
                $sheet->getStyle('C10')->getAlignment()->setVertical('center'); // Centrar verticalmente el contenido
                $sheet->getRowDimension('10')->setRowHeight(20);
                $sheet->getStyle('C10:F10')->getFont()->setName('Cambria')->setBold(true)->setSize(10);
                // Aplicar estilo de borde grueso a las celdas combinadas
                $sheet->getStyle('C10:F10')->getBorders()->getOutline()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);

                // Area (D6:F6)
                $sheet->mergeCells('G6');
                $sheet->setCellValue('G6', 'Área: ');
                $sheet->getStyle('G6')->getFont()->setName('Arial')->setBold(true)->setSize(10);
                $sheet->getStyle('G6')->getAlignment()->setHorizontal('center');
                $sheet->getStyle('G6')->getAlignment()->setVertical('center'); // Centrar verticalmente el contenido
                $sheet->getStyle('G6')->getAlignment()->setHorizontal('right');

                // Combinar las celdas desde E6 hasta I6
                $sheet->mergeCells('H6:L6');

                // Aplicar estilo de borde grueso a las celdas combinadas
                $sheet->getStyle('H6:L6')->getBorders()->getOutline()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
                $sheet->getStyle('H6:L6')->getFont()->setName('Cambria')->setBold(true)->setSize(10);
                // Centrar el texto en la celda combinada
                $sheet->getStyle('H6:L6')->getAlignment()->setHorizontal('center')->setVertical('center');

                // Duración (D8:F8)
                $sheet->mergeCells('G8');
                $sheet->setCellValue('G8', 'Duración: ');
                $sheet->getStyle('G8')->getAlignment()->setHorizontal('center');
                $sheet->getStyle('G8')->getAlignment()->setVertical('center'); // Centrar verticalmente el contenido
                $sheet->getStyle('G8')->getFont()->setName('Arial')->setBold(true)->setSize(10);
                $sheet->getStyle('G8')->getAlignment()->setHorizontal('right');

                // Combinar las celdas desde E8 hasta I8
                $sheet->mergeCells('H8:L8');

                // Aplicar estilo de borde grueso a las celdas combinadas
                $sheet->getStyle('H8:L8')->getBorders()->getOutline()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
                $sheet->getStyle('H8:L8')->getFont()->setName('Cambria')->setBold(true)->setSize(10);
                // Centrar el texto en la celda combinada
                $sheet->getStyle('H8:L8')->getAlignment()->setHorizontal('center')->setVertical('center');

                // Horas (E8:F8)
                $sheet->mergeCells('G10');
                $sheet->setCellValue('G10', 'Horas: ');
                $sheet->getStyle('G10')->getFont()->setName('Arial')->setBold(true)->setSize(10);
                $sheet->setCellValue('H10', ($asignaturaEstudiante->asignaturadocente->asignatura->horas ?? ''));
                $sheet->getStyle('G10')->getAlignment()->setHorizontal('right');
                $sheet->getStyle('H10')->getFont()->setName('Cambria')->setBold(true)->setSize(10);
                $sheet->getStyle('H10')->getAlignment()->setHorizontal('center');
                $sheet->getStyle('H10')->getAlignment()->setVertical('center'); // Centrar verticalmente el contenido
                // Aplicar estilo de borde grueso a las celdas combinadas
                $sheet->getStyle('H10')->getBorders()->getOutline()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);

                // UV (E6:F6)
                $sheet->mergeCells('I10');
                $sheet->setCellValue('I10', 'UV: ');
                $sheet->getStyle('I10')->getFont()->setName('Arial')->setBold(true)->setSize(10);
                $sheet->getStyle('I10')->getAlignment()->setHorizontal('right');
                $sheet->setCellValue('J10', ($asignaturaEstudiante->asignaturadocente->asignatura->creditos ?? ''));
                $sheet->getStyle('J10')->getAlignment()->setHorizontal('center');
                $sheet->getStyle('J10')->getAlignment()->setVertical('center'); // Centrar verticalmente el contenido
                $sheet->getStyle('J10')->getFont()->setName('Cambria')->setBold(true)->setSize(10);
                // Aplicar estilo de borde grueso a las celdas combinadas
                $sheet->getStyle('J10')->getBorders()->getOutline()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);

                // Código (E6:F6)
                $sheet->mergeCells('K10');
                $sheet->setCellValue('K10', 'Código: ');
                $sheet->getStyle('K10')->getFont()->setName('Arial')->setBold(true)->setSize(10);
                $sheet->getStyle('K10')->getAlignment()->setHorizontal('right');
                $sheet->setCellValue('L10', ($asignaturaEstudiante->asignaturadocente->asignatura->codigo ?? ''));
                $sheet->getStyle('L10')->getAlignment()->setHorizontal('center');
                $sheet->getStyle('L10')->getAlignment()->setVertical('center'); // Centrar verticalmente el contenido
                $sheet->getStyle('L10')->getFont()->setName('Cambria')->setBold(true)->setSize(10);
                // Aplicar estilo de borde grueso a las celdas combinadas
                $sheet->getStyle('L10')->getBorders()->getOutline()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);

                // Asigna el ancho específico a cada columna
                $sheet->getColumnDimension('A')->setWidth(5);   // Nº
                $sheet->getColumnDimension('B')->setWidth(12);  // Código
                $sheet->getColumnDimension('C')->setWidth(14);  // Nombre
                $sheet->getColumnDimension('D')->setWidth(14);  // Primer Parcial
                $sheet->getColumnDimension('E')->setWidth(11);  // Segundo Parcial
                $sheet->getColumnDimension('F')->setWidth(11);  // Tercer Parcial
                $sheet->getColumnDimension('G')->setWidth(11);  // Asistencia
                $sheet->getColumnDimension('H')->setWidth(11);  // Recuperación
                $sheet->getColumnDimension('I')->setWidth(11);  // Observación
                $sheet->getColumnDimension('J')->setWidth(11);  // Nota Promedio
                $sheet->getColumnDimension('K')->setWidth(11);  // Nota Final
                $sheet->getColumnDimension('L')->setWidth(11);  // Nota Final
    
                // Calcular la fila donde terminan los datos
                $lastRow = $sheet->getHighestRow() + 8; // +2 para dejar una fila de espacio
                // Calcular la fila donde termina el contenido de la tabla
                $pageRow = $sheet->getHighestRow() + 1; // Deja 1 filas de espacio después del contenido
    
                // Combinar celdas para el texto de la página
                $sheet->mergeCells("A{$pageRow}:B{$pageRow}");

                // Escribir el texto "Página _____ de _____"
                $sheet->setCellValue("A{$pageRow}", 'Página ______ de ______');



                // Aplicar formato al texto
                $sheet->getStyle("A{$pageRow}")
                    ->getFont()->setBold(true)->setSize(10)->setName('Cambria');


                // Encabezados del cuadro
                $sheet->mergeCells("A{$lastRow}:B{$lastRow}"); // Combina A y B
                $sheet->setCellValue("A{$lastRow}", 'Calificaciones'); // Escribe en la celda combinada
                $sheet->setCellValue("C{$lastRow}", 'Abreviaturas');
                $sheet->setCellValue("D{$lastRow}", 'Notas');

                // Datos del cuadro
                $calificaciones = [
                    ['Excelente', 'EXC.', '90.00  a 100.00'],
                    ['Muy Bueno', 'M.B.', '80.00  a  89.99'],
                    ['Bueno', 'B.', '70.00  a  79.99'],
                    ['Insuficiente', 'INS.', ' 0.00  a  69.99'],
                    ['No se presento', 'NSP.', ' 0.00  a   0.00'],
                    ['Separado', 'SPD.', ' 0.00  a   0.00'],
                    ['Abandono', 'ABD.', ' 0.00  a   0.00'],
                    ['Expulsado', 'EXP.', ' 0.00  a   0.00'],
                ];

                $row = $lastRow + 1;

                foreach ($calificaciones as $calif) {
                    // Combina las columnas A y B
                    $sheet->mergeCells("A{$row}:B{$row}");
                    $sheet->setCellValue("A{$row}", $calif[0]); // Escribe el contenido en la celda combinada (A y B)
    
                    // Escribe los datos en las columnas C y D
                    $sheet->setCellValue("C{$row}", $calif[1]); // Abreviaturas
                    $sheet->setCellValue("D{$row}", $calif[2]); // Notas
    
                    // Centrar el texto en las celdas
                    $sheet->getStyle("A{$row}:D{$row}")
                        ->getAlignment()->setHorizontal('center')->setVertical('center');
                    $sheet->getStyle("A{$row}:D{$row}")
                        ->getFont()->setName('Cambria')->setBold(true)->setSize(10);
                    $row++;
                }

                // Calcular la fila donde termina el contenido de la tabla
                $pageRow = $row + 2; // Deja 2 filas de espacio después del contenido
    
                // Determinar la fila donde termina la tabla de registros
                $reglamentoStartRow = $endRow + 3; // Deja 2 filas de espacio después de la tabla de registros
    
                // Dividir el texto del reglamento en líneas
                $reglamentoTexto = [
                    "Reglamento de Evaluación UNPH/ Articulo 24.- Concluída la práctica de las pruebas y habiendo calificado a cada alumno y hecha la promediación, el docente llenará de su",
                    "puño y letra el cuadro de notas y calificaciones, sin alteraciones a la misma previa la autorización del respectivo Jefe de Departamento las entregará al Departamento;",
                    "de Registro y Archivo UNPH, adjuntas las Actas de las Críticas parciales, reposición y recuperación debidamente razonadas, selladas y firmadas. Los docentes están",
                    "obligados a entregar los cuadros de notas a más tardar tres (3) días hábiles después de la última crítica, del Reglamento Sobre Procedimientos para la Evaluación de UNPH.",
                ];

                // Escribir cada línea en una fila separada y combinar celdas hasta la columna L
                foreach ($reglamentoTexto as $index => $linea) {
                    $sheet->mergeCells("A{$reglamentoStartRow}:L{$reglamentoStartRow}"); // Combina desde A hasta L
                    $sheet->setCellValue("A{$reglamentoStartRow}", $linea); // Escribe el texto en la celda combinada
    
                    $style = $sheet->getStyle("A{$reglamentoStartRow}:L{$reglamentoStartRow}");
                    $style->getAlignment()
                        ->setHorizontal('justify') // Justificar el texto
                        ->setVertical('center')    // Centrar verticalmente
                        ->setWrapText(true);       // Ajustar texto automáticamente
    
                    $font = $style->getFont()->setName('Cambria')->setSize(10); // Fuente Cambria, tamaño 10
    
                    // Aplicar negrita solo a la primera línea
                    if ($index === 0) {
                        $font->setBold(true)->setSize(9); // Negrita y tamaño 10 para la primera línea
                    }

                    $reglamentoStartRow++; // Avanzar a la siguiente fila
                }

                //dejar una fila de espacio después del reglamento
                $reglamentoStartRow++;

                // Combinar celdas para el texto de la página
                $sheet->mergeCells("A{$pageRow}:B{$pageRow}");

                // Escribir el texto "Página _____ de _____"
                $sheet->setCellValue("A{$pageRow}", 'Página ______ de ______');

                // Aplicar formato al texto
                $sheet->getStyle("A{$pageRow}")
                    ->getFont()->setBold(true)->setSize(10)->setName('Cambria');

                // Escribir el texto "Recibido"
                $sheet->setCellValue("C{$pageRow}", 'Recibido: ');
                $sheet->getRowDimension($pageRow)->setRowHeight(20);
                $sheet->getStyle("C{$pageRow}")->getAlignment()->setHorizontal('right');
                // Aplicar estilo de borde grueso a las celdas combinadas
                $sheet->mergeCells("D{$pageRow}:G{$pageRow}");
                $sheet->getStyle("D{$pageRow}:G{$pageRow}")->getBorders()->getOutline()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);

                // Aplicar formato al texto
                $sheet->getStyle("A{$pageRow}")
                    ->getFont()->setBold(true)->setSize(10)->setName('Cambria');

                // Aplicar formato: negrita a encabezados
                $sheet->getStyle("A{$lastRow}:D{$lastRow}")->getFont()->setBold(true);

                // Aplicar bordes delgados a todo el cuadro
                $sheet->getStyle("A{$lastRow}:D" . ($row - 1))
                    ->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

                // Centrar texto en todo el cuadro
                $sheet->getStyle("A{$lastRow}:D{$lastRow}")
                    ->getAlignment()->setHorizontal('center')->setVertical('center');


                // Determina la fila inicial y final del cuadro de observaciones
                $obsStartRow = $lastRow;
                $obsEndRow = $row - 1;

                // Escribe "Observaciones:" en la columna F
                $sheet->setCellValue("F{$obsStartRow}", 'Observaciones:');
                $sheet->getStyle("F{$obsStartRow}")->getFont()->setBold(true);
                $sheet->getStyle("F{$obsStartRow}:I{$obsStartRow}")
                    ->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

                // Une las celdas E{obsStartRow}:G{obsStartRow} para el título
                $sheet->mergeCells("F{$obsStartRow}:I{$obsStartRow}");

                // Dibuja las líneas para las observaciones (6 filas vacías)
                for ($i = $obsStartRow + 1; $i <= $obsStartRow + 8; $i += 2) { // Incrementa de 2 en 2 para combinar dos filas
                    // Combina las celdas verticalmente en el rango F:I
                    $sheet->mergeCells("F{$i}:I" . ($i + 1));

                    // Aplica bordes a las celdas combinadas
                    $sheet->getStyle("F{$i}:I" . ($i + 1))
                        ->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                }

                // Agregar la sección de firmas al lado de la tabla de observaciones
                $signStartRow = $obsStartRow + 2; // Comienza +2 de la fila que "Observaciones"
    
                // Firma del Catedrático
                $sheet->mergeCells("K{$signStartRow}:L{$signStartRow}");
                $sheet->setCellValue("K{$signStartRow}", '___________________');
                $sheet->getStyle("K{$signStartRow}")->getAlignment()->setHorizontal('center');

                $sheet->mergeCells("K" . ($signStartRow + 1) . ":L" . ($signStartRow + 1));
                $sheet->setCellValue("K" . ($signStartRow + 1), 'Firma Catedrático (a)');
                $sheet->getStyle("K" . ($signStartRow + 1))->getFont()->setBold(true);
                $sheet->getStyle("K" . ($signStartRow + 1))->getAlignment()->setHorizontal('center');

                // Espacio vacío debajo de la firma del catedrático
                $sheet->mergeCells("K" . ($signStartRow + 2) . ":L" . ($signStartRow + 4));

                // Firma del Jefe de Área
                $sheet->mergeCells("K" . ($signStartRow + 5) . ":L" . ($signStartRow + 5));
                $sheet->setCellValue("K" . ($signStartRow + 5), '____________________');
                $sheet->getStyle("K" . ($signStartRow + 5))->getAlignment()->setHorizontal('center');

                $sheet->mergeCells("K" . ($signStartRow + 6) . ":L" . ($signStartRow + 6));
                $sheet->setCellValue("K" . ($signStartRow + 6), 'Firma y Sello del');
                $sheet->getStyle("K" . ($signStartRow + 6))->getFont()->setBold(true);
                $sheet->getStyle("K" . ($signStartRow + 6))->getAlignment()->setHorizontal('center');

                $sheet->mergeCells("K" . ($signStartRow + 7) . ":L" . ($signStartRow + 7));
                $sheet->setCellValue("K" . ($signStartRow + 7), 'Jefe (a) de Area');
                $sheet->getStyle("K" . ($signStartRow + 7))->getFont()->setBold(true);
                $sheet->getStyle("K" . ($signStartRow + 7))->getAlignment()->setHorizontal('center');
            }
        ];
    }
}