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

use App\Filters\AssignedNewsFilter;
use App\Filters\NewsFilter;
use App\Models\Company;
use Illuminate\Support\Facades\Crypt;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\Hyperlink;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class ReportsExportPDF implements FromCollection, /*FromQuery, WithMapping,*/ WithHeadings, WithEvents, ShouldAutoSize
{
    use Exportable;

    private $request;
    private $num = 0;

    public function __construct($request){
        $this->request = $request;
    }



    public function collection()
    {
        $client = Company::find($this->request->input('company'));
        $notesIds = AssignedNewsFilter::filter($this->request, ['company' => $client])
                ->pluck('news_id');

        $objs = NewsFilter::filter($this->request, ['ids' => $notesIds]);


        return $objs->get()->map(
           function ($note) {
                $trend = $note->trend == 1 ? 'Positiva' : ($note->trend == 2 ? 'Neutral' : 'Negativa');
                $link = route('front.detail.news', ['qry' => Crypt::encryptString("{$note->id}-{$note->title}-{$this->request->input('company')}")]);
                $this->num = $this->num + 1;
                return [
                    $this->num . "-OPE-{$note->id}",
                    $note->title . "\r\n\r\n" . $note->synthesis,
                    $note->author,
                    ($note->source->name ?? 'N/E') . "\r\n\r\n" . ($note->mean->name ?? 'N/E'),
                    $note->news_date->format('Y-m-d'),
                    $note->cost,
                    $trend . "\r\n\r\n" . $note->scope,
                    $link
                ];
            }
        );
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
            $note->title . "\r\n\r\n" . $note->synthesis,
            $note->author,
            ($note->source->name ?? 'N/E') . "\r\n\r\n" . ($note->mean->name ?? 'N/E'),
            $note->news_date->format('Y-m-d'),
            $note->cost,
            $trend . "\r\n\r\n" . $note->scope,
            $link
        ];
    }

    public function headings(): array {
        return [
            '#',
            'ID',
            'Tema',
            'Autor',
            'Fuente',
            'Fecha nota',
            'Costo',
            'Tendencia | Alcance',
            'Link'
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

                $event->sheet->getStyle('A1:H1')->applyFromArray([
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
                $event->sheet->getColumnDimension('B')
                    ->setWidth(60)
                    ->setAutoSize(false);
                $event->sheet->getColumnDimension('C')
                    ->setAutoSize(false);
                $event->sheet->getColumnDimension('D')
                    ->setAutoSize(false);
                $event->sheet->getColumnDimension('E')
                    ->setWidth(16)
                    ->setAutoSize(false);
                $event->sheet->getColumnDimension('F')
                    ->setWidth(16)
                    ->setAutoSize(false);
                $event->sheet->getStyle('F')
                    ->getNumberFormat()
                    ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);
                $event->sheet->getColumnDimension('G')
                    ->setWidth(16)
                    ->setAutoSize(false);
                $event->sheet->setAutoFilter('A1:H1');

                // hiperlink
                foreach ($event->sheet->getColumnIterator('H') as $row) {
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
                            $event->sheet->getStyle("A{$celda->getRow()}:H{$celda->getRow()}")->applyFromArray([
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
