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

use App\Models\Company;
use App\Exports\Sheets\{DashboardSheet, DataTableSheet, PivotTablesSheet};
use App\Filters\{AssignedNewsFilter, NewsFilter};
use Maatwebsite\Excel\Concerns\{Exportable, WithMultipleSheets};


class ReportsExport implements WithMultipleSheets
{
    use Exportable;

    protected $requestFilters;
    protected $client;
    protected $notes;

    public function __construct($requestFilters)
    {
        $this->requestFilters = $requestFilters;
        $this->client = Company::find($this->requestFilters['company']);
        $this->requestFilters['notesIds'] = AssignedNewsFilter::filter($this->requestFilters)
            ->pluck('news_id');
        $this->notes = NewsFilter::filter($this->requestFilters);
    }

    /**
     * @return array
     */
    public function sheets(): array
    {
        return [
            new PivotTablesSheet($this->notes, $this->client, $this->requestFilters),
//            new DashboardSheet($this->notes, $this->client),
            new DataTableSheet($this->notes, $this->client)
        ];
    }
}
