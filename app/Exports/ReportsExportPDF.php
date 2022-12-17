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
use App\Company;
use App\Filters\AssignedNewsFilter;
use App\Filters\NewsFilter;
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
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class ReportsExportPDF implements FromQuery, WithMapping, WithHeadings, WithEvents, ShouldAutoSize
{
    use Exportable;

    private $request;

    public function __construct($request){
        $this->request = $request;
    }

    public function query()
    {
        $client = Company::find($this->request->input('company'));
        $notesIds = AssignedNewsFilter::filter($this->request, ['company' => $client])
                ->pluck('news_id');

        return NewsFilter::filter($this->request, ['ids' => $notesIds]);

    }

    public function map($note): array {

        $trend = $note->trend == 1 ? 'Positiva' : ($note->trend == 2 ? 'Neutral' : 'Negativa');
        $theme = $note->assignedNews->where('company_id', $this->request->input('company'))->where('news_id', $note->id)->first()->theme->name ?? 'N/E';
        $link = route('front.detail.news', ['qry' => Crypt::encryptString("{$note->id}-{$note->title}-{$this->request->input('company')}")]);

        return [
            "OPE-{$note->id}",
            $note->title . "\r\n\r\n" . $theme . "\r\n\r\n" . $note->synthesis,// . "\r\n\r\n\r\n" . $link,
            //$theme,
            //$note->synthesis,
            $note->author . "\r\n\r\n" . ($note->authorType->description ?? 'N/E'),
            ($note->genre->description ?? 'N/E') . "\r\n\r\n" . ($note->source->name ?? 'N/E') . "\r\n\r\n" . ($note->section->name ?? 'N/E') . "\r\n\r\n" . ($note->mean->name ?? 'N/E'),
            $note->news_date->format('Y-m-d'),
            $note->cost,
            $trend . "\r\n\r\n" . $note->scope
        ];
    }

    public function headings(): array {
        return [
            '#',
            'Título|Tema|Síntesis',
            //'Tema',
            //'Síntesis',
            'Autor|Tipo de autor',
            //'Tipo de autor',
            'Género|Fuente|Sección|Medio',
            //'Fuente',
            //'Sección',
            //'Medio',
            'Fecha nota',
            'Costo',
            'Tendencia|Alcance',
            //'Alcance',
            //'Link'
        ];
    }

    public function registerEvents(): array {
        return [
            AfterSheet::class => function(AfterSheet $event){
                $event->sheet->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_LEGAL);
                $event->sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
                $event->sheet->getPageMargins()->setTop(0.1); 
                $event->sheet->getPageMargins()->setRight(0.1); 
                $event->sheet->getPageMargins()->setLeft(0.1); 
                $event->sheet->getPageMargins()->setBottom(0.1); 

                $event->sheet->getStyle('A1:G1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'color' => ['rgb' => 'EEEEEE'],
                    ],
                    'alignment' => [
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    ],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'color' => ['rgb' => '2474ac'],
                    ],
                ]);
                $event->sheet->getColumnDimension('A')->setAutoSize(false);
                $event->sheet->getColumnDimension('E')->setAutoSize(false);
                $event->sheet->getColumnDimension('F')->setAutoSize(false);
                $event->sheet->getColumnDimension('G')->setAutoSize(false);

                $event->sheet->getColumnDimension('C')
                    //->setWidth(10)
                    ->setAutoSize(false);
                $event->sheet->getColumnDimension('B')
                    ->setWidth(100)
                    ->setAutoSize(false);
                $event->sheet->getColumnDimension('D')
                    //->setWidth(15)
                    ->setAutoSize(false);
                $event->sheet->getStyle('F')->getNumberFormat()
                    ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                // $event->sheet->getStyle('N')->getNumberFormat()
                //     ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                $event->sheet->setAutoFilter('A1:G1');

                // hiperlink
                foreach ($event->sheet->getColumnIterator('G') as $row) {
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

                // format to impar row
                foreach($event->sheet->getRowIterator() as $fila) {
                    foreach ($fila->getCellIterator() as $celda) {
                        if($celda->getRow() % 2 != 0){
                            if($celda->getRow() === 1){
                                continue;
                            }
                            $event->sheet->getStyle("A{$celda->getRow()}:G{$celda->getRow()}")->applyFromArray([
                                'fill' => [
                                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                                    'color' => ['rgb' => 'e9f4fa'],
                                ],
                            ]);
                        }
                    }
                }

                // format to impar row
                foreach($event->sheet->getRowIterator() as $fila) {
                    foreach ($fila->getCellIterator() as $celda) {
                        if($celda->getColumn() == 'B' || $celda->getColumn() == 'D') {
                            if($celda->getRow() === 1){
                                continue;
                            }
                            $col = $celda->getColumn();
                            $num = $celda->getRow();

                            $event->sheet->getRowDimension($fila->getRowIndex())->setRowHeight(80);

                            $event->sheet->getStyle("{$col}{$num}")->getAlignment()
                                ->setVertical(Alignment::VERTICAL_CENTER)
                                ->setHorizontal(Alignment::HORIZONTAL_LEFT)
                                ->setWrapText(true);
                        }
                    }
                }
            }
        ];
    }
}
