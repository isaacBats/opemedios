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
 * Description: Class to generate pivots tables
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace App\Exports\Sheets;

use App\Models\AssignedNews;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromArray;

class PivotTablesSheet implements FromArray
{
    /**
     * @var
     */
    protected $notes;

    /**
     * @var
     */
    protected $client;

    /**
     * @var
     */
    protected $filters;

    /**
     * @param $notes
     * @param $client
     * @param $filters
     */
    public function __construct($notes, $client, $filters)
    {
        $this->notes = $notes;

        $this->client = $client;

        $this->filters = $filters;
    }

    public function array(): array
    {
        $data = array_merge(
            $this->getTrendInfo(),
            $this->getMeanInfo(),
            $this->getUsedThemes()
        );
        dd($data);
        return $data;
    }

    /**
     * @return array
     */
    protected function getMeanInfo(): array
    {
        $data = array();
        $notes = clone $this->notes;
        $means = $notes->select('mean_id', DB::raw('count(*) as total'))
            ->groupBy('mean_id')
            ->get();
        foreach ($means as $itm) {
            $data['mean_lbl'][] = "{$itm->mean->name} ({$itm->total})";
            $data['mean'][] = $itm->total;
        }
        return $data;
    }

    /**
     * @return array
     */
    protected function getTrendInfo(): array
    {
        $data = array();
        $notes = clone $this->notes;
        $trends = $notes->select('trend', DB::raw('count(*) as total'))
            ->groupBy('trend')
            ->get();

        foreach ($trends as $key => $itm) {
            $data['trend_lbl'][] = ($itm->trend == 1
                    ? 'Positiva'
                    : ($itm->trend == 2 ? 'Neutral' : 'Negativa')
                ) . ' (' . $itm->total .')';
            $data['trend'][] = $itm->total;
        }
        return  $data;
    }

    /**
     * @return array
     */
    protected function getUsedThemes(): array
    {
        $data = array();
        $notes = clone $this->notes;
        $data['temas'] = AssignedNews::joinSub($notes, 'news', function ($join) {
                $join->on('assigned_news.news_id', '=', 'news.id');
        })->join('themes', 'assigned_news.theme_id', '=', 'themes.id')
            ->select('themes.id', 'themes.name')
            ->groupBy('themes.id', 'themes.name')
            ->orderBy('themes.name', 'DESC')->get()->toArray();
        return $data;
    }

    protected function getIntervalTime()
    {
        if (isset($this->filters['start_date']) && isset($this->filters['end_date'])) {
            $from = Carbon::create($this->filters['start_date']);
            $to = Carbon::create($this->filters['end_date']);
        } elseif (isset($this->filters['start_date']) && empty($this->filters['end_date'])) {
            $from =  $to = Carbon::create($this->filters['start_date']);
        } else {
            $from =  $to = Carbon::now();
        }
        $period = CarbonPeriod::create($from, $to);
    }
}
