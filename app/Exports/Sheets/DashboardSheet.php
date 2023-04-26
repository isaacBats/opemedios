<?php
/**
  *-------------------------------------------------------------------------------------
  * Developer Information
  *-------------------------------------------------------------------------------------
  * @author Isaac Daniel Batista <daniel@danielbat.com>
  * @link https://danielbat.com Web Autor's site
  * @see https://twitter.com/codeisaac <@codeisaac>
  * @copyright 2023
  * @version 1.1.0
  * @package App\Export\Sheets
  * Type: Sheet
  * Description: Class to generate all data
  *
  * For the full copyright and license information, please view the LICENSE
  * file that was distributed with this source code.
  */

 namespace App\Exports\Sheets;

 use Maatwebsite\Excel\Concerns\{WithCharts, WithTitle};
 use Maatwebsite\Excel\Files;
 use PhpOffice\PhpSpreadsheet\Chart\{
    Chart,
    DataSeries,
    DataSeriesValues,
    Legend,
    PlotArea,
    Title,
    Layout
};

class DashboardSheet implements WithCharts, WithTitle
{

    private $pivotSheet;

    public function __construct($notes, $client, $filters)
    {
        $this->pivotSheet = new PivotTablesSheet($notes, $client, $filters);
    }

    /** @return array */
    public function charts(): array
    {
        $columnsExcel = [ 'A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z' ];
        $themes = $this->pivotSheet->getUsedThemes();
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $worksheet = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet();
        $initCell = $worksheet->getCell([2,5]);
        dd([$this, 'cell' => $initCell]);

        $chartTrends = $this->donutChartTrends($columnsExcel);
        $chartTrends->setTopLeftPosition('A1');
        $chartTrends->setBottomRightPosition('H20');

        $chartMean = $this->pieChartMeans($columnsExcel);
        $chartMean->setTopLeftPosition('I1');
        $chartMean->setBottomRightPosition('P20');

        $chartNotices = $this->barChartNotes($themes);
        $chartNotices->setTopLeftPosition('A22');
        $chartNotices->setBottomRightPosition('P50');

        return [$chartTrends,$chartMean, $chartNotices];
    }


    public function generaColumnasExcel($themes, $columnsExcel)
    {
        $dt = array();
        $ind = -1;
        $ind_ = 0;
        $ind__ = -1;

        foreach($themes as $key => $itm)
        {
            if($key == 0)
            {
                $dt[] = $columnsExcel[$ind_];
                $ind_++;
            }

            if($ind == -1 && $key < count($columnsExcel))
                $dt[] = $columnsExcel[$ind_];
            elseif($ind__ == -1 && $ind < count($columnsExcel))
                $dt[] = $columnsExcel[$ind] . $columnsExcel[$ind_];
            else
                $dt[] = $columnsExcel[$ind__] . $columnsExcel[$ind] . $columnsExcel[$ind_];

            $ind_++;
            if($ind_ == (count($columnsExcel)))
            {
                $ind_ = 0;
                $ind++;
                if($ind == (count($columnsExcel)))
                {
                    $ind = 0;
                    $ind__++;
                }

            }
        }

        return $dt;
    }

    /**
     * @param array $columnsExcel
     * @return Chart
     */
    private function pieChartMeans(array $columnsExcel): Chart
    {
        $meansInfo = $this->pivotSheet->getMeanInfo();
        $numMeans = count($meansInfo['mean_lbl']);

        $layout = new Layout();
        $layout->setShowPercent(true);
        $legend = new Legend(Legend::POSITION_RIGHT, $layout);

        $colum = $columnsExcel[$numMeans - 1];

        $labels = [new DataSeriesValues('String', 'Tablas_estadisticas!$A$1', null, 1)];
        $categories = [new DataSeriesValues('String', 'Tablas_estadisticas!$A$3:$' . $colum . '$3', null, $numMeans)];
        $values = [new DataSeriesValues('Number', 'Tablas_estadisticas!$A$4:$' . $colum . '$4', null, $numMeans)];

        $series = new DataSeries(
            DataSeries::TYPE_PIECHART,
            null,
            range(0, count($values) - 1),
            $labels,
            $categories,
            $values
        );
        $plot = new PlotArea($layout, [$series]);

        return new Chart('Medios', new Title('Medios'), $legend, $plot);
    }

