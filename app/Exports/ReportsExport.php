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

        //$notesIds = AssignedNewsFilter::filter($this->request, ['company' => $client])->pluck('news_id');
        //$notesIdsArray = AssignedNewsFilter::filter($this->request, ['company' => $client])->pluck('news_id')->toArray();
        
        $tendencias = NewsFilter::filter($this->request, ['ids' => $notesIds])
            ->select('trend', DB::raw('count(*) as total'))
            ->groupBy('trend')
            ->get();

        $medios = NewsFilter::filter($this->request, ['ids' => $notesIds])
            ->select('mean_id', DB::raw('count(*) as total'))
            ->groupBy('mean_id')
            ->get();

        $where = '';

        $themes = DB::select("select themes.id, themes.name
                            from assigned_news
                            inner join news on assigned_news.news_id = news.id
                            inner join themes on assigned_news.theme_id = themes.id
                            where news.id in (" . str_replace(']', '', str_replace('[', '', $notesIds)) . ")
                            AND date(news.created_at) BETWEEN '". $from->format('Y-m-d') ."' AND '" . $to->format('Y-m-d') ."'
                            group by themes.id, themes.name
                            order by name desc");
        
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
        $this->count_trend = count($obj['trend_lbl']);

        foreach($medios as $itm)
        {
            $obj['mean_lbl'][] = $itm->mean->name;
            $obj['mean'][] = $itm->total;
        }
        $this->count_mean = count($obj['mean_lbl']);

        $this->graph1 = $obj;

        //dd($this->graph1);
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
        return 'A40'; // . (count($themes) + 1);
    }

    public function map($note): array {

        $trend = $note->trend == 1 ? 'Positiva' : ($note->trend == 2 ? 'Neutral' : 'Negativa');
        $theme = $note->assignedNews->where('company_id', $this->request->input('company'))->where('news_id', $note->id)->first()->theme->name ?? 'N/E';
        $link = route('front.detail.news', ['qry' => Crypt::encryptString("{$note->id}-{$note->title}-{$this->request->input('company')}")]);

        // return [
        //     "OPE-{$note->id}",
        //     $note->title,
        //     $theme,
        //     $note->synthesis,
        //     $note->author,
        //     $note->authorType->description ?? 'N/E',
        //     $note->genre->description ?? 'N/E',
        //     $note->source->name ?? 'N/E',
        //     $note->section->name ?? 'N/E',
        //     $note->mean->name ?? 'N/E',
        //     $note->news_date->format('Y-m-d'),
        //     $note->cost,
        //     $trend,
        //     $note->scope,
        //     $link
        // ];
        
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
        // return [
        //     '#',
        //     'Título',
        //     'Tema',
        //     'Síntesis',
        //     'Autor',
        //     'Tipo de autor',
        //     'Género',
        //     'Fuente',
        //     'Sección',
        //     'Medio',
        //     'Fecha nota',
        //     'Costo',
        //     'Tendencia',
        //     'Alcance',
        //     'Link'
        // ];
        return [
            '#',
            'Título | Tema | Síntesis',
            //'Tema',
            //'Síntesis',
            'Autor | Tipo de autor',
            //'Tipo de autor',
            'Género | Fuente | Sección | Medio',
            //'Fuente',
            //'Sección',
            //'Medio',
            'Fecha nota',
            'Costo',
            'Tendencia | Alcance',
            //'Alcance',
            //'Link'
        ];
    }

    public function charts() {

        $dt = [
            'B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AX','AY','AZ',
            'BA','BB','BC','BD','BE','BF','BG','BH','BI','BJ','BK','BL','BM','BN','BO','BP','BQ','BR','BS','BT','BU','BV','BX','BY','BZ',
            'CA','CB','CC','CD','CE','CF','CG','CH','CI','CJ','CK','CL','CM','CN','CO','CP','CQ','CR','CS','CT','CU','CV','CX','CY','CZ',
            'DA','DB','DC','DD','DE','DF','DG','DH','DI','DJ','DK','DL','DM'];
        
                //	Set the Labels for each data series we want to plot
                //		Datatype
                //		Cell reference for data
                //		Format Code
                //		Number of datapoints in series
                //		Data values
                //		Data Marker
                foreach($this->themes as $key => $itm)
                    $dataSeriesLabels[] = new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_STRING, 'Worksheet!$' . $dt[$key] . '$1', null, 1);
                
                /*$dataSeriesLabels = [
                    new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_STRING, 'Worksheet!$B$1', null, 1), //	2010
                    new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_STRING, 'Worksheet!$C$1', null, 1), //	2011
                    new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_STRING, 'Worksheet!$D$1', null, 1), //	2012
                    new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_STRING, 'Worksheet!$E$1', null, 1), //	2012
                    new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_STRING, 'Worksheet!$F$1', null, 1), //	2012
                ];*/

                //	Set the X-Axis Labels
                //		Datatype
                //		Cell reference for data
                //		Format Code
                //		Number of datapoints in series
                //		Data values
                //		Data Marker
                $xAxisTickValues = [
                    new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_STRING, 'Worksheet!$A$2:$A$' . $this->count_news, null, 4), //	Q1 to Q4
                ];
                //	Set the Data values for each data series we want to plot
                //		Datatype
                //		Cell reference for data
                //		Format Code
                //		Number of datapoints in series
                //		Data values
                //		Data Marker
                foreach($this->themes as $key => $itm)
                    $dataSeriesValues[] = new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_NUMBER, 'Worksheet!$' . $dt[$key] . '$2:$' . $dt[$key] . '$' . $this->count_news, null, 4);

                /*$dataSeriesValues = [
                    new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_NUMBER, 'Worksheet!$B$2:$B$5', null, 4),
                    new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_NUMBER, 'Worksheet!$C$2:$C$5', null, 4),
                    new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_NUMBER, 'Worksheet!$D$2:$D$5', null, 4),
                    new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_NUMBER, 'Worksheet!$F$2:$F$5', null, 4),
                    new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_NUMBER, 'Worksheet!$G$2:$G$5', null, 4),
                ];*/ 

                //$dataSeriesValues[2]->setLineWidth(60000);

                //	Build the dataseries
                $series = new DataSeries(
                    DataSeries::TYPE_LINECHART, // plotType
                    DataSeries::GROUPING_STACKED, // plotGrouping
                    range(0, count($dataSeriesValues) - 1), // plotOrder
                    $dataSeriesLabels, // plotLabel
                    $xAxisTickValues, // plotCategory
                    $dataSeriesValues        // plotValues
                );

                //	Set the series in the plot area
                $plotArea = new PlotArea(null, [$series]);
                //	Set the chart legend
                $legend = new Legend(Legend::POSITION_TOPRIGHT, null, false);

                $title = new Title('Noticias');
                $yAxisLabel = new Title('');

                //	Create the chart
                $chart = new Chart(
                    'chart1', // name
                    $title, // title
                    $legend, // legend
                    $plotArea, // plotArea
                    true, // plotVisibleOnly
                    0, // displayBlanksAs
                    null, // xAxisLabel
                    $yAxisLabel  // yAxisLabel
                );

                //	Set the position where the chart should appear in the worksheet
                $chart->setTopLeftPosition('A21');
                $chart->setBottomRightPosition('H39');











                                
                // Set the Labels for each data series we want to plot
                //     Datatype
                //     Cell reference for data
                //     Format Code
                //     Number of datapoints in series
                //     Data values
                //     Data Marker
                $dataSeriesLabels2 = [
                    new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_STRING, 'Worksheet!$C$1', null, 1), // 2011
                ];
                // Set the X-Axis Labels
                //     Datatype
                //     Cell reference for data
                //     Format Code
                //     Number of datapoints in series
                //     Data values
                //     Data Marker
                $xAxisTickValues2 = [
                    new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_STRING, 'Worksheet!$A$' . ($this->count_news + 1) . ':$G$' . ($this->count_news + 1), null, 4), // Q1 to Q4
                ];
                // Set the Data values for each data series we want to plot
                //     Datatype
                //     Cell reference for data
                //     Format Code
                //     Number of datapoints in series
                //     Data values
                //     Data Marker
                $dataSeriesValues2 = [
                    new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_NUMBER, 'Worksheet!$A$' . ($this->count_news + 2) . ':$G$' . ($this->count_news + 2), null, 4),
                ];

                // Build the dataseries
                $series2 = new DataSeries(
                    DataSeries::TYPE_DONUTCHART, // plotType
                    null, // plotGrouping (Pie charts don't have any grouping)
                    range(0, count($dataSeriesValues2) - 1), // plotOrder
                    $dataSeriesLabels2, // plotLabel
                    $xAxisTickValues2, // plotCategory
                    $dataSeriesValues2          // plotValues
                );

                // Set up a layout object for the Pie chart
                $layout2 = new Layout();
                $layout2->setShowVal(true);
                $layout2->setShowPercent(true);

                // Set the series in the plot area
                $plotArea2 = new PlotArea($layout2, [$series2]);
                // Set the chart legend
                $legend2 = new Legend(Legend::POSITION_RIGHT, null, false);

                $title2 = new Title('Tendencias');

                // Create the chart
                $chart2 = new Chart(
                    'chart2', // name
                    $title2, // title
                    $legend2, // legend
                    $plotArea2, // plotArea
                    true, // plotVisibleOnly
                    DataSeries::EMPTY_AS_GAP, // displayBlanksAs
                    null, // xAxisLabel
                    null   // yAxisLabel - Pie charts don't have a Y-Axis
                );

                // Set the position where the chart should appear in the worksheet
                $chart2->setTopLeftPosition('A1');
                $chart2->setBottomRightPosition('C20');

                // Add the chart to the worksheet
                //$worksheet->addChart($chart1);


   
                // Set the Labels for each data series we want to plot
                //     Datatype
                //     Cell reference for data
                //     Format Code
                //     Number of datapoints in series
                //     Data values
                //     Data Marker
                $dataSeriesLabels1 = [
                    new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_STRING, 'Worksheet!$C$1', null, 1), // 2011
                ];
                // Set the X-Axis Labels
                //     Datatype
                //     Cell reference for data
                //     Format Code
                //     Number of datapoints in series
                //     Data values
                //     Data Marker
                $xAxisTickValues1 = [
                    new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_STRING, 'Worksheet!$A$' . ($this->count_news + 3) . ':$G$' . ($this->count_news + 3), null, 4), // Q1 to Q4
                ];
                // Set the Data values for each data series we want to plot
                //     Datatype
                //     Cell reference for data
                //     Format Code
                //     Number of datapoints in series
                //     Data values
                //     Data Marker
                $dataSeriesValues1 = [
                    new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_NUMBER, 'Worksheet!$A$' . ($this->count_news + 4) . ':$G$' . ($this->count_news + 4), null, 4),
                ];

                // Build the dataseries
                $series1 = new DataSeries(
                    DataSeries::TYPE_PIECHART, // plotType
                    null, // plotGrouping (Pie charts don't have any grouping)
                    range(0, count($dataSeriesValues1) - 1), // plotOrder
                    $dataSeriesLabels1, // plotLabel
                    $xAxisTickValues1, // plotCategory
                    $dataSeriesValues1          // plotValues
                );

                // Set up a layout object for the Pie chart
                $layout1 = new Layout();
                $layout1->setShowVal(true);
                $layout1->setShowPercent(true);

                // Set the series in the plot area
                $plotArea1 = new PlotArea($layout1, [$series1]);
                // Set the chart legend
                $legend1 = new Legend(Legend::POSITION_RIGHT, null, false);

                $title1 = new Title('Medios');

                // Create the chart
                $chart1 = new Chart(
                    'chart1', // name
                    $title1, // title
                    $legend1, // legend
                    $plotArea1, // plotArea
                    true, // plotVisibleOnly
                    DataSeries::EMPTY_AS_GAP, // displayBlanksAs
                    null, // xAxisLabel
                    null   // yAxisLabel - Pie charts don't have a Y-Axis
                );

                // Set the position where the chart should appear in the worksheet
                $chart1->setTopLeftPosition('D1');
                $chart1->setBottomRightPosition('G20');

                // Add the chart to the worksheet
                //$worksheet->addChart($chart1);













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

                $event->sheet->getStyle('A40:O40')->applyFromArray([
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
                // $event->sheet->getColumnDimension('B')
                //     ->setWidth(40)
                //     ->setAutoSize(false);
                // $event->sheet->getColumnDimension('D')
                //     ->setWidth(120)
                //     ->setAutoSize(false);
                // $event->sheet->getStyle('L')->getNumberFormat()
                //     ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                // $event->sheet->getStyle('N')->getNumberFormat()
                //     ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                // $event->sheet->setAutoFilter('A40:O40');


                $event->sheet->getColumnDimension('A')->setAutoSize(false);
                $event->sheet->getColumnDimension('B')
                    ->setWidth(100)
                    ->setAutoSize(false);
                $event->sheet->getColumnDimension('C')
                    //->setWidth(10)
                    ->setAutoSize(false);
                $event->sheet->getColumnDimension('D')
                    //->setWidth(15)
                    ->setAutoSize(false);
                $event->sheet->getColumnDimension('E')
                    ->setWidth(13)
                    ->setAutoSize(false);
                $event->sheet->getColumnDimension('F')
                    ->setWidth(13)
                    ->setAutoSize(false);
                $event->sheet->getStyle('F')
                    ->getNumberFormat()
                    ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                $event->sheet->getColumnDimension('G')
                    ->setWidth(13)
                    ->setAutoSize(false);
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
                                $event->sheet->getStyle("A{$celda->getRow()}:ZZ{$celda->getRow()}")->getFont()
                                    ->getColor()
                                    ->setARGB('FFFFFF');
                                continue;
                            }

                            if($fila->getRowIndex() > 40)
                                $event->sheet->getStyle("A{$celda->getRow()}:G{$celda->getRow()}")->applyFromArray([
                                    'fill' => [
                                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                                        'color' => ['rgb' => 'e9f4fa'],
                                    ],
                                ]);
                            else
                                $event->sheet->getStyle("A{$celda->getRow()}:ZZ{$celda->getRow()}")->getFont()
                                    ->getColor()
                                    ->setARGB('FFFFFF');
                                
                        }else
                            if($fila->getRowIndex() < 40)
                                $event->sheet->getStyle("A{$celda->getRow()}:ZZ{$celda->getRow()}")->getFont()
                                    ->getColor()
                                    ->setARGB('FFFFFF');
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

                            if($fila->getRowIndex() > 40)
                                $event->sheet->getRowDimension($fila->getRowIndex())->setRowHeight(160);

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
