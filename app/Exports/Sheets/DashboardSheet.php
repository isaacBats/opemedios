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

 use Maatwebsite\Excel\Concerns\{FromArray, WithEvents, WithCharts, WithTitle};
 use PhpOffice\PhpSpreadsheet\Chart\{
    Chart,
    DataSeries,
    DataSeriesValues,
    Legend,
    PlotArea,
    Title,
    Layout
};
use Carbon\{Carbon, CarbonPeriod};

class DashboardSheet implements
    FromArray,
    WithEvents,
    WithCharts,
    WithTitle
{
    
    private $themes;
    private $count_news;
    private $count_trend;
    private $count_mean;
    private $init_row = 1;
    private $columnas_generadas;
    private $data_graph;

    public function __construct(
        $init_row,
        $columnas_generadas,
        $themes,
        $count_news, 
        $count_trend,
        $count_mean, 
        $data_graph)
    {
        $this->init_row = $init_row;
        $this->columnas_generadas = $columnas_generadas;
        $this->themes = $themes;
        $this->count_news = $count_news;
        $this->count_trend = $count_trend;
        $this->count_mean = $count_mean;
        $this->data_graph = $data_graph;
    }
    
    public function charts() {
        if($this->count_news > 0 )
        {
        $dt = $this->columnas_generadas; 


        /* CHART LINE */
            foreach($this->themes as $key => $itm)
                $dataSeriesLabels[] = new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_STRING, 'Dashboard!$' . $dt[$key + 1] . '$5', null, 1);

            $xAxisTickValues = [
                new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_STRING, 'Dashboard!$A$6:$A$' . ($this->count_news + 5), null, 4),
            ];

            foreach($this->themes as $key => $itm)
                $dataSeriesValues[] = new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_NUMBER, 'Dashboard!$' . $dt[$key + 1] . '$6:$' . $dt[$key + 1] . '$' . ($this->count_news + 5), null, 4);

            if(count($this->themes) == 0)
            {
                $dataSeriesValues[] = new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_NUMBER, 'Dashboard!$B$6:$C$7', null, 4);
                $dataSeriesLabels[] = new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_STRING, 'Dashboard!$A$5', null, 1);
            }

            $series = new DataSeries(
                DataSeries::TYPE_BARCHART_3D,
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

            $chart->setTopLeftPosition('A20');
            $chart->setBottomRightPosition('P50');
        /* CHART LINE */

        $columns_excel = [ 'A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z' ];//count 26

        /* CHART2 */
            $dataSeriesLabels2 = [
                new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_STRING, 'Dashboard!$A$1', null, 1), // 2011
            ];

	        $dtTrend = $columns_excel[$this->count_trend - 1];

            $xAxisTickValues2 = [
                new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_STRING, 'Dashboard!$A$1:$' . $dtTrend . '$1', null, $this->count_trend), // Q1 to Q4
            ];

            $dataSeriesValues2 = [
                new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_NUMBER, 'Dashboard!$A$2:$' . $dtTrend . '$2', null, $this->count_trend),
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
            //$layout2->setShowVal(true);
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

            $chart2->setTopLeftPosition('A1');
            $chart2->setBottomRightPosition('H20');
        /* CHART2 */

        /* CHART3 */
            $dataSeriesLabels1 = [
                new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_STRING, 'Dashboard!$A$1', null, 1), // 2011
	        ];
            
	        //$countMean = ($columns_excel[$this->count_mean] > 3) ? $columns_excel[$this->count_mean] -2 : $columns_excel[$this->count_mean];
	        $countMean = $columns_excel[$this->count_mean - 1];

            $xAxisTickValues1 = [
                new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_STRING, 'Dashboard!$A$3:$' . $countMean . '$3', null, $this->count_mean), // Q1 to Q4
            ];
            $dataSeriesValues1 = [
                new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_NUMBER, 'Dashboard!$A$4:$' . $countMean . '$4', null, $this->count_mean),
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
            //$layout1->setShowVal(true);
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

            $chart1->setTopLeftPosition('I1');
            $chart1->setBottomRightPosition('P20');
        /* CHART3 */

        return [$chart, $chart2, $chart1];
        }
        else
            return [];
    }
 
    public function array(): array{
        return $this->data_graph;
    }
    
    public function registerEvents(): array {
        return [
            AfterSheet::class => function(AfterSheet $event){
                $dt = $this->columnas_generadas;

                // format to impar row
                foreach($event->sheet->getRowIterator() as $fila) {
                    foreach ($fila->getCellIterator() as $celda) {
                        $event->sheet->getStyle("A{$celda->getRow()}:" . $dt[count($this->themes)] . "{$celda->getRow()}")->getFont()
                            ->getColor()
                            ->setARGB('FFFFFF');
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
        return 'Dashboard';
    }
}