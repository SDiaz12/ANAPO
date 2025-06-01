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
    protected $mostrarTercerParcial; // Nuevo parámetro

    public function __construct($codigo_asignatura, $codigo_docente, $seccion_id, $mostrarTercerParcial = false)
    {
        $this->codigo_asignatura = $codigo_asignatura;
        $this->codigo_docente = $codigo_docente;
        $this->seccion_id = $seccion_id;
        $this->mostrarTercerParcial = $mostrarTercerParcial; // Asignar el valor recibido
        //dd($this->mostrarTercerParcial);
    }

    public function headings(): array
    {
        if ($this->mostrarTercerParcial) {
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
    } else {
        return $this->segundoHeadings();
    }
    }

    public function segundoHeadings(): array
    {
        return [
            'Nº',
            'Nº Cuenta',
            'Nombres y Apellidos',
            '1era. Prueba parcial 100%',
            '2da. Prueba parcial 100%',
            'Nota promedio 100%',
            'Prueba de Recuperación 100%',
            'Nota promedio 100%',
            'Nota final',
            'Calificación'
        ];
    }

    private function determinarCalificacion($notaFinal)
    {
        if ($notaFinal >= 90) {
            return 'Excelente';
        } elseif ($notaFinal >= 80) {
            return 'Muy Bueno';
        } elseif ($notaFinal >= 70) {
            return 'Bueno';
        } elseif ($notaFinal >= 0) {
            return 'Insuficiente';
        } else {
            return 'Sin calificación';
        }
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
                    'tercer_parcial' => $nota->tercerparcial ?? null, // Puede ser null si no hay tercer parcial
                    'nota_promedio' => count(array_filter([
                        $nota->primerparcial ?? 0,
                        $nota->segundoparcial ?? 0,
                        $nota->tercerparcial ?? null,
                    ])) > 0
                        ? round(
                            array_sum(array_filter([
                                $nota->primerparcial ?? 0,
                                $nota->segundoparcial ?? 0,
                                $nota->tercerparcial ?? null,
                            ])) / count(array_filter([
                                    $nota->primerparcial ?? 0,
                                    $nota->segundoparcial ?? 0,
                                    $nota->tercerparcial ?? null,
                                ])),
                            0
                        )
                        : 0, // Si no hay parciales, el promedio es 0
                    'recuperacion' => $nota->recuperacion ?? '',
                    'nota_promedio_recuperacion' => ($nota->recuperacion ?? 0) > 0 && count(array_filter([
                        $nota->primerparcial ?? 0,
                        $nota->segundoparcial ?? 0,
                        $nota->tercerparcial ?? null,
                    ])) > 0
                        ? round(
                            (array_sum(array_filter([
                                $nota->primerparcial ?? 0,
                                $nota->segundoparcial ?? 0,
                                $nota->tercerparcial ?? null,
                            ])) - min(array_filter([
                                    $nota->primerparcial ?? 0,
                                    $nota->segundoparcial ?? 0,
                                    $nota->tercerparcial ?? null,
                                ])) + ($nota->recuperacion ?? 0)) / count(array_filter([
                                    $nota->primerparcial ?? 0,
                                    $nota->segundoparcial ?? 0,
                                    $nota->tercerparcial ?? null,
                                ])),
                            0
                        )
                        : null, // Si la recuperación es null o 0, o no hay parciales, no se calcula
                    'nota_final' => ($nota->recuperacion ?? 0) > 0 && count(array_filter([
                        $nota->primerparcial ?? 0,
                        $nota->segundoparcial ?? 0,
                        $nota->tercerparcial ?? null,
                    ])) > 0
                        ? round(
                            (array_sum(array_filter([
                                $nota->primerparcial ?? 0,
                                $nota->segundoparcial ?? 0,
                                $nota->tercerparcial ?? null,
                            ])) - min(array_filter([
                                    $nota->primerparcial ?? 0,
                                    $nota->segundoparcial ?? 0,
                                    $nota->tercerparcial ?? null,
                                ])) + ($nota->recuperacion ?? 0)) / count(array_filter([
                                    $nota->primerparcial ?? 0,
                                    $nota->segundoparcial ?? 0,
                                    $nota->tercerparcial ?? null,
                                ])),
                            0
                        )
                        : round(
                            count(array_filter([
                                $nota->primerparcial ?? 0,
                                $nota->segundoparcial ?? 0,
                                $nota->tercerparcial ?? null,
                            ])) > 0
                            ? array_sum(array_filter([
                                $nota->primerparcial ?? 0,
                                $nota->segundoparcial ?? 0,
                                $nota->tercerparcial ?? null,
                            ])) / count(array_filter([
                                    $nota->primerparcial ?? 0,
                                    $nota->segundoparcial ?? 0,
                                    $nota->tercerparcial ?? null,
                                ]))
                            : 0,
                            0
                        ), // Si la recuperación es 0, usa el promedio dinámico o 0 si no hay parciales
                    'calificacion' => $this->determinarCalificacion(round(
                        max(($nota->recuperacion ?? 0), count(array_filter([
                            $nota->primerparcial ?? 0,
                            $nota->segundoparcial ?? 0,
                            $nota->tercerparcial ?? null,
                        ])) > 0
                            ? array_sum(array_filter([
                                $nota->primerparcial ?? 0,
                                $nota->segundoparcial ?? 0,
                                $nota->tercerparcial ?? null,
                            ])) / count(array_filter([
                                    $nota->primerparcial ?? 0,
                                    $nota->segundoparcial ?? 0,
                                    $nota->tercerparcial ?? null,
                                ]))
                            : 0),
                        0
                    )), // Calificación basada en la nota final
                ];
            });
    }

    public function styles($sheet)
    {
        //
    }

    public function registerEvents(): array
    {
        if ($this->mostrarTercerParcial) {
            return [
                //CALIFICACIONES DE 3 PARCIALES
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

                        // Insertar filas para el encabezado de tabla (12 filas)
                        $sheet->insertNewRowBefore(1, 12);

                        // Escribir encabezados
                        $headings = $this->headings();
                        $col = 'A';
                        foreach ($headings as $heading) {
                            if ($col === 'D') {
                                $col = 'E';
                            }
                            $sheet->setCellValue($col . '12', $heading);
                            $sheet->getStyle($col . '12')->getFont()
                                ->setName('Cambria')->setBold(true)->setSize(8);
                            $sheet->getStyle($col . '12')->getAlignment()
                                ->setHorizontal('center')
                                ->setVertical('center')
                                ->setWrapText(true);
                            $col++;
                        }

                        $datos = $this->collection()->toArray();
                        $totalRecords = count($datos);
                        $recordsPerPage = 24;
                        $endRow = $sheet->getHighestRow(); // Última fila con datos
                        $spaceBetweenBlocks = 4;
                        $startRow = 14; // Comenzar justo después del encabezado existente
                        $blockNumber = 0;

                        while ($blockNumber * $recordsPerPage < $totalRecords) {
                            $startIdx = $blockNumber * $recordsPerPage;
                            $endIdx = min(($blockNumber + 1) * $recordsPerPage, $totalRecords);

                            // Calcular la fila de inicio para este bloque
                            if ($blockNumber == 0) {
                                $currentStartRow = $startRow;
                            } else {
                                // Para bloques adicionales, la fila inicial será después del espacio entre bloques
                                $previousEndRow = $startRow + ($blockNumber * $recordsPerPage) + (($blockNumber - 1) * $spaceBetweenBlocks);
                                $currentStartRow = $previousEndRow + $spaceBetweenBlocks;

                                // Insertar filas para el espacio entre bloques
                                $sheet->insertNewRowBefore($previousEndRow, $spaceBetweenBlocks);

                                // Eliminar cualquier estilo o formato de las filas de espacio
                                for ($i = $previousEndRow; $i < $currentStartRow; $i++) {
                                    // Limpiar bordes
                                    $sheet->getStyle("A{$i}:L{$i}")->getBorders()->getAllBorders()->setBorderStyle(null);
                                    // Limpiar colores de fondo
                                    $sheet->getStyle("A{$i}:L{$i}")->getFill()->setFillType(null);
                                    // Restaurar fuente predeterminada
                                    $sheet->getStyle("A{$i}:L{$i}")->getFont()->setName('Calibri')->setSize(11)->setBold(false);
                                }

                                // Agregar "Página ______ de ______" en la primera fila del espacio entre bloques (sólo para el primer espacio)
                                if ($blockNumber == 1) {
                                    $sheet->mergeCells("A{$previousEndRow}:B{$previousEndRow}");
                                    $sheet->setCellValue("A{$previousEndRow}", 'Página ______ de ______');
                                    $sheet->getStyle("A{$previousEndRow}")
                                        ->getFont()->setBold(true)->setSize(10)->setName('Cambria');
                                }

                                // Encabezado del bloque adicional
                                $col = 'A';
                                foreach ($headings as $heading) {
                                    if ($col === 'D') {
                                        $col = 'E';
                                    }
                                    $sheet->setCellValue($col . $currentStartRow, $heading);
                                    $sheet->getStyle($col . $currentStartRow)->getFont()
                                        ->setName('Cambria')->setBold(true)->setSize(8);
                                    $sheet->getStyle($col . $currentStartRow)->getAlignment()
                                        ->setHorizontal('center')
                                        ->setVertical('center')
                                        ->setWrapText(true);
                                    $col++;
                                }

                                // Aplicar estilos a los encabezados del bloque
                                $sheet->getStyle('A' . $currentStartRow . ':L' . $currentStartRow)
                                    ->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                                $sheet->getStyle('A' . $currentStartRow . ':L' . $currentStartRow)
                                    ->getBorders()->getOutline()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);

                                $currentStartRow++; // Avanzar a la siguiente fila después del encabezado
                            }

                            // Datos del bloque - SOLO LOS CORRESPONDIENTES AL RANGO DE ESTE BLOQUE
                            $row = $currentStartRow;
                            $blockEndRow = $row - 1; // Inicializar para mantener seguimiento de la última fila
            
                            for ($i = $startIdx; $i < $endIdx; $i++) {
                                $dato = $datos[$i];
                                $col = 'A';
                                foreach ([$i + 1, $dato['codigo_estudiante'], $dato['nombre_estudiante'], $dato['primer_parcial'], $dato['segundo_parcial'], $dato['tercer_parcial'], $dato['nota_promedio'], $dato['recuperacion'], $dato['nota_promedio_recuperacion'], $dato['nota_final'], $dato['calificacion']] as $value) {
                                    if ($col === 'D') {
                                        $col = 'E';
                                    }
                                    $sheet->setCellValue($col . $row, $value);
                                    $sheet->getStyle('E' . $row . ':L' . $row)->getAlignment()
                                        ->setVertical('center')->setHorizontal('left');
                                    $sheet->getStyle('E' . $row . ':L' . $row)->getFont()
                                        ->setName('Cambria')->setBold(true)->getColor()->setARGB('000000');
                                    $col++;
                                }

                                // Aplicar estilos a cada fila de datos
                                $sheet->getStyle('A' . $row . ':L' . $row)
                                    ->getFont()->setName('Calibri')->setSize(11);
                                $sheet->getStyle('A' . $row . ':L' . $row)
                                    ->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

                                $blockEndRow = $row; // Actualizar la última fila de este bloque
                                $row++;
                            }

                            // Aplicar bordes dobles solo al rango de este bloque
                            $rangeStart = $currentStartRow;
                            $sheet->getStyle('A' . $rangeStart . ':L' . $blockEndRow)
                                ->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
                            $sheet->getStyle('A' . $rangeStart . ':L' . $blockEndRow)
                                ->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
                            $sheet->getStyle('A' . $rangeStart . ':L' . $blockEndRow)
                                ->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);

                            // Alineación centrada para todas las filas del bloque
                            $sheet->getStyle('A' . $rangeStart . ':L' . $blockEndRow)
                                ->getAlignment()->setHorizontal('center')->setVertical('center');

                            // Combinar celdas C-D en este bloque
                            for ($r = $rangeStart; $r <= $blockEndRow; $r++) {
                                $range = "C{$r}:D{$r}";
                                if (!isset($sheet->getMergeCells()[$range])) {
                                    $sheet->mergeCells($range);
                                }
                            }

                            // Si es el primer bloque, agregamos el texto "Página ______ de ______" 
                            // justo después de terminar este bloque
                            if ($blockNumber == 0 && $blockNumber + 1 < ceil($totalRecords / $recordsPerPage)) {
                                $pageRow = $blockEndRow + 1;
                                $sheet->mergeCells("A{$pageRow}:B{$pageRow}");
                                $sheet->setCellValue("A{$pageRow}", 'Página ______ de ______');
                                $sheet->getStyle("A{$pageRow}")
                                    ->getFont()->setBold(true)->setSize(10)->setName('Cambria');
                            }

                            $blockNumber++;
                        }

                        // Ajustar estilos de encabezados combinados
                        foreach (range('A', 'L') as $col) {
                            if ($col === 'C') {
                                $sheet->mergeCells('C12:D13');
                            } else {
                                $sheet->mergeCells("{$col}12:{$col}13");
                            }
                            $sheet->getStyle("{$col}12")->getAlignment()
                                ->setVertical('center')->setHorizontal('center');
                            $sheet->getStyle("{$col}12")->getFont()
                                ->setName('Cambria')->setBold(true)->getColor()->setARGB('000000');
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
                        $sheet->setCellValue('B3', value: 'UNIVERSIDAD NACIONAL DE LA POLICIA DE HONDURAS (UNPH)');
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
                        // Si solo hay un bloque ($blockNumber <= 1), usar 4 filas de espacio, de lo contrario usar 8
                        $numeroFilas = ($blockNumber <= 1) ? 4 : 8;
                        $reglamentoStartRow = $endRow + $numeroFilas; // Deja 4 o 8 filas de espacio después de la tabla de registros
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
                        $sheet->getStyle("C{$pageRow}")->getFont()->setName('Arial')->setBold(true)->setSize(10);
                        $sheet->getStyle("C{$pageRow}")->getAlignment()->setHorizontal('right');
                        $sheet->getStyle("C{$pageRow}")
                            ->getFont()->setBold(true)->setSize(10)->setName('Cambria');
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
        }else{
            return[
                //CALIFICACIONES DE 2 PARCIALES
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

            // Insertar filas para el encabezado de tabla (12 filas)
            $sheet->insertNewRowBefore(1, 12);

            // Definir los encabezados en el orden correcto
            // Nota: 'Nombres y Apellidos' se gestionará con mergeCells en C:D
            $headers = [
                'Nº',
                'Nº Cuenta',
                'Nombres y Apellidos', // Este texto se usará para el merge C12:D13
                '1era. Prueba parcial 100%',
                '2da. Prueba parcial 100%',
                'Nota promedio 100%',
                'Prueba de Recuperación 100%',
                'Nota promedio 100%',
                'Nota final',
                'Calificación'
            ];

            // Escribir encabezados en la fila 12
            $colMap = ['A', 'B', 'C', 'E', 'F', 'G', 'H', 'I', 'J', 'K']; // Mapeo de encabezados a columnas reales
            $headerIndex = 0;
            foreach ($headers as $heading) {
                $currentCol = $colMap[$headerIndex];
                $sheet->setCellValue($currentCol . '12', $heading);
                $sheet->getStyle($currentCol . '12')->getFont()
                    ->setName('Cambria')->setBold(true)->setSize(8);
                $sheet->getStyle($currentCol . '12')->getAlignment()
                    ->setHorizontal('center')
                    ->setVertical('center')
                    ->setWrapText(true);
                $headerIndex++;
            }

            $datos = $this->collection()->toArray();
            $totalRecords = count($datos);
            $recordsPerPage = 24;
            $endRow = $sheet->getHighestRow(); // Última fila con datos
            $spaceBetweenBlocks = 4;
            $startRow = 14; // Comenzar justo después del encabezado existente
            $blockNumber = 0;

            while ($blockNumber * $recordsPerPage < $totalRecords) {
                $startIdx = $blockNumber * $recordsPerPage;
                $endIdx = min(($blockNumber + 1) * $recordsPerPage, $totalRecords);

                // Calcular la fila de inicio para este bloque
                if ($blockNumber == 0) {
                    $currentStartRow = $startRow;
                } else {
                    // Para bloques adicionales, la fila inicial será después del espacio entre bloques
                    $previousEndRow = $startRow + ($blockNumber * $recordsPerPage) + (($blockNumber - 1) * $spaceBetweenBlocks);
                    $currentStartRow = $previousEndRow + $spaceBetweenBlocks;

                    // Insertar filas para el espacio entre bloques
                    $sheet->insertNewRowBefore($previousEndRow, $spaceBetweenBlocks);

                    // Eliminar cualquier estilo o formato de las filas de espacio
                    for ($i = $previousEndRow; $i < $currentStartRow; $i++) {
                        // Limpiar bordes
                        $sheet->getStyle("A{$i}:K{$i}")->getBorders()->getAllBorders()->setBorderStyle(null);
                        // Limpiar colores de fondo
                        $sheet->getStyle("A{$i}:K{$i}")->getFill()->setFillType(null);
                        // Restaurar fuente predeterminada
                        $sheet->getStyle("A{$i}:K{$i}")->getFont()->setName('Calibri')->setSize(11)->setBold(false);
                    }

                    // Agregar "Página ______ de ______" en la primera fila del espacio entre bloques (sólo para el primer espacio)
                    if ($blockNumber == 1) { // Esto es para la segunda página en adelante
                        $sheet->mergeCells("A{$previousEndRow}:B{$previousEndRow}");
                        $sheet->setCellValue("A{$previousEndRow}", 'Página ______ de ______');
                        $sheet->getStyle("A{$previousEndRow}")
                            ->getFont()->setBold(true)->setSize(10)->setName('Cambria');
                    }

                    // **Encabezados del bloque adicional**
                    // Se usa el mismo mapeo para asegurar consistencia
                    $colMap = ['A', 'B', 'C', 'E', 'F', 'G', 'H', 'I', 'J', 'K']; // Mapeo de encabezados a columnas reales
                    $headerIndex = 0;
                    foreach ($headers as $heading) {
                        $currentCol = $colMap[$headerIndex];
                        $sheet->setCellValue($currentCol . $currentStartRow, $heading);
                        $sheet->getStyle($currentCol . $currentStartRow)->getFont()
                            ->setName('Cambria')->setBold(true)->setSize(8);
                        $sheet->getStyle($currentCol . $currentStartRow)->getAlignment()
                            ->setHorizontal('center')
                            ->setVertical('center')
                            ->setWrapText(true);
                        $headerIndex++;
                    }
                    // Después de escribir los encabezados, SOLO combinar C:D para "Nombres y Apellidos"
                    $sheet->mergeCells("C{$currentStartRow}:D{$currentStartRow}");

                    // Aplicar estilos a los encabezados del bloque
                    $sheet->getStyle('A' . $currentStartRow . ':K' . $currentStartRow)
                        ->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                    $sheet->getStyle('A' . $currentStartRow . ':K' . $currentStartRow)
                        ->getBorders()->getOutline()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
                    $currentStartRow++; // Avanzar a la siguiente fila después del encabezado
                }

                // Datos del bloque - SOLO LOS CORRESPONDIENTES AL RANGO DE ESTE BLOQUE
                $row = $currentStartRow;
                $blockEndRow = $row - 1; // Inicializar para mantener seguimiento de la última fila

                for ($i = $startIdx; $i < $endIdx; $i++) {
                    $dato = $datos[$i];
                    $sheet->setCellValue('A' . $row, $i + 1); // Nº
                    $sheet->setCellValue('B' . $row, $dato['codigo_estudiante']); // Nº Cuenta
                    $sheet->setCellValue('C' . $row, $dato['nombre_estudiante']); // Nombres y Apellidos (se fusionará C:D)
                    $sheet->setCellValue('E' . $row, $dato['primer_parcial']); // 1era. Prueba parcial 100%
                    $sheet->setCellValue('F' . $row, $dato['segundo_parcial']); // 2da. Prueba parcial 100%
                    // Se omite tercer_parcial
                    $sheet->setCellValue('G' . $row, $dato['nota_promedio']); // Nota promedio 100% (primera)
                    $sheet->setCellValue('H' . $row, $dato['recuperacion']); // Prueba de Recuperación 100%
                    $sheet->setCellValue('I' . $row, $dato['nota_promedio_recuperacion']); // Nota promedio 100% (segunda)
                    $sheet->setCellValue('J' . $row, $dato['nota_final']); // Nota final
                    $sheet->setCellValue('K' . $row, $dato['calificacion']); // Calificación

                    // Aplicar estilos a cada fila de datos
                    $sheet->getStyle('A' . $row . ':K' . $row)
                        ->getFont()->setName('Calibri')->setSize(11);
                    $sheet->getStyle('A' . $row . ':K' . $row)
                        ->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

                    // Estilos para datos numéricos (de E a K)
                    $sheet->getStyle('E' . $row . ':K' . $row)->getAlignment()
                        ->setVertical('center')->setHorizontal('center');
                    $sheet->getStyle('E' . $row . ':K' . $row)->getFont()
                        ->setName('Cambria')->setBold(true)->getColor()->setARGB('000000');

                    // Estilos para la columna 'Nombres y Apellidos' (C:D)
                    $sheet->getStyle('C' . $row . ':D' . $row)->getAlignment()
                        ->setHorizontal('left'); // Alinear el nombre a la izquierda

                    $blockEndRow = $row; // Actualizar la última fila de este bloque
                    $row++;
                }

                // Aplicar bordes dobles solo al rango de este bloque
                $rangeStart = $currentStartRow;
                $sheet->getStyle('A' . $rangeStart . ':K' . $blockEndRow)
                    ->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
                $sheet->getStyle('A' . $rangeStart . ':K' . $blockEndRow)
                    ->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
                $sheet->getStyle('A' . $rangeStart . ':K' . $blockEndRow)
                    ->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);

                // Alineación centrada para todas las filas del bloque
                $sheet->getStyle('A' . $rangeStart . ':K' . $blockEndRow)
                    ->getAlignment()->setHorizontal('center')->setVertical('center');

                // Combinar celdas C-D en este bloque para las filas de datos
                for ($r = $rangeStart; $r <= $blockEndRow; $r++) {
                    $range = "C{$r}:D{$r}";
                    if (!isset($sheet->getMergeCells()[$range])) {
                        $sheet->mergeCells($range);
                    }
                }

                // Si es el primer bloque, agregamos el texto "Página ______ de ______"
                // justo después de terminar este bloque
                if ($blockNumber == 0 && $blockNumber + 1 < ceil($totalRecords / $recordsPerPage)) {
                    $pageRow = $blockEndRow + 1;
                    $sheet->mergeCells("A{$pageRow}:B{$pageRow}");
                    $sheet->setCellValue("A{$pageRow}", 'Página ______ de ______');
                    $sheet->getStyle("A{$pageRow}")
                        ->getFont()->setBold(true)->setSize(10)->setName('Cambria');
                }

                $blockNumber++;
            }

            // **Ajustar estilos de encabezados combinados y la posición de 'Nombres y Apellidos'**
            // Primero, desfusionamos C12:D13 si ya estaba fusionada para evitar errores al re-fusionar.
            // Esto es solo una precaución, normalmente no es necesario si la lógica es secuencial.
            if (isset($sheet->getMergeCells()['C12:D13'])) {
                $sheet->unmergeCells('C12:D13');
            }

            // Fusionar C12:D13 para el encabezado 'Nombres y Apellidos'
            $sheet->mergeCells('C12:D13');
            $sheet->getStyle('C12')->getAlignment()
                ->setVertical('center')->setHorizontal('center');
            $sheet->getStyle('C12')->getFont()
                ->setName('Cambria')->setBold(true)->getColor()->setARGB('000000');

            // Ahora, fusionar el resto de las celdas en la fila 12 y 13 para los encabezados individuales
            $colsToMerge = ['A', 'B', 'E', 'F', 'G', 'H', 'I', 'J', 'K']; // Columnas que se fusionan verticalmente
            foreach ($colsToMerge as $col) {
                $sheet->mergeCells("{$col}12:{$col}13");
                $sheet->getStyle("{$col}12")->getAlignment()
                    ->setVertical('center')->setHorizontal('center');
                $sheet->getStyle("{$col}12")->getFont()
                    ->setName('Cambria')->setBold(true)->getColor()->setARGB('000000');
            }

            // Aplicar bordes delgados a todo el rango de encabezados
            $sheet->getStyle('A12:K13')
                ->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

            // Aplicar bordes dobles solo a los exteriores
            $sheet->getStyle('A12:K13')
                ->getBorders()->getOutline()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);

            // Títulos principales (centrados, de B1 a I4) - Se ajustan las columnas de fusión
            $sheet->mergeCells('B1:K1');
            $sheet->setCellValue('B1', 'REPUBLICA DE HONDURAS');
            $sheet->getStyle('B1')->getFont()->setName('Cambria')->setBold(true)->setSize(12);
            $sheet->getStyle('B1')->getAlignment()->setHorizontal(horizontalAlignment: 'center');

            $sheet->mergeCells('B2:K2');
            $sheet->setCellValue('B2', 'SECRETARIA DE SEGURIDAD');
            $sheet->getStyle('B2')->getFont()->setName('Cambria')->setBold(true)->setSize(12);
            $sheet->getStyle('B2')->getAlignment()->setHorizontal('center');

            $sheet->mergeCells('B3:K3');
            $sheet->setCellValue('B3', value: 'UNIVERSIDAD NACIONAL DE LA POLICIA DE HONDURAS (UNPH)');
            $sheet->getStyle('B3')->getFont()->setName('Cambria')->setBold(true)->setSize(12);
            $sheet->getStyle('B3')->getAlignment()->setHorizontal('center');

            $sheet->mergeCells('B4:K4');
            $sheet->setCellValue('B4', 'FACULTAD DE CIENCIAS SOCIALES Y DERECHO (ANAPO)');
            $sheet->getStyle('B4')->getFont()->setName('Cambria')->setBold(true)->setSize(12);
            $sheet->getStyle('B4')->getAlignment()->setHorizontal('center');

            // Licenciatura (A6:B6)
            $sheet->mergeCells('A6:B6');
            $sheet->setCellValue('A6', 'Licenciatura: ');
            $sheet->getStyle('A6')->getFont()->setName('Arial')->setBold(true)->setSize(10);
            $sheet->mergeCells("C6:E6");
            $sheet->setCellValue('C6', ($asignaturaEstudiante->asignaturadocente->asignatura->programaFormacion->nombre ?? ''));
            $sheet->getStyle('C6')->getAlignment()->setHorizontal('center');
            $sheet->getStyle('C6')->getAlignment()->setVertical('center'); // Centrar verticalmente el contenido
            $sheet->getRowDimension('6')->setRowHeight(20);
            $sheet->getStyle('C6:E6')->getFont()->setName('Cambria')->setBold(true)->setSize(10);
            // Aplicar estilo de borde grueso a las celdas combinadas
            $sheet->getStyle('C6:E6')->getBorders()->getOutline()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);

            // Asignatura (A8:B8)
            $sheet->mergeCells('A8:B8');
            $sheet->setCellValue('A8', 'Asignatura: ');
            $sheet->getStyle('A8')->getFont()->setName('Arial')->setBold(true)->setSize(10);
            $sheet->mergeCells('C8:E8');
            $sheet->setCellValue('C8', ($asignaturaEstudiante->asignaturadocente->asignatura->nombre ?? ''));
            $sheet->getStyle('C8')->getAlignment()->setHorizontal('center');
            $sheet->getStyle('C8')->getAlignment()->setVertical('center'); // Centrar verticalmente el contenido
            $sheet->getRowDimension('8')->setRowHeight(20);
            $sheet->getStyle('C8:E8')->getFont()->setName('Cambria')->setBold(true)->setSize(10);
            // Aplicar estilo de borde grueso a las celdas combinadas
            $sheet->getStyle('C8:E8')->getBorders()->getOutline()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);

            // Catedrártico (A6:B6)
            $sheet->mergeCells('A10:B10');
            $sheet->setCellValue('A10', 'Catedrático(a): ');
            $sheet->getStyle('A10')->getFont()->setName('Arial')->setBold(true)->setSize(10);
            $sheet->mergeCells('C10:E10');
            $sheet->setCellValue('C10', ($asignaturaEstudiante->asignaturadocente->docente->nombre ?? ''));
            $sheet->getStyle('C10')->getAlignment()->setHorizontal('center');
            $sheet->getStyle('C10')->getAlignment()->setVertical('center'); // Centrar verticalmente el contenido
            $sheet->getRowDimension('10')->setRowHeight(20);
            $sheet->getStyle('C10:E10')->getFont()->setName('Cambria')->setBold(true)->setSize(10);
            // Aplicar estilo de borde grueso a las celdas combinadas
            $sheet->getStyle('C10:E10')->getBorders()->getOutline()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);

            // Area (D6:F6) - Ajuste de columnas
            $sheet->setCellValue('F6', 'Área: '); // Ya no se fusiona con E6, F6 es solo para el texto "Área"
            $sheet->getStyle('F6')->getFont()->setName('Arial')->setBold(true)->setSize(10);
            $sheet->getStyle('F6')->getAlignment()->setHorizontal('right');
            $sheet->getStyle('F6')->getAlignment()->setVertical('center');

            // Combinar las celdas desde E6 hasta I6 - Ajustado a G6:K6
            $sheet->mergeCells('G6:K6');
            $sheet->getStyle('G6:K6')->getBorders()->getOutline()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
            $sheet->getStyle('G6:K6')->getFont()->setName('Cambria')->setBold(true)->setSize(10);
            $sheet->getStyle('G6:K6')->getAlignment()->setHorizontal('center')->setVertical('center');


            // Duración (D8:F8) - Ajuste de columnas
            $sheet->setCellValue('F8', 'Duración: ');
            $sheet->getStyle('F8')->getFont()->setName('Arial')->setBold(true)->setSize(10);
            $sheet->getStyle('F8')->getAlignment()->setHorizontal('right');
            $sheet->getStyle('F8')->getAlignment()->setVertical('center');

            // Combinar las celdas desde E8 hasta I8 - Ajustado a G8:K8
            $sheet->mergeCells('G8:K8');
            $sheet->getStyle('G8:K8')->getBorders()->getOutline()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
            $sheet->getStyle('G8:K8')->getFont()->setName('Cambria')->setBold(true)->setSize(10);
            $sheet->getStyle('G8:K8')->getAlignment()->setHorizontal('center')->setVertical('center');


            // Horas (E8:F8) - Ajuste de columnas
            $sheet->setCellValue('F10', 'Horas: ');
            $sheet->getStyle('F10')->getFont()->setName('Arial')->setBold(true)->setSize(10);
            $sheet->getStyle('F10')->getAlignment()->setHorizontal('right');
            $sheet->setCellValue('G10', ($asignaturaEstudiante->asignaturadocente->asignatura->horas ?? ''));
            $sheet->getStyle('G10')->getFont()->setName('Cambria')->setBold(true)->setSize(10);
            $sheet->getStyle('G10')->getAlignment()->setHorizontal('center')->setVertical('center');
            $sheet->getStyle('G10')->getBorders()->getOutline()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);

            // UV (E6:F6) - Ajuste de columnas
            $sheet->setCellValue('H10', 'UV: ');
            $sheet->getStyle('H10')->getFont()->setName('Arial')->setBold(true)->setSize(10);
            $sheet->getStyle('H10')->getAlignment()->setHorizontal('right');
            $sheet->setCellValue('I10', ($asignaturaEstudiante->asignaturadocente->asignatura->creditos ?? ''));
            $sheet->getStyle('I10')->getFont()->setName('Cambria')->setBold(true)->setSize(10);
            $sheet->getStyle('I10')->getAlignment()->setHorizontal('center')->setVertical('center');
            $sheet->getStyle('I10')->getBorders()->getOutline()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);

            // Código (E6:F6) - Ajuste de columnas
            $sheet->setCellValue('J10', 'Código: ');
            $sheet->getStyle('J10')->getFont()->setName('Arial')->setBold(true)->setSize(10);
            $sheet->getStyle('J10')->getAlignment()->setHorizontal('right');
            $sheet->setCellValue('K10', ($asignaturaEstudiante->asignaturadocente->asignatura->codigo ?? ''));
            $sheet->getStyle('K10')->getFont()->setName('Cambria')->setBold(true)->setSize(10);
            $sheet->getStyle('K10')->getAlignment()->setHorizontal('center')->setVertical('center');
            $sheet->getStyle('K10')->getBorders()->getOutline()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);

            // Asigna el ancho específico a cada columna - Se ajustan las columnas y anchos
            $sheet->getColumnDimension('A')->setWidth(5);   // Nº
            $sheet->getColumnDimension('B')->setWidth(12);  // Código
            $sheet->getColumnDimension('C')->setWidth(14);  // Nombre (parte 1 de la fusión)
            $sheet->getColumnDimension('D')->setWidth(14);  // Nombre (parte 2 de la fusión)
            $sheet->getColumnDimension('E')->setWidth(11);  // Primer Parcial
            $sheet->getColumnDimension('F')->setWidth(11);  // Segundo Parcial
            $sheet->getColumnDimension('G')->setWidth(11);  // Nota Promedio
            $sheet->getColumnDimension('H')->setWidth(11);  // Recuperación
            $sheet->getColumnDimension('I')->setWidth(11);  // Nota Promedio Recuperación
            $sheet->getColumnDimension('J')->setWidth(11);  // Nota Final
            $sheet->getColumnDimension('K')->setWidth(11);  // Calificación

            // Calcular la fila donde termina el contenido de la tabla de datos principal.
                        // Esto es crucial para posicionar el resto del contenido.
                        $lastDataRow = $sheet->getHighestRow();

                        // --- Sección de Reglamento ---
                        // El reglamento va ahora inmediatamente después de la tabla de datos principal + espacio
                        $reglamentoStartRow = $lastDataRow + 2; // Deja 3 filas de espacio después de la última fila de datos

                        // Dividir el texto del reglamento en líneas
                        $reglamentoTexto = [
                            "Reglamento de Evaluación UNPH/ Articulo 24.- Concluída la práctica de las pruebas y habiendo calificado a cada alumno y hecha la promediación, el docente",
                            "llenará de su puño y letra el cuadro de notas y calificaciones, sin alteraciones a la misma previa la autorización del respectivo Jefe de Departamento las",
                            "entregará al Departamento; de Registro y Archivo UNPH, adjuntas las Actas de las Críticas parciales, reposición y recuperación debidamente razonadas,",
                            "selladas y firmadas. Los docentes están obligados a entregar los cuadros de notas a más tardar tres (3) días hábiles después de la última crítica, del",
                            "Reglamento Sobre Procedimientos para la Evaluación de UNPH.",
                        ];

                        // Escribir cada línea en una fila separada y combinar celdas hasta la columna K
                        foreach ($reglamentoTexto as $index => $linea) {
                            $sheet->mergeCells("A{$reglamentoStartRow}:K{$reglamentoStartRow}"); // Combina desde A hasta K
                            $sheet->setCellValue("A{$reglamentoStartRow}", $linea); // Escribe el texto en la celda combinada

                            $style = $sheet->getStyle("A{$reglamentoStartRow}:K{$reglamentoStartRow}");
                            $style->getAlignment()
                                ->setHorizontal('justify') // Justificar el texto
                                ->setVertical('center')    // Centrar verticalmente
                                ->setWrapText(true);       // Ajustar texto automáticamente

                            $font = $style->getFont()->setName('Cambria')->setSize(10); // Fuente Cambria, tamaño 10

                            // Aplicar negrita solo a la primera línea
                            if ($index === 0) {
                                $font->setBold(true)->setSize(9); // Negrita y tamaño 9 para la primera línea
                            }

                            $reglamentoStartRow++; // Avanzar a la siguiente fila
                        }

                        // --- Sección de Calificaciones y Observaciones ---
                        // Esta sección ahora empieza después del reglamento + espacio
                        $startOfCalificaciones = $reglamentoStartRow + 1; // Deja 3 filas de espacio después del reglamento

                        // Encabezados del cuadro de calificaciones
                        $sheet->mergeCells("A{$startOfCalificaciones}:B{$startOfCalificaciones}"); // Combina A y B
                        $sheet->setCellValue("A{$startOfCalificaciones}", 'Calificaciones'); // Escribe en la celda combinada
                        $sheet->setCellValue("C{$startOfCalificaciones}", 'Abreviaturas');
                        $sheet->setCellValue("D{$startOfCalificaciones}", 'Notas');

                        // Datos del cuadro de calificaciones
                        $calificaciones = [
                            ['Excelente', 'EXC.', '90.00 a 100.00'],
                            ['Muy Bueno', 'M.B.', '80.00 a 89.99'],
                            ['Bueno', 'B.', '70.00 a 79.99'],
                            ['Insuficiente', 'INS.', ' 0.00 a 69.99'],
                            ['No se presento', 'NSP.', ' 0.00 a  0.00'],
                            ['Separado', 'SPD.', ' 0.00 a  0.00'],
                            ['Abandono', 'ABD.', ' 0.00 a  0.00'],
                            ['Expulsado', 'EXP.', ' 0.00 a  0.00'],
                        ];

                        $rowCalificaciones = $startOfCalificaciones + 1;

                        foreach ($calificaciones as $calif) {
                            // Combina las columnas A y B
                            $sheet->mergeCells("A{$rowCalificaciones}:B{$rowCalificaciones}");
                            $sheet->setCellValue("A{$rowCalificaciones}", $calif[0]); // Escribe el contenido en la celda combinada (A y B)

                            // Escribe los datos en las columnas C y D
                            $sheet->setCellValue("C{$rowCalificaciones}", $calif[1]); // Abreviaturas
                            $sheet->setCellValue("D{$rowCalificaciones}", $calif[2]); // Notas

                            // Centrar el texto en las celdas
                            $sheet->getStyle("A{$rowCalificaciones}:D{$rowCalificaciones}")
                                ->getAlignment()->setHorizontal('center')->setVertical('center');
                            $sheet->getStyle("A{$rowCalificaciones}:D{$rowCalificaciones}")
                                ->getFont()->setName('Cambria')->setBold(true)->setSize(10);
                            $rowCalificaciones++;
                        }

                        // Aplicar formato: negrita a encabezados del cuadro de calificaciones
                        $sheet->getStyle("A{$startOfCalificaciones}:D{$startOfCalificaciones}")->getFont()->setBold(true);

                        // Aplicar bordes delgados a todo el cuadro de calificaciones
                        $sheet->getStyle("A{$startOfCalificaciones}:D" . ($rowCalificaciones - 1))
                            ->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        // --- Sección de Observaciones ---
        // Determina la fila inicial para las Observaciones (justo al lado del cuadro de calificaciones)
        $obsStartRow = $startOfCalificaciones; // Empieza en la misma fila que el cuadro de calificaciones

        // Escribe "Observaciones:" en la columna F
        $sheet->setCellValue("F{$obsStartRow}", 'Observaciones:');
        $sheet->getStyle("F{$obsStartRow}")->getFont()->setBold(true);

        // Une las celdas F:H para el título "Observaciones"
        $sheet->mergeCells("F{$obsStartRow}:H{$obsStartRow}");
        $sheet->getStyle("F{$obsStartRow}:H{$obsStartRow}")
            ->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        // Dibuja las líneas para las observaciones (8 filas en total divididas en 4 bloques)
        for ($i = $obsStartRow + 1; $i <= $obsStartRow + 7; $i += 2) {
            // Combina las celdas verticalmente en el rango F:H
            $sheet->mergeCells("F{$i}:H" . ($i + 1));

            // Aplica bordes a las celdas combinadas
            $sheet->getStyle("F{$i}:H" . ($i + 1))
                ->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        }

        // --- Sección de Firmas ---
        // Firma del Catedrático (columnas I-K)
        // Ubica la firma del catedrático en la misma altura que la primera observación
        $signatureRow = $obsStartRow + 1;

        $sheet->mergeCells("J{$signatureRow}:K{$signatureRow}");
        $sheet->setCellValue("J{$signatureRow}", '_______________________');
        $sheet->getStyle("J{$signatureRow}")->getAlignment()->setHorizontal('center');

        $sheet->mergeCells("J" . ($signatureRow + 1) . ":K" . ($signatureRow + 1));
        $sheet->setCellValue("J" . ($signatureRow + 1), 'Firma Catedrático (a)');
        $sheet->getStyle("J" . ($signatureRow + 1))->getFont()->setBold(true);
        $sheet->getStyle("J" . ($signatureRow + 1))->getAlignment()->setHorizontal('center');

        // Firma y Sello del Jefe (a) de Área - Aproximadamente a la mitad de la sección de observaciones
        $chiefSignatureRow = $obsStartRow + 6; // A 5 filas del inicio de la sección de observaciones
        $sheet->mergeCells("J{$chiefSignatureRow}:K{$chiefSignatureRow}");
        $sheet->setCellValue("J{$chiefSignatureRow}", '_______________________');
        $sheet->getStyle("J{$chiefSignatureRow}")->getAlignment()->setHorizontal('center');

        $sheet->mergeCells("J" . ($chiefSignatureRow + 2) . ":K" . ($chiefSignatureRow + 2));
        $sheet->setCellValue("J" . ($chiefSignatureRow + 2), 'Firma y Sello del');
        $sheet->getStyle("J" . ($chiefSignatureRow + 2))->getFont()->setBold(true);
        $sheet->getStyle("J" . ($chiefSignatureRow + 2))->getAlignment()->setHorizontal('center');

        $sheet->mergeCells("J" . ($chiefSignatureRow + 3) . ":K" . ($chiefSignatureRow + 3));
        $sheet->setCellValue("J" . ($chiefSignatureRow + 3), 'Jefe (a) de Area');
        $sheet->getStyle("J" . ($chiefSignatureRow + 3))->getFont()->setBold(true);
        $sheet->getStyle("J" . ($chiefSignatureRow + 3))->getAlignment()->setHorizontal('center');

        // --- Sección de "Recibido" ---
        // Calcula la posición de "Recibido" justo después del final de la sección de observaciones
        $obsEndRow = $obsStartRow + 8; // La última fila de observaciones
        $recibidoRow = $obsEndRow + 3; // 2 filas después de las observaciones

        $sheet->setCellValue("C{$recibidoRow}", 'Recibido: ');
        $sheet->getRowDimension($recibidoRow)->setRowHeight(20);
        $sheet->getStyle("C{$recibidoRow}")->getFont()->setName('Arial')->setBold(true)->setSize(10);
        $sheet->getStyle("C{$recibidoRow}")->getAlignment()->setHorizontal('right');

        // Aplicar estilo de borde grueso a las celdas combinadas para la línea de "Recibido"
        $sheet->mergeCells("D{$recibidoRow}:G{$recibidoRow}");
        $sheet->getStyle("D{$recibidoRow}:G{$recibidoRow}")->getBorders()->getOutline()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);

                        // Ajustar la posición de "Página ______ de ______" al final de todo el contenido
                        $finalPageRow = $sheet->getHighestRow(); // Deja 2 filas de espacio después del último contenido
                        $sheet->mergeCells("A{$finalPageRow}:B{$finalPageRow}");
                        $sheet->setCellValue("A{$finalPageRow}", 'Página ______ de ______');
                        $sheet->getStyle("A{$finalPageRow}")
                            ->getFont()->setBold(true)->setSize(10)->setName('Cambria');

                }
            ];
        }


               
        
            }
        }