<?php
/**
  *-------------------------------------------------------------------------------------
  * Developer Information
  *-------------------------------------------------------------------------------------
  * @author Isaac Daniel Batista <daniel@danielbat.com>
  * @link https://danielbat.com Web Autor's site
  * @see https://twitter.com/codeisaac <@codeisaac>
  * @copyright 2023
  * @version 1.0.0
  * @package App\Export\Sheets
  * Type: Sheet
  * Description: Class to generate all data
  *
  * For the full copyright and license information, please view the LICENSE
  * file that was distributed with this source code.
  */
 
namespace App\Exports\Sheets;

use Carbon\{Carbon, CarbonPeriod};
use Maatwebsite\Excel\Concerns\{
    FromView,
    WithEvents
};
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\Hyperlink;
use PhpOffice\PhpSpreadsheet\Style\Alignment;


class DataTableSheet implements FromView, WithEvents
{
    private $notes;
    private $themes_group;
    private $company;

    public function __construct($notes, $company, $themes_group)
    {
        $this->notes = $notes;
        $this->themes_group = $themes_group;
        $this->company = $company;
    }
    
    public function view(): View
    {
        return view('exports.notes', [
            'notes' => $this->notes,
            'company' => $this->company,
            'themes_group' => $this->themes_group
        ]);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_LEGAL);
                $event->sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
                $event->sheet->getPageMargins()->setTop(0.1);
                $event->sheet->getPageMargins()->setRight(0.1);
                $event->sheet->getPageMargins()->setLeft(0.1);
                $event->sheet->getPageMargins()->setBottom(0.1);

                $event->sheet->getColumnDimension('A')
                    ->setAutoSize(false);
                $event->sheet->getColumnDimension('B')
                    ->setWidth(30)
                    ->setAutoSize(false);
                $event->sheet->getColumnDimension('C')
                    ->setWidth(60)
                    ->setAutoSize(false);
                $event->sheet->getColumnDimension('D')
                    ->setWidth(16)
                    ->setAutoSize(false);
                $event->sheet->getColumnDimension('E')
                    ->setWidth(16)
                    ->setAutoSize(false);
                $event->sheet->getColumnDimension('F')
                    ->setWidth(14)
                    ->setAutoSize(false);
                $event->sheet->getColumnDimension('G')
                    ->setWidth(14)
                    ->setAutoSize(false);
                $event->sheet->getColumnDimension('H')
                    ->setWidth(14)
                    ->setAutoSize(false);
                $event->sheet->getColumnDimension('I')
                    ->setWidth(14)
                    ->setAutoSize(false);
                $event->sheet->getColumnDimension('J')
                    ->setWidth(14)
                    ->setAutoSize(false);

                $event->sheet->getStyle('G')
                    ->getNumberFormat()
                    ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);

                // hiperlink
                foreach ($event->sheet->getColumnIterator('A') as $row) {
                    foreach ($row->getCellIterator() as $cell) {
                        if (str_contains($cell->getValue(), '://')) {
                            $nota = explode('|', $cell->getValue());
                            $link = route('front.detail.news', ['qry' => '']);
                            //$cell->setHyperlink(new Hyperlink(isset($nota[1]) ? $nota[1] : ''));
                            $cnt = (count($nota) < 2) ? $link : $nota[1];
                            $cell->setHyperlink(new Hyperlink($cnt));
                            $cell->setValue($nota[0]);
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
                foreach ($event->sheet->getRowIterator() as $fila) {
                    foreach ($fila->getCellIterator() as $celda) {
                        if ($celda->getRow() % 2 != 0) {
                            if ($celda->getRow() === 1) {
                                continue;
                            }
                            $event->sheet->getStyle("A{$celda->getRow()}:J{$celda->getRow()}")->applyFromArray([
                                'fill' => [
                                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                                    'color' => ['rgb' => 'e9f4fa'],
                                ],
                            ]);
                        }
                    }
                }

                foreach ($event->sheet->getRowIterator() as $fila) {
                    foreach ($fila->getCellIterator() as $celda) {
                        if ($celda->getColumn() == 'C' || $celda->getColumn() == 'E') {
                            if ($celda->getRow() === 1) {
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

                foreach ($event->sheet->getRowIterator() as $fila) {
                    foreach ($fila->getCellIterator() as $celda) {
                        $cell = clone $celda;
                        if ($celda->getColumn() == 'A'){
                            if (str_contains($cell->getValue(), 'theme|')) {
                                $nota = explode('|', $cell->getValue());
                                $cell->setValue($nota[1]);
                                $event->sheet->getRowDimension($fila->getRowIndex())->setRowHeight(20);
                                $event->sheet->getStyle($cell->getCoordinate())->applyFromArray([
                                    'font' => [
                                        'bold' => true,
                                        'color' => ['rgb' => 'EEEEEE'],
                                    ],
                                    'alignment' => [
                                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                                    ],
                                    'fill' => [
                                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                                        'color' => ['rgb' => '2474ac'],
                                    ],
                                ]);
                            }
                        }

                        if (str_contains($cell->getValue(), 'colhead|')) {
                            $nota = explode('|', $cell->getValue());
                            $cell->setValue($nota[1]);
                            $event->sheet->getRowDimension($fila->getRowIndex())->setRowHeight(20);
                            $event->sheet->getStyle($cell->getCoordinate())->applyFromArray([
                                'font' => [
                                    'bold' => true,
                                    'color' => ['rgb' => 'EEEEEE'],
                                ],
                                'alignment' => [
                                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                                ],
                                'fill' => [
                                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                                    'color' => ['rgb' => '52aded'],
                                ],
                            ]);
                        }
                    }
                }
            }
        ];
    }

}