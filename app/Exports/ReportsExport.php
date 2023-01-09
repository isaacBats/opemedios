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

use DB;
use App\{AssignedNews, Company, News};
use App\Filters\{AssignedNewsFilter,NewsFilter};
use App\Exports\Sheets\{DataTableSheet, PivotTablesSheet, DashboardSheet};
use Carbon\{Carbon, CarbonPeriod};
use Maatwebsite\Excel\Concerns\{
    Exportable,
    WithMultipleSheets
};



class ReportsExport implements WithMultipleSheets
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

    private $client;
    private $notesIds;
    private $notes;

    public function __construct($request)
    {
        $this->request = $request;
        $this->client = Company::find($this->request->input('company'));
        $this->notesIds = AssignedNewsFilter::filter($this->request, ['company' => $this->client])
                ->pluck('news_id');
        $this->notes = NewsFilter::filter($this->request, ['ids' => $this->notesIds]);
    }

    /**
     * @return array
     */
    public function sheets(): array
    {
        return [
            new DataTableSheet($this->notes, $this->client),
            new PivotTablesSheet($this->notes),
            new DashboardSheet()
        ];
    }
}
