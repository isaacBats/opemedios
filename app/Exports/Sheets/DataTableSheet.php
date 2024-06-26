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

use App\Models\SocialNetworks;
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
        $theme = $note->assignedNews->where('company_id', $this->company->id)->where('news_id', $note->id)->first()->theme->name ?? 'N/E';
        $link = route('front.detail.news', ['qry' => Crypt::encryptString("{$note->id}-{$this->company->id}")]);

        $str_src = '';
        if($note->mean_id == 5 && !is_null($note->social_network_id)){
            $social_network = SocialNetworks::find($note->social_network_id);
            $str_src = $social_network->name;
        }

        $this->num = $this->num + 1;

        $synthesis = json_encode($note->synthesis);
        
        return [
            $this->num . "-OPE-{$note->id}",
            $note->title . "|#-#|" . $link,
            $synthesis,
            // $note->author,
            ($note->source->name ?? 'N/E'),
            $note->news_date->format('Y-m-d'),
            $note->cost,
            $trend,
            ($note->mean->name ?? 'N/E') . (!empty($str_src) ? ' | ' . $str_src : ''),
            $note->scope,
        ];
    }

    public function headings(): array
    {
        return [
            'ID',
            'Título',
            'Síntesis',
            // 'Autor',
            'Fuente',
            'Fecha nota',
            'Costo',
            'Tendencia',
            'Medio',
            'Alcance',
        ];
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

                // $event->sheet->getDelegate()->fromArray(
                //     $this->graph1
                // );

                $event->sheet->getStyle("A{$this->init_row}:I{$this->init_row}")->applyFromArray([
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
                $event->sheet->getColumnDimension('A')->setAutoSize(false);
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
                // $event->sheet->getColumnDimension('J')
                //     ->setWidth(14)
                //     ->setAutoSize(false);

                $event->sheet->getStyle('F')
                    ->getNumberFormat()
                    ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_USD_SIMPLE);

                $event->sheet->setAutoFilter('A' . $this->init_row . ':I' . $this->init_row);

                // hiperlink
                foreach ($event->sheet->getColumnIterator('B') as $row) {
                    foreach ($row->getCellIterator() as $cell) {
                        if (str_contains($cell->getValue(), '://')) {
                            $nota = explode('|#-#|', $cell->getValue());
                            
                            
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
                            $event->sheet->getStyle("A{$celda->getRow()}:I{$celda->getRow()}")->applyFromArray([
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

                foreach ($event->sheet->getColumnIterator('C') as $row) {
                    foreach ($row->getCellIterator() as $cell) {
                        if ($cell->getRow() === 1) {
                            continue;
                        }
                        if ($celda->getColumn() == 'C') {
                            $cell->setValue(json_decode($cell->getValue()));
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