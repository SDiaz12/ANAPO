<?php

namespace App\Exports;

use App\Models\AsignaturaEstudiante;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class FormatoNotasExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize, WithEvents
{
    protected $codigo_asignatura;
    protected $codigo_docente;

    public function __construct($codigo_asignatura, $codigo_docente)
    {
        $this->codigo_asignatura = $codigo_asignatura;
        $this->codigo_docente = $codigo_docente;
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
                $sheet = $event->sheet;

                
                $sheet->getDelegate()->setAutoFilter('A1:K1');

                
                foreach (range('A', 'K') as $column) {
                    $sheet->getDelegate()->getColumnDimension($column)->setAutoSize(true);
                }
            }
        ];
    }
}