    /**
     * @param array $columnsExcel
     * @return Chart
     */
    private function donutChartTrends(array $columnsExcel): Chart
    {
        $trendInfo = $this->pivotSheet->getTrendInfo();
        $numTrends = count($trendInfo['trend_lbl']);

        $layout = new Layout();
        $layout->setShowPercent(true);

        $legend = new Legend(Legend::POSITION_RIGHT, $layout);

        $colum = $columnsExcel[$numTrends - 1];

        $labels = [new DataSeriesValues('String', 'Tablas_estadisticas!$A$1', null, 1)];
        $categories = [new DataSeriesValues('String', 'Tablas_estadisticas!$A$1:$' . $colum . '$1', null, $numTrends)];
        $values = [new DataSeriesValues('Number', 'Tablas_estadisticas!$A$2:$' . $colum . '$2', null, $numTrends)];

        $series = new DataSeries(
            DataSeries::TYPE_DONUTCHART,
            null,
            range(0, count($values) - 1),
            $labels,
            $categories,
            $values
        );
        $plot = new PlotArea($layout, [$series]);

        return new Chart('Tendencias', new Title('Tendencias'), $legend, $plot);
    }

    private function barChartNotes($themes)
    {
        $layout = new Layout();
        $layout->setShowVal(true);
        $layout->setShowPercent(true);

        $legend = new Legend(Legend::POSITION_RIGHT, $layout);
        $initColum = 'B';
        $initRow = 5;
        $labels = [
            new DataSeriesValues('String', 'Tablas_estadisticas!$B$5', null, 1),
            new DataSeriesValues('String', 'Tablas_estadisticas!$C$5', null, 1),
            new DataSeriesValues('String', 'Tablas_estadisticas!$D$5', null, 1),
            new DataSeriesValues('String', 'Tablas_estadisticas!$E$5', null, 1),
            new DataSeriesValues('String', 'Tablas_estadisticas!$F$5', null, 1),
            new DataSeriesValues('String', 'Tablas_estadisticas!$G$5', null, 1),
            new DataSeriesValues('String', 'Tablas_estadisticas!$H$5', null, 1),
            new DataSeriesValues('String', 'Tablas_estadisticas!$I$5', null, 1),
            new DataSeriesValues('String', 'Tablas_estadisticas!$J$5', null, 1),
            new DataSeriesValues('String', 'Tablas_estadisticas!$K$5', null, 1),
            new DataSeriesValues('String', 'Tablas_estadisticas!$L$5', null, 1),
            new DataSeriesValues('String', 'Tablas_estadisticas!$M$5', null, 1),
            new DataSeriesValues('String', 'Tablas_estadisticas!$N$5', null, 1),
            new DataSeriesValues('String', 'Tablas_estadisticas!$O$5', null, 1),
        ];
        $categories = [new DataSeriesValues('String', 'Tablas_estadisticas!$A$6:$A$34', null, 4)];
        $values = [
//            new DataSeriesValues($dataType = 'Number', $dataValues = $result)
            new DataSeriesValues('Number', 'Tablas_estadisticas!$B$6:$B$34', null, 4),
            new DataSeriesValues('Number', 'Tablas_estadisticas!$C$6:$C$34', null, 4),
            new DataSeriesValues('Number', 'Tablas_estadisticas!$D$6:$D$34', null, 4),
            new DataSeriesValues('Number', 'Tablas_estadisticas!$E$6:$E$34', null, 4),
            new DataSeriesValues('Number', 'Tablas_estadisticas!$F$6:$F$34', null, 4),
            new DataSeriesValues('Number', 'Tablas_estadisticas!$G$6:$G$34', null, 4),
            new DataSeriesValues('Number', 'Tablas_estadisticas!$H$6:$H$34', null, 4),
            new DataSeriesValues('Number', 'Tablas_estadisticas!$I$6:$I$34', null, 4),
            new DataSeriesValues('Number', 'Tablas_estadisticas!$J$6:$J$34', null, 4),
            new DataSeriesValues('Number', 'Tablas_estadisticas!$K$6:$K$34', null, 4),
            new DataSeriesValues('Number', 'Tablas_estadisticas!$L$6:$L$34', null, 4),
            new DataSeriesValues('Number', 'Tablas_estadisticas!$M$6:$M$34', null, 4),
            new DataSeriesValues('Number', 'Tablas_estadisticas!$N$6:$N$34', null, 4),
            new DataSeriesValues('Number', 'Tablas_estadisticas!$O$6:$O$34', null, 4)
        ];

        $series = new DataSeries(
            DataSeries::TYPE_BARCHART_3D,
            null,
            range(0, count($values) - 1),
            $labels,
            $categories,
            $values
        );

        $plot = new PlotArea($layout, [$series]);

        return new Chart('Noticias', new Title('Noticias'), $legend, $plot);
    }

    /** @return string */
    public function title(): string
    {
        return 'Dashboard Grafico';
    }
}
