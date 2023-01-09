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

use Illuminate\Support\Facades\Crypt;
use Carbon\{Carbon, CarbonPeriod};
use Maatwebsite\Excel\Concerns\{
    FromQuery,
    ShouldAutoSize,
    WithEvents,
    WithHeadings,
    WithMapping,
    WithTitle
};
use Maatwebsite\Excel\Concerns\{ RegistersEventListeners, WithCustomStartCell };
use Maatwebsite\Excel\Events\{ BeforeExport, BeforeWriting, BeforeSheet };
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\Hyperlink;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\Alignment;


class DataTableSheet implements
    FromQuery,
    ShouldAutoSize,
    WithEvents,
    WithHeadings,
    WithMapping,
    WithTitle
{
    private $notesIds;
    private $company;
    private $num = 0;
    private $init_row = 1;

    public function __construct($notes, $company)
    {
        $this->notes = $notes;
        $this->company = $company;
    }
    
    public function query()
    {
        return $this->notes;
    }

    public function map($note): array
    {

        $trend = $note->trend == 1 ? 'Positiva' : ($note->trend == 2 ? 'Neutral' : 'Negativa');
        $theme = $note->assignedNews->where('company_id', $this->company->id)
            ->where('news_id', $note->id)->first()->theme->name ?? 'N/E';
        $link = route('front.detail.news', [
            'qry' => Crypt::encryptString("{$note->id}-{$note->title}-{$this->company->id}")
        ]);
        
        $this->num = $this->num + 1;

        return [
            $this->num,
            "OPE-{$note->id}",
            $note->title,
            $theme,
            $note->synthesis,
            $note->author,
            $note->authorType->description ?? 'N/E',
            $note->genre->description ?? 'N/E',
            $note->source->name ?? 'N/E',
            $note->section->name ?? 'N/E',
            $note->mean->name ?? 'N/E',
            $note->news_date->format('Y-m-d'),
            $note->cost,
            $trend,
            $note->scope,
            $link
        ];
    }

    public function headings(): array
    {
        
        return [
            '#',
            'ID',
            'Título',
            'Tema',
            'Síntesis',
            'Autor',
            'Tipo de autor',
            'Género',
            'Fuente',
            'Seccion',
            'Medio',
            'Fecha nota',
            'Costo',
            'Tendencia',
            'Alcance',
            'Link'
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getStyle("A{$this->init_row}:P{$this->init_row}")->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'color' => ['rgb' => 'EEEEEE'],
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'color' => ['rgb' => '2474ac'],
                    ],
                ]);
                $event->sheet->getColumnDimension('C')
                    ->setWidth(40)
                    ->setAutoSize(false);
                $event->sheet->getColumnDimension('E')
                    ->setWidth(120)
                    ->setAutoSize(false);
                $event->sheet->getStyle('M')->getNumberFormat()
                    ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                $event->sheet->getStyle('O')->getNumberFormat()
                    ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                $event->sheet->setAutoFilter("A{$this->init_row}:P{$this->init_row}");

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

                // format to impar row
                foreach ($event->sheet->getRowIterator() as $fila) {
                    foreach ($fila->getCellIterator() as $celda) {
                        if ($celda->getRow() % 2 != 0) {
                            if ($celda->getRow() === 1) {
                                continue;
                            }
                            $event->sheet->getStyle("A{$celda->getRow()}:P{$celda->getRow()}")->applyFromArray([
                                'fill' => [
                                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                                    'color' => ['rgb' => 'e9f4fa'],
                                ],
                            ]);
                        }
                    }
                }

                // format to impar row
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
            }
        ];
    }

     /**
     * @return string
     */
    public function title(): string
    {
        return 'Datos';
    }
}
