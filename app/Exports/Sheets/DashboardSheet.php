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
 use PhpOffice\PhpSpreadsheet\Chart\{
    Chart,
    DataSeries,
    DataSeriesValues,
    Legend,
    PlotArea,
    Title,
    Layout
};

class DashboardSheet implements
    WithCharts,
    WithTitle
{

    private $pivotSheet;

    public function __construct($notes, $client, $filters)
    {
        $this->pivotSheet = new PivotTablesSheet($notes, $client, $filters);
    }

    /**
     * @return Chart
     */
    public function charts(): Chart
    {
        $columns_excel = [ 'A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z' ];
        $meansInfo = $this->pivotSheet->getMeanInfo();
        $numMeans = count($meansInfo['mean_lbl']);
        $colum = $columns_excel[$numMeans - 1];

        $labelsMeans = [new DataSeriesValues('String', 'Tablas_estadisticas!$A$1', null, 1)];
        $categoriesMeans = [new DataSeriesValues('String', 'Tablas_estadisticas!$A$3:$' . $colum . '$3', null, $numMeans)];
        $valuesMeans = [new DataSeriesValues('Number', 'Tablas_estadisticas!$A$4:$' . $colum . '$4', null, $numMeans)];

        $seriesMeans = new DataSeries(
            DataSeries::TYPE_PIECHART,
            null,
            range(0, count($valuesMeans) - 1),
            $labelsMeans,
            $categoriesMeans,
            $valuesMeans
        );

        $layoutMeans = new Layout();
        $layoutMeans->setShowPercent(true);

        $plotMeans = new PlotArea($layoutMeans, [$seriesMeans]);

        $legendMeans = new Legend(Legend::POSITION_RIGHT, $layoutMeans, false);

        $chartMean = new Chart('means', new Title('Medios'), $legendMeans, $plotMeans);
        $chartMean->setTopLeftPosition('I1');
        $chartMean->setBottomRightPosition('P20');

        return $chartMean;
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Dashboard Grafico';
    }
}
