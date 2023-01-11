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

Use DB;
use App\AssignedNews;
use App\Company;
use App\Filters\AssignedNewsFilter;
use App\Filters\NewsFilter;
use App\News;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Crypt;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithCharts;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\Hyperlink;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

use PhpOffice\PhpSpreadsheet\Chart\Chart;
use PhpOffice\PhpSpreadsheet\Chart\DataSeries;
use PhpOffice\PhpSpreadsheet\Chart\DataSeriesValues;
use PhpOffice\PhpSpreadsheet\Chart\Legend;
use PhpOffice\PhpSpreadsheet\Chart\PlotArea;
use PhpOffice\PhpSpreadsheet\Chart\Title;
use PhpOffice\PhpSpreadsheet\Chart\Layout;


use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Events\BeforeWriting;
use Maatwebsite\Excel\Events\BeforeSheet;

use Maatwebsite\Excel\Concerns\WithCustomStartCell;
class ReportsExport implements FromQuery, WithCharts, WithMapping, WithHeadings, WithEvents, ShouldAutoSize, WithCustomStartCell
{
    use Exportable;

    private $request;
    private $graph1;
    private $themes;
    private $count_news;
    private $count_trend;
    private $count_mean;
    private $num = 0;
    private $init_row = 40;

    public function __construct($request){
        $this->request = $request;


        
        $client = Company::find($this->request->input('company'));
        $notesIds = AssignedNewsFilter::filter($this->request, ['company' => $client])
                ->pluck('news_id');

        if($this->request->input('start_date') !== null && $this->request->input('end_date') !== null)
        {
            $from = Carbon::create($this->request->input('start_date'));
            $to = Carbon::create($this->request->input('end_date'));
        }else{
            $from =  Carbon::now()->add('-10 days');
            $to =  Carbon::now();//->add(' days');
        }

        $from_d = $from->format('Y-m-d');
        $to_d = $to->format('Y-m-d');

        $this->request->merge(['start_date' => $from_d]);
        $this->request->merge(['end_date' => $to_d]);

        $tendencias = NewsFilter::filter($this->request, ['ids' => $notesIds])
            ->select('trend', DB::raw('count(*) as total'))
            ->groupBy('trend')
            ->get();

        $medios = NewsFilter::filter($this->request, ['ids' => $notesIds])
            ->select('mean_id', DB::raw('count(*) as total'))
            ->groupBy('mean_id')
            ->get();

        $where = '';

        $qry = "select themes.id, themes.name
                from assigned_news
                inner join news on assigned_news.news_id = news.id
                inner join themes on assigned_news.theme_id = themes.id
                where news.id in (" . str_replace(']', '', str_replace('[', '', $notesIds)) . ")
                AND date(news.created_at) BETWEEN '". $from->format('Y-m-d') ."' AND '" . $to->format('Y-m-d') ."'
                group by themes.id, themes.name
                order by name desc";
                
        $themes = DB::select($qry);
        $this->themes = $themes;
        
        $period = CarbonPeriod::create($from, $to);

        $fechas = array();
        $data = array();
        foreach ($period as $date) {
            $dt = $date->format('Y-m-d');
            $where = " AND date(news.created_at) = '$dt'";
            $qry = DB::select("select date(news.created_at) as dt, themes.id, themes.name, count(*) as total
                            from assigned_news
                            inner join news on assigned_news.news_id = news.id
                            inner join themes on assigned_news.theme_id = themes.id
                            where news.id in (" . str_replace(']', '', str_replace('[', '', $notesIds)) . ")
                            " . $where . "
                            group by date(news.created_at), themes.id, themes.name
                            order by date(news.created_at) desc");

            $data[$date->format('Y-m-d')] = $qry;
            $fechas[] = $date->format('Y-m-d');
        }

        
        $s = (6 + count($fechas));
        $this->init_row = ($s < 40 ? 40 : $s);


        $obj = array();
        $json = '';
        foreach ($themes as $theme)
        {
            $obj[0][0] = '';
            $obj[0][] = $theme->name;
            foreach ($fechas as $dt){
                $dat_imp = '';
                foreach ($data[$dt] as $dato_){
                    if($dato_->id == $theme->id)
                        $dat_imp = $dato_->total;
                }
                $obj[$dt][0] = $dt;
                $obj[$dt][] = (empty($dat_imp) ? 0 : $dat_imp);
            }
        }

        $this->count_news = count($obj);
        
        foreach($tendencias as $key => $itm)
        {
            $obj['trend_lbl'][] = ($itm->trend == 1 ? 'Positiva' : ($itm->trend == 2 ? 'Neutral' : 'Negativa'));
            $obj['trend'][] = $itm->total;
        }
        $this->count_trend = isset($obj['trend_lbl']) ? count($obj['trend_lbl']) : 0;

        foreach($medios as $itm)
        {
            $obj['mean_lbl'][] = $itm->mean->name;
            $obj['mean'][] = $itm->total;
        }
        $this->count_mean = isset($obj['mean_lbl']) ? count($obj['mean_lbl']) : 0;

        $this->graph1 = $obj;
    }

    public function query()
    {

        $client = Company::find($this->request->input('company'));
        $notesIds = AssignedNewsFilter::filter($this->request, ['company' => $client])
                ->pluck('news_id');

        return NewsFilter::filter($this->request, ['ids' => $notesIds]);

    }

    
    public function startCell(): string
    {
        return 'A' . $this->init_row;
    }

    public function map($note): array {

        $trend = $note->trend == 1 ? 'Positiva' : ($note->trend == 2 ? 'Neutral' : 'Negativa');
        $theme = $note->assignedNews->where('company_id', $this->request->input('company'))->where('news_id', $note->id)->first()->theme->name ?? 'N/E';
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

    public function headings(): array {
        
        return [
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

    public function charts() {

        $dt = [
            'B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AX','AY','AZ',
            'BA','BB','BC','BD','BE','BF','BG','BH','BI','BJ','BK','BL','BM','BN','BO','BP','BQ','BR','BS','BT','BU','BV','BX','BY','BZ',
            'CA','CB','CC','CD','CE','CF','CG','CH','CI','CJ','CK','CL','CM','CN','CO','CP','CQ','CR','CS','CT','CU','CV','CX','CY','CZ',
            'DA','DB','DC','DD','DE','DF','DG','DH','DI','DJ','DK','DL','DM','DN','DO','DP','DQ','DR','DS','DT','DU','DV','DX','DY','DZ'];
    
        /* CHART LINE */                    
            foreach($this->themes as $key => $itm)
                $dataSeriesLabels[] = new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_STRING, 'Worksheet!$' . $dt[$key] . '$1', null, 1);
            
            $xAxisTickValues = [
                new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_STRING, 'Worksheet!$A$2:$A$' . $this->count_news, null, 4),
            ];

            foreach($this->themes as $key => $itm)
                $dataSeriesValues[] = new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_NUMBER, 'Worksheet!$' . $dt[$key] . '$2:$' . $dt[$key] . '$' . $this->count_news, null, 4);
                
            $series = new DataSeries(
                DataSeries::TYPE_LINECHART,
                null,
                range(0, count($dataSeriesValues) - 1),
                $dataSeriesLabels,
                $xAxisTickValues,
                $dataSeriesValues
            );

            $layout = new Layout();
            $layout->setShowVal(true);
            $layout->setShowPercent(true);

            $plotArea = new PlotArea($layout, [$series]);
            $legend = new Legend(Legend::POSITION_RIGHT, null, false);
            $title = new Title('Noticias');

            $chart = new Chart(
                'chart_line',
                $title,
                $legend,
                $plotArea,
                true,
                DataSeries::EMPTY_AS_GAP,
                null,
                null
            );
            $c = ($this->init_row / 2);

            $chart->setTopLeftPosition('A' . intval($c + 1));
            $chart->setBottomRightPosition('H' . intval($this->init_row - 2));
        /* CHART LINE */   

        /* CHART2 */                    
            $dataSeriesLabels2 = [
                new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_STRING, 'Worksheet!$C$1', null, 1), // 2011
            ];

            $xAxisTickValues2 = [
                new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_STRING, 'Worksheet!$A$' . ($this->count_news + 1) . ':$C$' . ($this->count_news + 1), null, 4), // Q1 to Q4
            ];

