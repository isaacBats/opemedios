<?php

namespace App\Exports;

use App\AssignedNews;
use App\News;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ReportsExport implements FromQuery, ShouldAutoSize, WithMapping, WithHeadings, WithEvents
{
    use Exportable;
    
    private $companyId;

    public function __construct($companyId){
        $this->companyId = $companyId;
    }

    public function query()
    {
        $notesIds = AssignedNews::where('company_id', $this->companyId)->pluck('news_id');
        return News::whereIn('id', $notesIds);
    }

    public function map($note): array {
        
        $trend = $note->trend == 1 ? 'Positiva' : ($note->trend == 2 ? 'Neutral' : 'Negativa');

        return [
            "OPE-{$note->id}",
            $note->title,
            $note->synthesis,
            $note->author,
            $note->authorType->description,
            $note->sector->description,
            $note->genre->description,
            $note->source->name,
            $note->section->name,
            $note->mean->name,
            $note->news_date->format('Y-m-d'),
            number_coin($note->cost),
            $trend,
            number_decimal($note->scope)
        ];
    }

    public function headings(): array {
        return [
            '#',
            'Título',
            'Síntesis',
            'Autor',
            'Tipo de autor',
            'Sector',
            'Género',
            'Fuente',
            'Sección',
            'Medio',
            'Fecha nota',
            'Costo',
            'Tendencia',
            'Alcance'
        ];
    }

    public function registerEvents(): array {
        return [
            AfterSheet::class => function(AfterSheet $event){
                $event->sheet->getStyle('A1:N1')->applyFromArray([
                    'font' => [
                        'bold' => true
                    ]
                ],
                $event->sheet->setAutoFilter('A1:N1'),
            );
            }  
        ];
    }
}
