<?php

namespace App\Exports;

use App\Models\AsignaturaEstudiante;
use App\Models\AsignaturaDocente;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use App\Models\Periodo;

class FormatoNotasExport implements FromCollection, WithHeadings, WithStyles, WithEvents
{
    protected $codigo_asignatura;
    protected $codigo_docente;
    protected $seccion_id;
    protected $mostrarTercerParcial;
    protected $periodoActivo;
    public function __construct($codigo_asignatura, $codigo_docente, $seccion_id)
    {
        $this->codigo_asignatura = $codigo_asignatura;
        $this->codigo_docente = $codigo_docente;
        $this->seccion_id = $seccion_id;
        
        $periodoActivo = Periodo::where('estado', 1)->first();
        
        if (!$periodoActivo) {
            $this->mostrarTercerParcial = false;
            return;
        }

        
        $asignaturaDocente = AsignaturaDocente::whereHas('asignatura', function($query) use ($codigo_asignatura) {
                $query->where('codigo', $codigo_asignatura);
            })
            ->whereHas('docente', function($query) use ($codigo_docente) {
                $query->where('codigo', $codigo_docente);
            })
            ->whereHas('seccion', function($query) use ($seccion_id) {
                $query->where('id', $seccion_id);
            })
            ->where('periodo_id', $periodoActivo->id) 
            ->first();
            
        $this->mostrarTercerParcial = $asignaturaDocente ? $asignaturaDocente->mostrarTercerParcial : false;
        $this->periodoActivo = $periodoActivo; 
    }
   public function headings(): array
    {
        $baseHeadings = [
            'numero' => 'Nº',
            'codigo_estudiante' => 'Nº Cuenta',
            'nombre_estudiante' => 'Nombres y Apellidos',
            'primer_parcial' => '1era. Prueba parcial 100%',
            'segundo_parcial' => '2da. Prueba parcial 100%',
            'nota_promedio' => 'Nota promedio 100%',
            'recuperacion' => 'Prueba de Recuperación 100%',
            'nota_promedio_recuperacion' => 'Nota promedio 100%',
            'nota_final' => 'Nota final',
            'calificacion' => 'Calificación',
            'asignatura_estudiante_id' => 'ID Asignatura'
        ];

        if ($this->mostrarTercerParcial) {
           
            $headings = [];
            foreach ($baseHeadings as $key => $value) {
                $headings[$key] = $value;
                if ($key === 'segundo_parcial') {
                    $headings['tercer_parcial'] = '3era. Prueba parcial 100%';
                }
            }
            return $headings;
        }

        return $baseHeadings;
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
            return 'En curso';
        } else {
            return 'Sin calificación';
        }
    }

    public function collection()
    {
        if (!isset($this->periodoActivo)) {
            return collect([]);
        }

        return AsignaturaEstudiante::whereHas('asignaturadocente', function ($query) {
            $query->whereHas('asignatura', function ($query) {
                $query->where('codigo', $this->codigo_asignatura);
            })
            ->whereHas('docente', function ($query) {
                $query->where('codigo', $this->codigo_docente);
            })
            ->whereHas('seccion', function ($query) {
                $query->where('id', $this->seccion_id);
            })
            ->where('periodo_id', $this->periodoActivo->id); 
        })
        ->where('estado', 1) 
        ->with([
            'matricula.estudiante', 
            'asignaturadocente.asignatura', 
            'asignaturadocente.periodo',
            'notas'
        ])
        ->get()
        ->map(function ($item, $index) {
            $nota = $item->notas;
            $primerparcial = $nota->primerparcial ?? 0;
            $segundoparcial = $nota->segundoparcial ?? 0;
            $tercerparcial = $nota->tercerparcial ?? 0;
            $recuperacion = $nota->recuperacion ?? '';
            $asistencia = $nota->asistencia ?? 0;
            $observacion = $nota->observacion ?? '';

            $parciales = [$primerparcial, $segundoparcial];
            if ($this->mostrarTercerParcial) {
                $parciales[] = $tercerparcial;
            }

            $parcialesFiltrados = array_filter($parciales, fn($value) => $value !== null);

            $promedio = count($parcialesFiltrados) > 0
                ? round(array_sum($parcialesFiltrados) / count($parcialesFiltrados), 0)
                : 0;

            $promedioRecuperacion = null;
            if ($recuperacion > 0 && count($parcialesFiltrados) > 0) {
                $promedioRecuperacion = count($parcialesFiltrados) > 1
                    ? round((array_sum($parcialesFiltrados) - min($parcialesFiltrados) + $recuperacion) / count($parcialesFiltrados), 0)
                    : round((array_sum($parcialesFiltrados) + $recuperacion) / 2, 0);
            }

            $notaFinal = $recuperacion > 0 && $promedioRecuperacion !== null
                ? $promedioRecuperacion
                : $promedio;

            return [
                'numero' => $index + 1,
                'codigo_estudiante' => $item->matricula->estudiante->codigo ?? 'Sin código',
                'nombre_estudiante' => $item->matricula->estudiante->nombre . ' ' . $item->matricula->estudiante->apellido ?? 'Sin Nombre',
                'primer_parcial' => $primerparcial,
                'segundo_parcial' => $segundoparcial,
                'tercer_parcial' => $this->mostrarTercerParcial ? $tercerparcial : null,
                'nota_promedio' => $promedio,
                'recuperacion' => $recuperacion,
                'nota_promedio_recuperacion' => $promedioRecuperacion,
                'nota_final' => $notaFinal,
                'calificacion' => $this->determinarCalificacion($notaFinal),
                'asignatura_estudiante_id' => $item->id ?? 'Sin ID'
            ];
        });
    }

    public function styles($sheet)
    {
        // Estilos se manejarán en registerEvents
    }
