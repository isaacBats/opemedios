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
use Carbon\{Carbon, CarbonPeriod};
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\{FromArray, WithTitle};

class PivotTablesSheet implements FromArray, WithTitle
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
        $data = [];
        $themes = $this->getUsedThemes();
        $period = $this->getIntervalTime();
        $dataFromPeriodTime = $this->getDataFromPeriodTime($period);
        $dates = collect($period->map(function (Carbon $date) {
            return $date->format('Y-m-d');
        }))->toArray();

        foreach ($themes as $theme) {
            $vnt_ = 0;
            $data[0][0] = '';
            $data[0][] = $theme->name;
            foreach ($dates as $day) {
                $dat_imp = '';
                foreach ($dataFromPeriodTime[$day] as $dataFromPeriodItem) {
                    if ($dataFromPeriodItem->id == $theme->id) {
                        $dat_imp = $dataFromPeriodItem->total;
                        $vnt_ += $dataFromPeriodItem->total;
                    }
                }
                $data[$day][0] = $day;
                $data[$day][] = (empty($dat_imp) ? 0 : $dat_imp);
            }
            $data[0][count($data[0]) - 1] = $theme->name . ' (' . $vnt_ . ')';
        }

        return array_merge(
            $this->getTrendInfo(),
            $this->getMeanInfo(),
            $data,
        );
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
     * @return mixed
     */
    protected function getUsedThemes()
    {
        $notes = clone $this->notes;
        return AssignedNews::joinSub($notes, 'news', function ($join) {
                $join->on('assigned_news.news_id', '=', 'news.id');
        })->join('themes', 'assigned_news.theme_id', '=', 'themes.id')
            ->select('themes.id', 'themes.name')
            ->groupBy('themes.id', 'themes.name')
            ->orderBy('themes.name', 'DESC')->get();
    }

    /**
     * @return CarbonPeriod
     */
    protected function getIntervalTime(): CarbonPeriod
    {
        if (isset($this->filters['start_date']) && isset($this->filters['end_date'])) {
            $from = Carbon::create($this->filters['start_date']);
            $to = Carbon::create($this->filters['end_date']);
        } elseif (isset($this->filters['start_date']) && empty($this->filters['end_date'])) {
            $from =  $to = Carbon::create($this->filters['start_date']);
        } else {
            $from =  $to = Carbon::now();
        }

        return CarbonPeriod::create($from, $to);
    }

    /**
     * @param $period
     * @return array
     */
    protected function getDataFromPeriodTime($period): array
    {
        $data = array();
        foreach ($period as $date) {
            $day = $date->format('Y-m-d');
            $data[$day] = AssignedNews::query()
                ->selectRaw("date(news.created_at) AS dt, themes.id, themes.name, count(*) as total")
                ->join('news', 'assigned_news.news_id', '=', 'news.id')
                ->join('themes', 'assigned_news.theme_id', '=', 'themes.id')
                ->whereIn('news.id', $this->filters['notesIds'])
                ->whereRaw("date(news.created_at) = '{$day}'")
                ->groupByRaw('date(news.created_at), themes.id, themes.name')
                ->orderByRaw('date(news.created_at) DESC')
                ->get();
        }

        return $data;
    }

    public function title(): string
    {
        return "Tablas estadisticas";
    }
}