            $dataSeriesValues2 = [
                new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_NUMBER, 'Worksheet!$A$' . ($this->count_news + 2) . ':$C$' . ($this->count_news + 2), null, 4),
            ];

            $series2 = new DataSeries(
                DataSeries::TYPE_DONUTCHART,
                null,
                range(0, count($dataSeriesValues2) - 1),
                $dataSeriesLabels2,
                $xAxisTickValues2,
                $dataSeriesValues2
            );

            $layout2 = new Layout();
            $layout2->setShowVal(true);
            $layout2->setShowPercent(true);

            $plotArea2 = new PlotArea($layout2, [$series2]);
            $legend2 = new Legend(Legend::POSITION_RIGHT, null, false);
            $title2 = new Title('Tendencias');

            $chart2 = new Chart(
                'chart2',
                $title2,
                $legend2,
                $plotArea2,
                true,
                DataSeries::EMPTY_AS_GAP,
                null,
                null
            );

            $c = ($this->init_row / 2);

            $chart2->setTopLeftPosition('A1');
            $chart2->setBottomRightPosition('C' . intval($c));
        /* CHART2 */                    

        /* CHART3 */                    
            $dataSeriesLabels1 = [
                new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_STRING, 'Worksheet!$C$1', null, 1), // 2011
	    ];
	    $countMean = ($dt[$this->count_mean] > 3) ? $dt[$this->count_mean] -2 : $dt[$this->count_mean];
            $xAxisTickValues1 = [
                new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_STRING, 'Worksheet!$A$' . ($this->count_news + 3) . ':$' . $countMean . '$' . ($this->count_news + 3), null, 4), // Q1 to Q4
            ];
            $dataSeriesValues1 = [
                new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_NUMBER, 'Worksheet!$A$' . ($this->count_news + 4) . ':$' . $countMean . '$' . ($this->count_news + 4), null, 4),
            ];
            $series1 = new DataSeries(
                DataSeries::TYPE_PIECHART,
                null,
                range(0, count($dataSeriesValues1) - 1),
                $dataSeriesLabels1,
                $xAxisTickValues1,
                $dataSeriesValues1
            );

            $layout1 = new Layout();
            $layout1->setShowVal(true);
            $layout1->setShowPercent(true);

            $plotArea1 = new PlotArea($layout1, [$series1]);
            $legend1 = new Legend(Legend::POSITION_RIGHT, null, false);
            $title1 = new Title('Medios');
            $chart1 = new Chart(
                'chart1',
                $title1,
                $legend1,
                $plotArea1,
                true,
                DataSeries::EMPTY_AS_GAP,
                null,
                null
            );

            $c = ($this->init_row / 2);

            $chart1->setTopLeftPosition('D1');
            $chart1->setBottomRightPosition('G' . intval($c));
        /* CHART3 */                    

        return [$chart, $chart2, $chart1];
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
                
                $event->sheet->getDelegate()->fromArray(
                    $this->graph1
                );

                $event->sheet->getStyle('A' . $this->init_row . ':H' . $this->init_row)->applyFromArray([
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
                $event->sheet->setAutoFilter('A' . $this->init_row . ':H' . $this->init_row);

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
                $dt = [
                    'B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AX','AY','AZ',
                    'BA','BB','BC','BD','BE','BF','BG','BH','BI','BJ','BK','BL','BM','BN','BO','BP','BQ','BR','BS','BT','BU','BV','BX','BY','BZ',
                    'CA','CB','CC','CD','CE','CF','CG','CH','CI','CJ','CK','CL','CM','CN','CO','CP','CQ','CR','CS','CT','CU','CV','CX','CY','CZ',
                    'DA','DB','DC','DD','DE','DF','DG','DH','DI','DJ','DK','DL','DM'];
                
                // format to impar row
                foreach($event->sheet->getRowIterator() as $fila) {
                    foreach ($fila->getCellIterator() as $celda) {
                        if($celda->getRow() % 2 != 0){
                            if($celda->getRow() === 1){
                                $event->sheet->getStyle("A{$celda->getRow()}:" . $dt[count($this->themes)] . "{$celda->getRow()}")->getFont()
                                    ->getColor()
                                    ->setARGB('FFFFFF');
                                continue;
                            }

                            if($fila->getRowIndex() > $this->init_row)
                                $event->sheet->getStyle("A{$celda->getRow()}:H{$celda->getRow()}")->applyFromArray([
                                    'fill' => [
                                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                                        'color' => ['rgb' => 'e9f4fa'],
                                    ],
                                ]);
                            else
                                $event->sheet->getStyle("A{$celda->getRow()}:" . $dt[count($this->themes)] . "{$celda->getRow()}")->getFont()
                                    ->getColor()
                                    ->setARGB('FFFFFF');
                                
                        }else
                            if($fila->getRowIndex() < $this->init_row)
                                $event->sheet->getStyle("A{$celda->getRow()}:" . $dt[count($this->themes)] . "{$celda->getRow()}")->getFont()
                                    ->getColor()
                                    ->setARGB('FFFFFF');
                    }
                }

                // format to impar row
                foreach($event->sheet->getRowIterator() as $fila) {
                    foreach ($fila->getCellIterator() as $celda) {
                        //if($celda->getColumn() == 'B' || $celda->getColumn() == 'D') {
                            if($celda->getRow() === 1){
                                continue;
                            }
                            $col = $celda->getColumn();
                            $num = $celda->getRow();

                            if($fila->getRowIndex() > $this->init_row)
                                $event->sheet->getRowDimension($fila->getRowIndex())->setRowHeight(160);
                            elseif($fila->getRowIndex() < $this->init_row)
                            {
                                $c = intval(80 / ($this->init_row / 10));
                                $event->sheet->getRowDimension($fila->getRowIndex())->setRowHeight($c);
                            }

                            $event->sheet->getStyle("{$col}{$num}")->getAlignment()
                                ->setVertical(Alignment::VERTICAL_CENTER)
                                ->setHorizontal(Alignment::HORIZONTAL_LEFT)
                                ->setWrapText(true);
                        //}
                    }
                }
            }
        ];
    }
}
