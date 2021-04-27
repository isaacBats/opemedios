<?php

namespace App\Exports;

use App\AssignedNews;
use App\News;
use Carbon\Carbon;
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
    
    private $request;

    public function __construct($request){
        $this->request = $request;
    }

    public function query()
    {
        $notesIds = AssignedNews::query()->where('company_id', $this->request->input('company'))
            ->when($this->request->input('theme_id') != null, function($q) {
                return $q->where('theme_id', $this->request->input('theme_id'));
            })->pluck('news_id');

        return News::query()->whereIn('id', $notesIds)
            ->when($this->request->input('sector') != null, function($q) {
                return $q->where('sector_id', $this->request->input('sector'));
            })
            ->when($this->request->input('genre') != null, function($q) {
                return $q->where('genre_id', $this->request->input('genre'));
            })
            ->when($this->request->input('mean') != null, function($q) {
                return $q->where('mean_id', $this->request->input('mean'));
            })
            ->when($this->request->input('source_id') != null, function($q) {
                return $q->where('source_id', $this->request->input('source_id'));
            })
            ->when(($this->request->input('fstart') != null && $this->request->input('fend') != null), function($q){
                $from = Carbon::create($this->request->input('fstart'));
                $to = Carbon::create($this->request->input('fend'));
                return $q->whereBetween('news_date', [$from, $to]);
            })
            ->when(($this->request->input('fstart') != null && $this->request->input('fend') == null), function($q){
                return $q->whereDate('news_date', Carbon::create($this->request->input('fstart')));
            });
    }

    public function map($note): array {
        
        $trend = $note->trend == 1 ? 'Positiva' : ($note->trend == 2 ? 'Neutral' : 'Negativa');
        $theme = $note->assignedNews->where('company_id', $this->request->input('company'))->where('news_id', $note->id)->first()->theme->name;

        return [
            "OPE-{$note->id}",
            $note->title,
            $theme,
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
            'Tema',
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
                $event->sheet->getStyle('A1:O1')->applyFromArray([
                    'font' => [
                        'bold' => true
                    ]
                ],
                $event->sheet->setAutoFilter('A1:O1'),
                // insert hiperlink
                // $event->sheet->getCell('A2')->getHiperlink()->setUrl(
                //     route('front.detail.news', ['qry' => \Illuminate\Support\Facades\Crypt::encryptString("{$note->id}-{$note->title}-{$this->request->input('company')}")])
                // ),
            );
            }  
        ];
    }
}
