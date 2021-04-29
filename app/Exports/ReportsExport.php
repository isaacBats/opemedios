<?php
/**
  *-------------------------------------------------------------------------------------
  * Developer Information
  *-------------------------------------------------------------------------------------
  * @author Isaac Daniel Batista <daniel@danielbat.com>
  * @link https://danielbat.com Web Autor's site
  * @see https://twitter.com/codeisaac <@codeisaac>
  * @copyright 2021
  * @version 1.0.0
  * @package App\
  * Type: Export
  * Description: Description
  *
  * For the full copyright and license information, please view the LICENSE
  * file that was distributed with this source code.
  */

namespace App\Exports;

use App\AssignedNews;
use App\News;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Crypt;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\Hyperlink;
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
        $link = route('front.detail.news', ['qry' => Crypt::encryptString("{$note->id}-{$note->title}-{$this->request->input('company')}")]);

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
            number_decimal($note->scope),
            $link
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
            'Alcance',
            'Link'
        ];
    }

    public function registerEvents(): array {
        return [
            AfterSheet::class => function(AfterSheet $event){
                $event->sheet->getStyle('A1:P1')->applyFromArray([
                    'font' => [
                        'bold' => true
                    ]
                ]);
                $event->sheet->setAutoFilter('A1:P1');

                // hiperlink 
                foreach ($event->sheet->getColumnIterator('P') as $row) {
                    foreach ($row->getCellIterator() as $cell) {
                        if (str_contains($cell->getValue(), '://')) {
                            $cell->setHyperlink(new Hyperlink($cell->getValue()));
                            $cell->setValue('Ir a la nota');
                            // Upd: Link styling added
                            $event->sheet->getStyle($cell->getCoordinate())->applyFromArray([
                               'font' => [
                                   'color' => ['rgb' => '0000FF'],
                                   'underline' => 'single'
                               ]
                           ]);
                        }
                    }
                }   
            }  
        ];
    }
}
