<?php

namespace App\Exports;

use App\Models\Nota;
use App\Models\AsignaturaEstudiante;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class ActualizarNotasExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize, WithEvents
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
            'Código',
            'Nombre',
            'Apellido',
            'Nombre Asignatura',
            'Primer Parcial',
            'Segundo Parcial',
            'Tercer Parcial',
            'Asistencia',
            'Recuperación',
            'Observación',
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
                    'nombre_estudiante' => $item->matricula->estudiante->nombre ?? 'Sin nombre',
                    'apellido_estudiante' => $item->matricula->estudiante->apellido ?? 'Sin apellido',
                    'nombre_asignatura' => $item->asignaturadocente->asignatura->nombre ?? 'Sin nombre',
                    'primer_parcial' => $nota->primerparcial ?? 0,
                    'segundo_parcial' => $nota->segundoparcial ?? 0,
                    'tercer_parcial' => $nota->tercerparcial ?? 0,
                    'asistencia' => $nota->asistencia ?? 0,
                    'recuperacion' => $nota->recuperacion ?? 0,
                    'observacion' => $nota->observacion ?? ' ',
                ];
            });
    }

    public function styles($sheet)
    {
        $sheet->getStyle('A1:K' . $sheet->getHighestRow())
            ->getFont()
            ->setName('Times New Roman')
            ->setSize(11);

        $sheet->getStyle('A1:K1')->applyFromArray([
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

        $sheet->getStyle('A2:K' . $sheet->getHighestRow())->applyFromArray([
            'fill' => [
                'fillType' => 'solid',
                'startColor' => ['argb' => 'D9EAF7'],
            ],
        ]);

        $sheet->getStyle('A1:K' . $sheet->getHighestRow())
            ->getBorders()->getAllBorders()
            ->setBorderStyle('thin');

        $sheet->getStyle('A1:K' . $sheet->getHighestRow())
            ->getAlignment()->setHorizontal('center');
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Insertar filas para el encabezado (5 filas)
                $sheet->insertNewRowBefore(1, 5);

                // Logo en A1
                $drawing = new Drawing();
                $drawing->setName('Logo');
                $drawing->setDescription('Logo');
                $drawing->setPath(public_path('Logo/LOGO.png'));
                $drawing->setHeight(90);
                $drawing->setCoordinates('D1');
                $drawing->setOffsetX(50);
                $drawing->setOffsetY(10);
                $drawing->setWorksheet($sheet);

                // Fondo para el encabezado (filas 1 a 5)
                $sheet->getStyle('A1:K5')->applyFromArray([
                    'fill' => [
                        'fillType' => 'solid',
                        'startColor' => ['argb' => 'D9EAF7'],
                    ],
                ]);

                // Títulos principales (centrados, de B1 a K4)
                $sheet->mergeCells('B1:K1');
                $sheet->setCellValue('B1', 'REPUBLICA DE HONDURAS');
                $sheet->getStyle('B1')->getFont()->setBold(true)->setSize(16);
                $sheet->getStyle('B1')->getAlignment()->setHorizontal('center');

                $sheet->mergeCells('B2:K2');
                $sheet->setCellValue('B2', 'SECRETARIA DE SEGURIDAD');
                $sheet->getStyle('B2')->getFont()->setBold(true)->setSize(16);
                $sheet->getStyle('B2')->getAlignment()->setHorizontal('center');

                $sheet->mergeCells('B3:K3');
                $sheet->setCellValue('B3', 'UNIVERSIDAD NACIONAL DE LA POLICIA DE HONDURAS (UNPH)');
                $sheet->getStyle('B3')->getFont()->setBold(true)->setSize(16);
                $sheet->getStyle('B3')->getAlignment()->setHorizontal('center');

                $sheet->mergeCells('B4:K4');
                $sheet->setCellValue('B4', 'FACULTAD DE CIENCIAS SOCIALES Y DERECHO (ANAPO)');
                $sheet->getStyle('B4')->getFont()->setBold(true)->setSize(16);
                $sheet->getStyle('B4')->getAlignment()->setHorizontal('center');

                // Subtítulo (B5:K5)
                $sheet->mergeCells('B5:K5');
                $sheet->setCellValue('B5', 'Cuadro de Notas Consolidado');
                $sheet->getStyle('B5')->getFont()->setSize(13);
                $sheet->getStyle('B5')->getAlignment()->setHorizontal('center');

                // Ajustar autofiltro y autosize para las columnas de datos
                $sheet->setAutoFilter('A7:K7');
                foreach (range('A', 'K') as $column) {
                    $sheet->getColumnDimension($column)->setWidth(5);
                }
            }
        ];
    }
}