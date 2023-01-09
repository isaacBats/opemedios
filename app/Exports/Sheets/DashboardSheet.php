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

 use Maatwebsite\Excel\Concerns\{WithCharts, WithTitle};
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
    WithCharts,
    WithTitle
{
    
    public function charts()
    {
        $dataSeriesLabels2 = [
            new DataSeriesValues(
                DataSeriesValues::DATASERIES_TYPE_STRING,
                'Worksheet!$A$40:$C$40',
                null,
                1,
            ),
        ];

        $xAxisTickValues2 = [
            new DataSeriesValues(
                DataSeriesValues::DATASERIES_TYPE_STRING,
                null,
                null,
                3,
                ['Positiva', 'Negativa', 'Neutral']
            ),
        ];

        $dataSeriesValues2 = [
            new DataSeriesValues(
                DataSeriesValues::DATASERIES_TYPE_NUMBER,
                null,
                null,
                60,
                [35,40,25]
            ),
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

        $chart2->setTopLeftPosition('A1');
        $chart2->setBottomRightPosition('C20');
       
        return $chart2;
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Dashboard';
    }
}