public function registerEvents(): array
    {
        if ($this->mostrarTercerParcial) {
            return [
                AfterSheet::class => function (AfterSheet $event) {
                    $sheet = $event->sheet->getDelegate();
                    $sheet->getColumnDimension('M')->setVisible(false);
                    $sheet->getColumnDimension('M')->setWidth(0);
                    $sheet->setTitle('Calificaciones');
                    $sheet->getPageSetup()
                        ->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE)
                        ->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_LETTER)
                        ->setFitToWidth(1)
                        ->setFitToHeight(0);

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
                    $sheet->setTitle('Calificaciones');
                    $sheet->getPageSetup()
                        ->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE)
                        ->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_LETTER)
                        ->setFitToWidth(1)
                        ->setFitToHeight(0);
    
                    $sheet->getPageMargins()
                        ->setTop(0.6)
                        ->setRight(0.4)
                        ->setLeft(0.9)
                        ->setBottom(0.4)
                        ->setHeader(0.4)
                        ->setFooter(0.4);
    
                    $sheet->getDefaultRowDimension()->setRowHeight(16);
                    $sheet->insertNewRowBefore(1, 12);

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
                    $endRow = $sheet->getHighestRow();
                    $spaceBetweenBlocks = 4;
                    $startRow = 14;
                    $blockNumber = 0;

                    while ($blockNumber * $recordsPerPage < $totalRecords) {
                        $startIdx = $blockNumber * $recordsPerPage;
                        $endIdx = min(($blockNumber + 1) * $recordsPerPage, $totalRecords);

                        if ($blockNumber == 0) {
                            $currentStartRow = $startRow;
                        } else {
                            $previousEndRow = $startRow + ($blockNumber * $recordsPerPage) + (($blockNumber - 1) * $spaceBetweenBlocks);
                            $currentStartRow = $previousEndRow + $spaceBetweenBlocks;

                            $sheet->insertNewRowBefore($previousEndRow, $spaceBetweenBlocks);

                            for ($i = $previousEndRow; $i < $currentStartRow; $i++) {
                                $sheet->getStyle("A{$i}:M{$i}")->getBorders()->getAllBorders()->setBorderStyle(null);
                                $sheet->getStyle("A{$i}:M{$i}")->getFill()->setFillType(null);
                                $sheet->getStyle("A{$i}:M{$i}")->getFont()->setName('Calibri')->setSize(11)->setBold(false);
                            }

                            if ($blockNumber == 1) {
                                $sheet->mergeCells("A{$previousEndRow}:B{$previousEndRow}");
                                $sheet->setCellValue("A{$previousEndRow}", 'Página ______ de ______');
                                $sheet->getStyle("A{$previousEndRow}")
                                    ->getFont()->setBold(true)->setSize(10)->setName('Cambria');
                            }

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

                            $sheet->getStyle('A' . $currentStartRow . ':M' . $currentStartRow)
                                ->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                            $sheet->getStyle('A' . $currentStartRow . ':M' . $currentStartRow)
                                ->getBorders()->getOutline()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);

                            $currentStartRow++;
                        }

                        $row = $currentStartRow;
                        $blockEndRow = $row - 1;
    
                        for ($i = $startIdx; $i < $endIdx; $i++) {
                            $dato = $datos[$i];
                            $col = 'A';
                            foreach ([$dato['numero'], $dato['codigo_estudiante'], $dato['nombre_estudiante'], $dato['primer_parcial'], $dato['segundo_parcial'], $dato['tercer_parcial'], $dato['nota_promedio'], $dato['recuperacion'], $dato['nota_promedio_recuperacion'], $dato['nota_final'], $dato['calificacion'], $dato['asignatura_estudiante_id']] as $value) {
                                if ($col === 'D') {
                                    $col = 'E';
                                }
                                $sheet->setCellValue($col . $row, $value);
                                $sheet->getStyle('E' . $row . ':M' . $row)->getAlignment()
                                    ->setVertical('center')->setHorizontal('left');
                                $sheet->getStyle('E' . $row . ':M' . $row)->getFont()
                                    ->setName('Cambria')->setBold(true)->getColor()->setARGB('000000');
                                $col++;
                            }

                            $sheet->getStyle('A' . $row . ':M' . $row)
                                ->getFont()->setName('Calibri')->setSize(11);
                            $sheet->getStyle('A' . $row . ':M' . $row)
                                ->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

                            $blockEndRow = $row;
                            $row++;
                        }

                        $rangeStart = $currentStartRow;
                        $sheet->getStyle('A' . $rangeStart . ':M' . $blockEndRow)
                            ->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
                        $sheet->getStyle('A' . $rangeStart . ':M' . $blockEndRow)
                            ->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
                        $sheet->getStyle('A' . $rangeStart . ':M' . $blockEndRow)
                            ->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);

                        $sheet->getStyle('A' . $rangeStart . ':M' . $blockEndRow)
                            ->getAlignment()->setHorizontal('center')->setVertical('center');

                        for ($r = $rangeStart; $r <= $blockEndRow; $r++) {
                            $range = "C{$r}:D{$r}";
                            if (!isset($sheet->getMergeCells()[$range])) {
                                $sheet->mergeCells($range);
                            }
                        }

                        if ($blockNumber == 0 && $blockNumber + 1 < ceil($totalRecords / $recordsPerPage)) {
                            $pageRow = $blockEndRow + 1;
                            $sheet->mergeCells("A{$pageRow}:B{$pageRow}");
                            $sheet->setCellValue("A{$pageRow}", 'Página ______ de ______');
                            $sheet->getStyle("A{$pageRow}")
                                ->getFont()->setBold(true)->setSize(10)->setName('Cambria');
                        }

                        $blockNumber++;
                    }

                    foreach (range('A', 'M') as $col) {
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

                    $sheet->getStyle('A12:M13')
                        ->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                    $sheet->getStyle('A12:M13')
                        ->getBorders()->getOutline()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);

                    $sheet->mergeCells('B1:M1');
                    $sheet->setCellValue('B1', 'REPUBLICA DE HONDURAS');
                    $sheet->getStyle('B1')->getFont()->setName('Cambria')->setBold(true)->setSize(12);
                    $sheet->getStyle('B1')->getAlignment()->setHorizontal('center');

                    $sheet->mergeCells('B2:M2');
                    $sheet->setCellValue('B2', 'SECRETARIA DE SEGURIDAD');
                    $sheet->getStyle('B2')->getFont()->setName('Cambria')->setBold(true)->setSize(12);
                    $sheet->getStyle('B2')->getAlignment()->setHorizontal('center');

                    $sheet->mergeCells('B3:M3');
                    $sheet->setCellValue('B3', 'UNIVERSIDAD NACIONAL DE LA POLICIA DE HONDURAS (UNPH)');
                    $sheet->getStyle('B3')->getFont()->setName('Cambria')->setBold(true)->setSize(12);
                    $sheet->getStyle('B3')->getAlignment()->setHorizontal('center');

                    $sheet->mergeCells('B4:M4');
                    $sheet->setCellValue('B4', 'FACULTAD DE CIENCIAS SOCIALES Y DERECHO (ANAPO)');
                    $sheet->getStyle('B4')->getFont()->setName('Cambria')->setBold(true)->setSize(12);
                    $sheet->getStyle('B4')->getAlignment()->setHorizontal('center');

                    $sheet->mergeCells('A6:B6');
                    $sheet->setCellValue('A6', 'Licenciatura: ');
                    $sheet->getStyle('A6')->getFont()->setName('Arial')->setBold(true)->setSize(10);
                    $sheet->mergeCells("C6:F6");
                    $sheet->setCellValue('C6', ($asignaturaEstudiante->asignaturadocente->asignatura->programaFormacion->nombre ?? ''));
                    $sheet->getStyle('C6')->getAlignment()->setHorizontal('center');
                    $sheet->getStyle('C6')->getAlignment()->setVertical('center');
                    $sheet->getRowDimension('6')->setRowHeight(20);
                    $sheet->getStyle('C6:F6')->getFont()->setName('Cambria')->setBold(true)->setSize(10);
                    $sheet->getStyle('C6:F6')->getBorders()->getOutline()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);

                    $sheet->mergeCells('A8:B8');
                    $sheet->setCellValue('A8', 'Asignatura: ');
                    $sheet->getStyle('A8')->getFont()->setName('Arial')->setBold(true)->setSize(10);
                    $sheet->mergeCells('C8:F8');
                    $sheet->setCellValue('C8', ($asignaturaEstudiante->asignaturadocente->asignatura->nombre ?? ''));
                    $sheet->getStyle('C8')->getAlignment()->setHorizontal('center');
                    $sheet->getStyle('C8')->getAlignment()->setVertical('center');
                    $sheet->getRowDimension('8')->setRowHeight(20);
                    $sheet->getStyle('C8:F8')->getFont()->setName('Cambria')->setBold(true)->setSize(10);
                    $sheet->getStyle('C8:F8')->getBorders()->getOutline()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);

                    $sheet->mergeCells('A10:B10');
                    $sheet->setCellValue('A10', 'Catedrático (a): ');
                    $sheet->getStyle('A10')->getFont()->setName('Arial')->setBold(true)->setSize(10);
                    $sheet->mergeCells('C10:F10');
                    $sheet->setCellValue('C10', ($asignaturaEstudiante->asignaturadocente->docente->nombre ?? ''));
                    $sheet->getStyle('C10')->getAlignment()->setHorizontal('center');
                    $sheet->getStyle('C10')->getAlignment()->setVertical('center');
                    $sheet->getRowDimension('10')->setRowHeight(20);
                    $sheet->getStyle('C10:F10')->getFont()->setName('Cambria')->setBold(true)->setSize(10);
                    $sheet->getStyle('C10:F10')->getBorders()->getOutline()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);

                    $sheet->mergeCells('G6');
                    $sheet->setCellValue('G6', 'Área: ');
                    $sheet->getStyle('G6')->getFont()->setName('Arial')->setBold(true)->setSize(10);
                    $sheet->getStyle('G6')->getAlignment()->setHorizontal('center');
                    $sheet->getStyle('G6')->getAlignment()->setVertical('center');
                    $sheet->getStyle('G6')->getAlignment()->setHorizontal('right');
                    $sheet->mergeCells('H6:M6');
                    $sheet->getStyle('H6:M6')->getBorders()->getOutline()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
                    $sheet->getStyle('H6:M6')->getFont()->setName('Cambria')->setBold(true)->setSize(10);
                    $sheet->getStyle('H6:M6')->getAlignment()->setHorizontal('center')->setVertical('center');

                    $sheet->mergeCells('G8');
                    $sheet->setCellValue('G8', 'Duración: ');
                    $sheet->getStyle('G8')->getAlignment()->setHorizontal('center');
                    $sheet->getStyle('G8')->getAlignment()->setVertical('center');
                    $sheet->getStyle('G8')->getFont()->setName('Arial')->setBold(true)->setSize(10);
                    $sheet->getStyle('G8')->getAlignment()->setHorizontal('right');
                    $sheet->mergeCells('H8:M8');
                    $sheet->getStyle('H8:M8')->getBorders()->getOutline()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
                    $sheet->getStyle('H8:M8')->getFont()->setName('Cambria')->setBold(true)->setSize(10);
                    $sheet->getStyle('H8:M8')->getAlignment()->setHorizontal('center')->setVertical('center');

                    $sheet->mergeCells('G10');
                    $sheet->setCellValue('G10', 'Horas: ');
                    $sheet->getStyle('G10')->getFont()->setName('Arial')->setBold(true)->setSize(10);
                    $sheet->setCellValue('H10', ($asignaturaEstudiante->asignaturadocente->asignatura->horas ?? ''));
                    $sheet->getStyle('G10')->getAlignment()->setHorizontal('right');
                    $sheet->getStyle('H10')->getFont()->setName('Cambria')->setBold(true)->setSize(10);
                    $sheet->getStyle('H10')->getAlignment()->setHorizontal('center');
                    $sheet->getStyle('H10')->getAlignment()->setVertical('center');
                    $sheet->getStyle('H10')->getBorders()->getOutline()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);

                    $sheet->mergeCells('I10');
                    $sheet->setCellValue('I10', 'UV: ');
                    $sheet->getStyle('I10')->getFont()->setName('Arial')->setBold(true)->setSize(10);
                    $sheet->getStyle('I10')->getAlignment()->setHorizontal('right');
                    $sheet->setCellValue('J10', ($asignaturaEstudiante->asignaturadocente->asignatura->creditos ?? ''));
                    $sheet->getStyle('J10')->getAlignment()->setHorizontal('center');
                    $sheet->getStyle('J10')->getAlignment()->setVertical('center');
                    $sheet->getStyle('J10')->getFont()->setName('Cambria')->setBold(true)->setSize(10);
                    $sheet->getStyle('J10')->getBorders()->getOutline()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);

                    $sheet->mergeCells('K10');
                    $sheet->setCellValue('K10', 'Código: ');
                    $sheet->getStyle('K10')->getFont()->setName('Arial')->setBold(true)->setSize(10);
                    $sheet->getStyle('K10')->getAlignment()->setHorizontal('right');
                    $sheet->setCellValue('L10', ($asignaturaEstudiante->asignaturadocente->asignatura->codigo ?? ''));
                    $sheet->getStyle('L10')->getAlignment()->setHorizontal('center');
                    $sheet->getStyle('L10')->getAlignment()->setVertical('center');
                    $sheet->getStyle('L10')->getFont()->setName('Cambria')->setBold(true)->setSize(10);
                    $sheet->getStyle('L10')->getBorders()->getOutline()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);

                    $sheet->getColumnDimension('A')->setWidth(5);
                    $sheet->getColumnDimension('B')->setWidth(12);
                    $sheet->getColumnDimension('C')->setWidth(14);
                    $sheet->getColumnDimension('D')->setWidth(14);
                    $sheet->getColumnDimension('E')->setWidth(11);
                    $sheet->getColumnDimension('F')->setWidth(11);
                    $sheet->getColumnDimension('G')->setWidth(11);
                    $sheet->getColumnDimension('H')->setWidth(11);
                    $sheet->getColumnDimension('I')->setWidth(11);
                    $sheet->getColumnDimension('J')->setWidth(11);
                    $sheet->getColumnDimension('K')->setWidth(11);
                    $sheet->getColumnDimension('L')->setWidth(11);
                    $sheet->getColumnDimension('M')->setWidth(11);

                    $lastRow = $sheet->getHighestRow() + 8;
                    $pageRow = $sheet->getHighestRow() + 1;
                    $sheet->mergeCells("A{$pageRow}:B{$pageRow}");
                    $sheet->setCellValue("A{$pageRow}", 'Página ______ de ______');
                    $sheet->getStyle("A{$pageRow}")
                        ->getFont()->setBold(true)->setSize(10)->setName('Cambria');

                    $sheet->mergeCells("A{$lastRow}:B{$lastRow}");
                    $sheet->setCellValue("A{$lastRow}", 'Calificaciones');
                    $sheet->setCellValue("C{$lastRow}", 'Abreviaturas');
                    $sheet->setCellValue("D{$lastRow}", 'Notas');

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
                        $sheet->mergeCells("A{$row}:B{$row}");
                        $sheet->setCellValue("A{$row}", $calif[0]);
                        $sheet->setCellValue("C{$row}", $calif[1]);
                        $sheet->setCellValue("D{$row}", $calif[2]);
                        $sheet->getStyle("A{$row}:D{$row}")
                            ->getAlignment()->setHorizontal('center')->setVertical('center');
                        $sheet->getStyle("A{$row}:D{$row}")
                            ->getFont()->setName('Cambria')->setBold(true)->setSize(10);
                        $row++;
                    }

                    $pageRow = $row + 2;
                    $reglamentoStartRow = $endRow + 4;
                    $reglamentoTexto = [
                        "Reglamento de Evaluación UNPH/ Articulo 24.- Concluída la práctica de las pruebas y habiendo calificado a cada alumno y hecha la promediación, el docente llenará de su",
                        "puño y letra el cuadro de notas y calificaciones, sin alteraciones a la misma previa la autorización del respectivo Jefe de Departamento las entregará al Departamento;",
                        "de Registro y Archivo UNPH, adjuntas las Actas de las Críticas parciales, reposición y recuperación debidamente razonadas, selladas y firmadas. Los docentes están",
                        "obligados a entregar los cuadros de notas a más tardar tres (3) días hábiles después de la última crítica, del Reglamento Sobre Procedimientos para la Evaluación de UNPH.",
                    ];

                    foreach ($reglamentoTexto as $index => $linea) {
                        $sheet->mergeCells("A{$reglamentoStartRow}:M{$reglamentoStartRow}");
                        $sheet->setCellValue("A{$reglamentoStartRow}", $linea);
                        $style = $sheet->getStyle("A{$reglamentoStartRow}:M{$reglamentoStartRow}");
                        $style->getAlignment()
                            ->setHorizontal('justify')
                            ->setVertical('center')
                            ->setWrapText(true);
                        $font = $style->getFont()->setName('Cambria')->setSize(10);
                        if ($index === 0) {
                            $font->setBold(true)->setSize(9);
                        }
                        $reglamentoStartRow++;
                    }

                    $reglamentoStartRow++;
                    $sheet->mergeCells("A{$pageRow}:B{$pageRow}");
                    $sheet->setCellValue("A{$pageRow}", 'Página ______ de ______');
                    $sheet->getStyle("A{$pageRow}")
                        ->getFont()->setBold(true)->setSize(10)->setName('Cambria');

                    $sheet->setCellValue("C{$pageRow}", 'Recibido: ');
                    $sheet->getRowDimension($pageRow)->setRowHeight(20);
                    $sheet->getStyle("C{$pageRow}")->getFont()->setName('Arial')->setBold(true)->setSize(10);
                    $sheet->getStyle("C{$pageRow}")->getAlignment()->setHorizontal('right');
                    $sheet->getStyle("C{$pageRow}")
                        ->getFont()->setBold(true)->setSize(10)->setName('Cambria');
                    $sheet->mergeCells("D{$pageRow}:G{$pageRow}");
                    $sheet->getStyle("D{$pageRow}:G{$pageRow}")->getBorders()->getOutline()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);

                    $sheet->getStyle("A{$pageRow}")
                        ->getFont()->setBold(true)->setSize(10)->setName('Cambria');
                    $sheet->getStyle("A{$lastRow}:D{$lastRow}")->getFont()->setBold(true);
                    $sheet->getStyle("A{$lastRow}:D" . ($row - 1))
                        ->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                    $sheet->getStyle("A{$lastRow}:D{$lastRow}")
                        ->getAlignment()->setHorizontal('center')->setVertical('center');

                    $obsStartRow = $lastRow;
                    $obsEndRow = $row - 1;
                    $sheet->setCellValue("F{$obsStartRow}", 'Observaciones:');
                    $sheet->getStyle("F{$obsStartRow}")->getFont()->setBold(true);
                    $sheet->getStyle("F{$obsStartRow}:I{$obsStartRow}")
                        ->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                    $sheet->mergeCells("F{$obsStartRow}:I{$obsStartRow}");

                    for ($i = $obsStartRow + 1; $i <= $obsStartRow + 8; $i += 2) {
                        $sheet->mergeCells("F{$i}:I" . ($i + 1));
                        $sheet->getStyle("F{$i}:I" . ($i + 1))
                            ->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                    }

                    $signStartRow = $obsStartRow + 2;
                    $sheet->mergeCells("K{$signStartRow}:L{$signStartRow}");
                    $sheet->setCellValue("K{$signStartRow}", '___________________');
                    $sheet->getStyle("K{$signStartRow}")->getAlignment()->setHorizontal('center');

                    $sheet->mergeCells("K" . ($signStartRow + 1) . ":L" . ($signStartRow + 1));
                    $sheet->setCellValue("K" . ($signStartRow + 1), 'Firma Catedrático (a)');
                    $sheet->getStyle("K" . ($signStartRow + 1))->getFont()->setBold(true);
                    $sheet->getStyle("K" . ($signStartRow + 1))->getAlignment()->setHorizontal('center');

                    $sheet->mergeCells("K" . ($signStartRow + 2) . ":L" . ($signStartRow + 4));

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
     } else {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $sheet->getColumnDimension('L')->setVisible(false);
                $sheet->getColumnDimension('L')->setWidth(0);
                $sheet->getColumnDimension('M')->setVisible(false);
                $sheet->getColumnDimension('M')->setWidth(0);

                $sheet->setTitle('Calificaciones');
                $sheet->getPageSetup()
                    ->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE)
                    ->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_LETTER)
                    ->setFitToWidth(1)
                    ->setFitToHeight(0);

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

                $sheet->getPageMargins()
                    ->setTop(0.6)
                    ->setRight(0.4)
                    ->setLeft(0.9)
                    ->setBottom(0.4)
                    ->setHeader(0.4)
                    ->setFooter(0.4);

                $sheet->getDefaultRowDimension()->setRowHeight(16);
                $sheet->insertNewRowBefore(1, 12);

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
                $endRow = $sheet->getHighestRow();
                $spaceBetweenBlocks = 4;
                $startRow = 14;
                $blockNumber = 0;

                while ($blockNumber * $recordsPerPage < $totalRecords) {
                    $startIdx = $blockNumber * $recordsPerPage;
                    $endIdx = min(($blockNumber + 1) * $recordsPerPage, $totalRecords);

                    if ($blockNumber == 0) {
                        $currentStartRow = $startRow;
                    } else {
                        $previousEndRow = $startRow + ($blockNumber * $recordsPerPage) + (($blockNumber - 1) * $spaceBetweenBlocks);
                        $currentStartRow = $previousEndRow + $spaceBetweenBlocks;

                        $sheet->insertNewRowBefore($previousEndRow, $spaceBetweenBlocks);

                        for ($i = $previousEndRow; $i < $currentStartRow; $i++) {
                            $sheet->getStyle("A{$i}:M{$i}")->getBorders()->getAllBorders()->setBorderStyle(null);
                            $sheet->getStyle("A{$i}:M{$i}")->getFill()->setFillType(null);
                            $sheet->getStyle("A{$i}:M{$i}")->getFont()->setName('Calibri')->setSize(11)->setBold(false);
                        }

                        if ($blockNumber == 1) {
                            $sheet->mergeCells("A{$previousEndRow}:B{$previousEndRow}");
                            $sheet->setCellValue("A{$previousEndRow}", 'Página ______ de ______');
                            $sheet->getStyle("A{$previousEndRow}")
                                ->getFont()->setBold(true)->setSize(10)->setName('Cambria');
                        }

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

                        $sheet->getStyle('A' . $currentStartRow . ':M' . $currentStartRow)
                            ->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                        $sheet->getStyle('A' . $currentStartRow . ':M' . $currentStartRow)
                            ->getBorders()->getOutline()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);

                        $currentStartRow++;
                    }

                    $row = $currentStartRow;
                    $blockEndRow = $row - 1;

                    for ($i = $startIdx; $i < $endIdx; $i++) {
                        $dato = $datos[$i];
                        $col = 'A';
                        foreach ([$dato['numero'], $dato['codigo_estudiante'], $dato['nombre_estudiante'], $dato['primer_parcial'], $dato['segundo_parcial'], $dato['nota_promedio'], $dato['recuperacion'], $dato['nota_promedio_recuperacion'], $dato['nota_final'], $dato['calificacion'],'', $dato['asignatura_estudiante_id']] as $value) {
                            if ($col === 'D') {
                                $col = 'E';
                            }
                            $sheet->setCellValue($col . $row, $value);
                            $sheet->getStyle('E' . $row . ':M' . $row)->getAlignment()
                                ->setVertical('center')->setHorizontal('left');
                            $sheet->getStyle('E' . $row . ':M' . $row)->getFont()
                                ->setName('Cambria')->setBold(true)->getColor()->setARGB('000000');
                            $col++;
                        }

                        $sheet->getStyle('A' . $row . ':M' . $row)
                            ->getFont()->setName('Calibri')->setSize(11);
                        $sheet->getStyle('A' . $row . ':M' . $row)
                            ->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

                        $blockEndRow = $row;
                        $row++;
                    }

                    $rangeStart = $currentStartRow;
                    $sheet->getStyle('A' . $rangeStart . ':M' . $blockEndRow)
                        ->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
                    $sheet->getStyle('A' . $rangeStart . ':M' . $blockEndRow)
                        ->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);
                    $sheet->getStyle('A' . $rangeStart . ':M' . $blockEndRow)
                        ->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);

                    $sheet->getStyle('A' . $rangeStart . ':M' . $blockEndRow)
                        ->getAlignment()->setHorizontal('center')->setVertical('center');

                    for ($r = $rangeStart; $r <= $blockEndRow; $r++) {
                        $range = "C{$r}:D{$r}";
                        if (!isset($sheet->getMergeCells()[$range])) {
                            $sheet->mergeCells($range);
                        }
                    }

                    if ($blockNumber == 0 && $blockNumber + 1 < ceil($totalRecords / $recordsPerPage)) {
                        $pageRow = $blockEndRow + 1;
                        $sheet->mergeCells("A{$pageRow}:B{$pageRow}");
                        $sheet->setCellValue("A{$pageRow}", 'Página ______ de ______');
                        $sheet->getStyle("A{$pageRow}")
                            ->getFont()->setBold(true)->setSize(10)->setName('Cambria');
                    }

                    $blockNumber++;
                }

                foreach (range('A', 'M') as $col) {
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

                $sheet->getStyle('A12:M13')
                    ->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle('A12:M13')
                    ->getBorders()->getOutline()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE);

                $sheet->mergeCells('B1:M1');
                $sheet->setCellValue('B1', 'REPUBLICA DE HONDURAS');
                $sheet->getStyle('B1')->getFont()->setName('Cambria')->setBold(true)->setSize(12);
                $sheet->getStyle('B1')->getAlignment()->setHorizontal('center');

                $sheet->mergeCells('B2:M2');
                $sheet->setCellValue('B2', 'SECRETARIA DE SEGURIDAD');
                $sheet->getStyle('B2')->getFont()->setName('Cambria')->setBold(true)->setSize(12);
                $sheet->getStyle('B2')->getAlignment()->setHorizontal('center');

                $sheet->mergeCells('B3:M3');
                $sheet->setCellValue('B3', 'UNIVERSIDAD NACIONAL DE LA POLICIA DE HONDURAS (UNPH)');
                $sheet->getStyle('B3')->getFont()->setName('Cambria')->setBold(true)->setSize(12);
                $sheet->getStyle('B3')->getAlignment()->setHorizontal('center');

                $sheet->mergeCells('B4:M4');
                $sheet->setCellValue('B4', 'FACULTAD DE CIENCIAS SOCIALES Y DERECHO (ANAPO)');
                $sheet->getStyle('B4')->getFont()->setName('Cambria')->setBold(true)->setSize(12);
                $sheet->getStyle('B4')->getAlignment()->setHorizontal('center');

                $sheet->mergeCells('A6:B6');
                $sheet->setCellValue('A6', 'Licenciatura: ');
                $sheet->getStyle('A6')->getFont()->setName('Arial')->setBold(true)->setSize(10);
                $sheet->mergeCells("C6:F6");
                $sheet->setCellValue('C6', ($asignaturaEstudiante->asignaturadocente->asignatura->programaFormacion->nombre ?? ''));
                $sheet->getStyle('C6')->getAlignment()->setHorizontal('center');
                $sheet->getStyle('C6')->getAlignment()->setVertical('center');
                $sheet->getRowDimension('6')->setRowHeight(20);
                $sheet->getStyle('C6:F6')->getFont()->setName('Cambria')->setBold(true)->setSize(10);
                $sheet->getStyle('C6:F6')->getBorders()->getOutline()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);

                $sheet->mergeCells('A8:B8');
                $sheet->setCellValue('A8', 'Asignatura: ');
                $sheet->getStyle('A8')->getFont()->setName('Arial')->setBold(true)->setSize(10);
                $sheet->mergeCells('C8:F8');
                $sheet->setCellValue('C8', ($asignaturaEstudiante->asignaturadocente->asignatura->nombre ?? ''));
                $sheet->getStyle('C8')->getAlignment()->setHorizontal('center');
                $sheet->getStyle('C8')->getAlignment()->setVertical('center');
                $sheet->getRowDimension('8')->setRowHeight(20);
                $sheet->getStyle('C8:F8')->getFont()->setName('Cambria')->setBold(true)->setSize(10);
                $sheet->getStyle('C8:F8')->getBorders()->getOutline()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);

                $sheet->mergeCells('A10:B10');
                $sheet->setCellValue('A10', 'Catedrático (a): ');
                $sheet->getStyle('A10')->getFont()->setName('Arial')->setBold(true)->setSize(10);
                $sheet->mergeCells('C10:F10');
                $sheet->setCellValue('C10', ($asignaturaEstudiante->asignaturadocente->docente->nombre ?? ''));
                $sheet->getStyle('C10')->getAlignment()->setHorizontal('center');
                $sheet->getStyle('C10')->getAlignment()->setVertical('center');
                $sheet->getRowDimension('10')->setRowHeight(20);
                $sheet->getStyle('C10:F10')->getFont()->setName('Cambria')->setBold(true)->setSize(10);
                $sheet->getStyle('C10:F10')->getBorders()->getOutline()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);

                $sheet->mergeCells('G6');
                $sheet->setCellValue('G6', 'Área: ');
                $sheet->getStyle('G6')->getFont()->setName('Arial')->setBold(true)->setSize(10);
                $sheet->getStyle('G6')->getAlignment()->setHorizontal('center');
                $sheet->getStyle('G6')->getAlignment()->setVertical('center');
                $sheet->getStyle('G6')->getAlignment()->setHorizontal('right');
                $sheet->mergeCells('H6:M6');
                $sheet->getStyle('H6:M6')->getBorders()->getOutline()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
                $sheet->getStyle('H6:M6')->getFont()->setName('Cambria')->setBold(true)->setSize(10);
                $sheet->getStyle('H6:M6')->getAlignment()->setHorizontal('center')->setVertical('center');

                $sheet->mergeCells('G8');
                $sheet->setCellValue('G8', 'Duración: ');
                $sheet->getStyle('G8')->getAlignment()->setHorizontal('center');
                $sheet->getStyle('G8')->getAlignment()->setVertical('center');
                $sheet->getStyle('G8')->getFont()->setName('Arial')->setBold(true)->setSize(10);
                $sheet->getStyle('G8')->getAlignment()->setHorizontal('right');
                $sheet->mergeCells('H8:M8');
                $sheet->getStyle('H8:M8')->getBorders()->getOutline()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
                $sheet->getStyle('H8:M8')->getFont()->setName('Cambria')->setBold(true)->setSize(10);
                $sheet->getStyle('H8:M8')->getAlignment()->setHorizontal('center')->setVertical('center');

                $sheet->mergeCells('G10');
                $sheet->setCellValue('G10', 'Horas: ');
                $sheet->getStyle('G10')->getFont()->setName('Arial')->setBold(true)->setSize(10);
                $sheet->setCellValue('H10', ($asignaturaEstudiante->asignaturadocente->asignatura->horas ?? ''));
                $sheet->getStyle('G10')->getAlignment()->setHorizontal('right');
                $sheet->getStyle('H10')->getFont()->setName('Cambria')->setBold(true)->setSize(10);
                $sheet->getStyle('H10')->getAlignment()->setHorizontal('center');
                $sheet->getStyle('H10')->getAlignment()->setVertical('center');
                $sheet->getStyle('H10')->getBorders()->getOutline()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);

                $sheet->mergeCells('I10');
                $sheet->setCellValue('I10', 'UV: ');
                $sheet->getStyle('I10')->getFont()->setName('Arial')->setBold(true)->setSize(10);
                $sheet->getStyle('I10')->getAlignment()->setHorizontal('right');
                $sheet->setCellValue('J10', ($asignaturaEstudiante->asignaturadocente->asignatura->creditos ?? ''));
                $sheet->getStyle('J10')->getAlignment()->setHorizontal('center');
                $sheet->getStyle('J10')->getAlignment()->setVertical('center');
                $sheet->getStyle('J10')->getFont()->setName('Cambria')->setBold(true)->setSize(10);
                $sheet->getStyle('J10')->getBorders()->getOutline()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);

                $sheet->mergeCells('K10');
                $sheet->setCellValue('K10', 'Código: ');
                $sheet->getStyle('K10')->getFont()->setName('Arial')->setBold(true)->setSize(10);
                $sheet->getStyle('K10')->getAlignment()->setHorizontal('right');
                $sheet->setCellValue('L10', ($asignaturaEstudiante->asignaturadocente->asignatura->codigo ?? ''));
                $sheet->getStyle('L10')->getAlignment()->setHorizontal('center');
                $sheet->getStyle('L10')->getAlignment()->setVertical('center');
                $sheet->getStyle('L10')->getFont()->setName('Cambria')->setBold(true)->setSize(10);
                $sheet->getStyle('L10')->getBorders()->getOutline()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);

                $sheet->getColumnDimension('A')->setWidth(5);
                $sheet->getColumnDimension('B')->setWidth(12);
                $sheet->getColumnDimension('C')->setWidth(14);
                $sheet->getColumnDimension('D')->setWidth(14);
                $sheet->getColumnDimension('E')->setWidth(11);
                $sheet->getColumnDimension('F')->setWidth(11);
                $sheet->getColumnDimension('G')->setWidth(11);
                $sheet->getColumnDimension('H')->setWidth(11);
                $sheet->getColumnDimension('I')->setWidth(11);
                $sheet->getColumnDimension('J')->setWidth(11);
                $sheet->getColumnDimension('K')->setWidth(11);
                $sheet->getColumnDimension('L')->setWidth(11);
                $sheet->getColumnDimension('M')->setWidth(11);

                $lastRow = $sheet->getHighestRow() + 8;
                $pageRow = $sheet->getHighestRow() + 1;
                $sheet->mergeCells("A{$pageRow}:B{$pageRow}");
                $sheet->setCellValue("A{$pageRow}", 'Página ______ de ______');
                $sheet->getStyle("A{$pageRow}")
                    ->getFont()->setBold(true)->setSize(10)->setName('Cambria');

                $sheet->mergeCells("A{$lastRow}:B{$lastRow}");
                $sheet->setCellValue("A{$lastRow}", 'Calificaciones');
                $sheet->setCellValue("C{$lastRow}", 'Abreviaturas');
                $sheet->setCellValue("D{$lastRow}", 'Notas');

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
                    $sheet->mergeCells("A{$row}:B{$row}");
                    $sheet->setCellValue("A{$row}", $calif[0]);
                    $sheet->setCellValue("C{$row}", $calif[1]);
                    $sheet->setCellValue("D{$row}", $calif[2]);
                    $sheet->getStyle("A{$row}:D{$row}")
                        ->getAlignment()->setHorizontal('center')->setVertical('center');
                    $sheet->getStyle("A{$row}:D{$row}")
                        ->getFont()->setName('Cambria')->setBold(true)->setSize(10);
                    $row++;
                }

                $pageRow = $row + 2;
                $reglamentoStartRow = $endRow + 4;
                $reglamentoTexto = [
                    "Reglamento de Evaluación UNPH/ Articulo 24.- Concluída la práctica de las pruebas y habiendo calificado a cada alumno y hecha la promediación, el docente llenará de su",
                    "puño y letra el cuadro de notas y calificaciones, sin alteraciones a la misma previa la autorización del respectivo Jefe de Departamento las entregará al Departamento;",
                    "de Registro y Archivo UNPH, adjuntas las Actas de las Críticas parciales, reposición y recuperación debidamente razonadas, selladas y firmadas. Los docentes están",
                    "obligados a entregar los cuadros de notas a más tardar tres (3) días hábiles después de la última crítica, del Reglamento Sobre Procedimientos para la Evaluación de UNPH.",
                ];

                foreach ($reglamentoTexto as $index => $linea) {
                    $sheet->mergeCells("A{$reglamentoStartRow}:M{$reglamentoStartRow}");
                    $sheet->setCellValue("A{$reglamentoStartRow}", $linea);
                    $style = $sheet->getStyle("A{$reglamentoStartRow}:M{$reglamentoStartRow}");
                    $style->getAlignment()
                        ->setHorizontal('justify')
                        ->setVertical('center')
                        ->setWrapText(true);
                    $font = $style->getFont()->setName('Cambria')->setSize(10);
                    if ($index === 0) {
                        $font->setBold(true)->setSize(9);
                    }
                    $reglamentoStartRow++;
                }

                $reglamentoStartRow++;
                $sheet->mergeCells("A{$pageRow}:B{$pageRow}");
                $sheet->setCellValue("A{$pageRow}", 'Página ______ de ______');
                $sheet->getStyle("A{$pageRow}")
                    ->getFont()->setBold(true)->setSize(10)->setName('Cambria');

                $sheet->setCellValue("C{$pageRow}", 'Recibido: ');
                $sheet->getRowDimension($pageRow)->setRowHeight(20);
                $sheet->getStyle("C{$pageRow}")->getFont()->setName('Arial')->setBold(true)->setSize(10);
                $sheet->getStyle("C{$pageRow}")->getAlignment()->setHorizontal('right');
                $sheet->getStyle("C{$pageRow}")
                    ->getFont()->setBold(true)->setSize(10)->setName('Cambria');
                $sheet->mergeCells("D{$pageRow}:G{$pageRow}");
                $sheet->getStyle("D{$pageRow}:G{$pageRow}")->getBorders()->getOutline()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);

                $sheet->getStyle("A{$pageRow}")
                    ->getFont()->setBold(true)->setSize(10)->setName('Cambria');
                $sheet->getStyle("A{$lastRow}:D{$lastRow}")->getFont()->setBold(true);
                $sheet->getStyle("A{$lastRow}:D" . ($row - 1))
                    ->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->getStyle("A{$lastRow}:D{$lastRow}")
                    ->getAlignment()->setHorizontal('center')->setVertical('center');

                $obsStartRow = $lastRow;
                $obsEndRow = $row - 1;
                $sheet->setCellValue("F{$obsStartRow}", 'Observaciones:');
                $sheet->getStyle("F{$obsStartRow}")->getFont()->setBold(true);
                $sheet->getStyle("F{$obsStartRow}:I{$obsStartRow}")
                    ->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $sheet->mergeCells("F{$obsStartRow}:I{$obsStartRow}");

                for ($i = $obsStartRow + 1; $i <= $obsStartRow + 8; $i += 2) {
                    $sheet->mergeCells("F{$i}:I" . ($i + 1));
                    $sheet->getStyle("F{$i}:I" . ($i + 1))
                        ->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                }

                $signStartRow = $obsStartRow + 2;
                $sheet->mergeCells("K{$signStartRow}:L{$signStartRow}");
                $sheet->setCellValue("K{$signStartRow}", '___________________');
                $sheet->getStyle("K{$signStartRow}")->getAlignment()->setHorizontal('center');

                $sheet->mergeCells("K" . ($signStartRow + 1) . ":L" . ($signStartRow + 1));
                $sheet->setCellValue("K" . ($signStartRow + 1), 'Firma Catedrático (a)');
                $sheet->getStyle("K" . ($signStartRow + 1))->getFont()->setBold(true);
                $sheet->getStyle("K" . ($signStartRow + 1))->getAlignment()->setHorizontal('center');

                $sheet->mergeCells("K" . ($signStartRow + 2) . ":L" . ($signStartRow + 4));

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
}