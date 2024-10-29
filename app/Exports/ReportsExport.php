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

use App\Models\{Company, Theme};
use App\Exports\Sheets\{DashboardSheet, DataTableSheet};
use App\Filters\{AssignedNewsFilter, NewsFilter};
use Carbon\{Carbon, CarbonPeriod};
use DB;
use Maatwebsite\Excel\Concerns\{Exportable, WithMultipleSheets};


class ReportsExport implements WithMultipleSheets
{
    use Exportable;

    private $request;
    private $graph1;
    private $themes;
    private $count_news;
    private $count_trend;
    private $count_mean;
    private $columnas_generadas;
    private $num = 0;
    private $init_row = 40;

    private $client;
    private $notesIds;
    private $notes;
    private $data_graph;
    private $themes_group;

    public function __construct($request)
    {
        $this->request = $request;
        $this->client = Company::find($this->request->input('company'));

        $themes_group = AssignedNewsFilter::filter($this->request, ['company' => $this->client])
                    ->select('theme_id')
                    ->groupBy('theme_id')->get();
                    
        $this->themes_group = $themes_group;
        foreach($themes_group as $key => $itm)
        {
            $notes_Ids = AssignedNewsFilter::filter($this->request, ['company' => $this->client, 'theme_id' => $itm->theme_id])
                                ->pluck('news_id');
            $notes_grp = NewsFilter::filter($this->request, ['ids' => $notes_Ids]);

            $theme_name = Theme::find($itm->theme_id);
            
            $this->notes[$key][0] = $theme_name->name;
            $this->notes[$key][1] = $notes_grp;
        }

        $this->notesIds = AssignedNewsFilter::filter($this->request, ['company' => $this->client])
                            ->pluck('news_id');
        //$this->notes = NewsFilter::filter($this->request, ['ids' => $this->notesIds]);

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
        $obj = array();

        /* TENDENCIAS */
            $tendencias = NewsFilter::filter($this->request, ['ids' => $this->notesIds])
                ->select('trend', DB::raw('count(*) as total'))
                ->groupBy('trend')
                ->get();

            foreach($tendencias as $key => $itm)
            {
                $obj['trend_lbl'][] = ($itm->trend == 1 ? 'Positiva' : ($itm->trend == 2 ? 'Neutral' : 'Negativa')) . ' (' . $itm->total .')';
                $obj['trend'][] = $itm->total;
            }
            $this->count_trend = isset($obj['trend_lbl']) ? count($obj['trend_lbl']) : 0;
        /* TENDENCIAS */

        /* MEDIOS */
            $medios = NewsFilter::filter($this->request, ['ids' => $this->notesIds])
                ->select('mean_id', DB::raw('count(*) as total'))
                ->groupBy('mean_id')
                ->get();
            foreach($medios as $itm)
            {
                $obj['mean_lbl'][] = $itm->mean->name . ' (' . $itm->total .')';
                $obj['mean'][] = $itm->total;
            }
            $this->count_mean = isset($obj['mean_lbl']) ? count($obj['mean_lbl']) : 0;
        /* MEDIOS */

        $where = '';

        $qry = "select themes.id, themes.name
        from assigned_news
        inner join news on assigned_news.news_id = news.id
        inner join themes on assigned_news.theme_id = themes.id
        where news.id in (" . str_replace(']', '', str_replace('[', '', $this->notesIds)) . ")
        AND date(news.created_at) BETWEEN '". $from->format('Y-m-d') ."' AND '" . $to->format('Y-m-d') ."'
        group by themes.id, themes.name
        order by name desc";

        $themes = DB::select($qry);
        $this->themes = $themes;

        $this->columnas_generadas = $this->generaColumnasExcel();
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
                            where news.id in (" . str_replace(']', '', str_replace('[', '', $this->notesIds)) . ")
                            " . $where . "
                            group by date(news.created_at), themes.id, themes.name
                            order by date(news.created_at) desc");

            $data[$date->format('Y-m-d')] = $qry;
            $fechas[] = $date->format('Y-m-d');
        }


        $s = (6 + count($fechas));
        $this->init_row = ($s < 40 ? 40 : $s);


        $json = '';
        foreach ($this->themes as $theme)
        {
            $vnt_ = 0;

            $obj[0][0] = '';
            $obj[0][] = $theme->name;
            foreach ($fechas as $dt){
                $dat_imp = '';

                foreach ($data[$dt] as $dato_){
                    if($dato_->id == $theme->id)
                    {
                        $dat_imp = $dato_->total;
                        $vnt_ += $dato_->total;
                    }
                }
                $obj[$dt][0] = $dt;
                $obj[$dt][] = (empty($dat_imp) ? 0 : $dat_imp);
            }

            $obj[0][count($obj[0]) - 1] = $theme->name . ' (' . $vnt_ . ')';
        }

        $this->count_news = count($obj);

        $this->data_graph = $obj;
    }

    /**
     * @return array
     */
    public function sheets(): array
    {
        // $obj = array(
        //     new DashboardSheet(
        //         $this->init_row,
        //         $this->columnas_generadas,
        //         $this->themes,
        //         $this->count_news,
        //         $this->count_trend,
        //         $this->count_mean,
        //         $this->data_graph));
        
        // $start_row = 0;
        // $obj_dd = null;
        // foreach($this->themes_group as $key => $itm)
        // {
        //     $obj_dd .= $this->notes[$key][1];
        //     $start_row += 10;
        // }
        // $obj[1] = new DataTableSheet($obj_dd, $this->client, $this->notes[$key][0], $start_row);

        // return $obj;

        return [
                new DashboardSheet(
                    $this->init_row,
                    $this->columnas_generadas,
                    $this->themes,
                    $this->count_news,
                    $this->count_trend,
                    $this->count_mean,
                    $this->data_graph),
                new DataTableSheet(
                    $this->notes, 
                    $this->client,
                    $this->themes_group)
            ];
    }

    public function generaColumnasExcel()
    {
        $columns_excel = [ 'A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z' ];//count 26

        $dt = array();
        $ind = -1;
        $ind_ = 0;
        $ind__ = -1;

        foreach($this->themes as $key => $itm)
        {
            if($key == 0)
            {
                $dt[] = $columns_excel[$ind_];
                $ind_++;
            }

            if($ind == -1 && $key < count($columns_excel))
                $dt[] = $columns_excel[$ind_];
            elseif($ind__ == -1 && $ind < count($columns_excel))
                $dt[] = $columns_excel[$ind] . $columns_excel[$ind_];
            else
                $dt[] = $columns_excel[$ind__] . $columns_excel[$ind] . $columns_excel[$ind_];

            $ind_++;
            if($ind_ == (count($columns_excel)))
            {
                $ind_ = 0;
                $ind++;
                if($ind == (count($columns_excel)))
                {
                    $ind = 0;
                    $ind__++;
                }

            }
        }

        return $dt;
    }

}