<?php

namespace App\Traits;

use App\Models\AssignedNews;
use App\Models\News;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

trait StadisticsNotes
{
    public function getNoteCountPerWeek($date = 'now', $company = null) {
        $dt = new Carbon($date);
        $startWeek = $dt->startOfWeek()->format('Y-m-d');
        $endWeek = $dt->endOfWeek()->format('Y-m-d');
        $query = News::query();
        $query->select(DB::raw('DATE(news.created_at) AS day, COUNT(news.id) AS total'));
        if($company) {
            $query->join('assigned_news', 'news.id', '=', 'assigned_news.news_id');
            $query->where('assigned_news.company_id', $company);
        }
        $query->whereRaw("DATE(news.created_at) between ? and ?", [$startWeek, $endWeek]);
        $query->groupBy(DB::raw('DATE(news.created_at)'));

        return $query->get();
    }

    public function getNotesCountPerYear($company = null){
        $year = Carbon::now()->format('Y');
        $query = News::query();
        $query->select(DB::raw('MONTH(news.created_at) AS month, COUNT(news.id) AS total'));
        if($company) {
            $query->join('assigned_news', 'news.id', '=', 'assigned_news.news_id');
            $query->where('assigned_news.company_id', $company);
        }
        $query->whereYear("news.created_at", $year);
        $query->groupBy(DB::raw('MONTH(news.created_at)'));

        return $query->get();
    }

    public function getNoteCountPerWeekAndExecutiveRol($companiesIds, $date = 'now') {
        $dt = new Carbon($date);
        $startWeek = $dt->startOfWeek()->format('Y-m-d');
        $endWeek = $dt->endOfWeek()->format('Y-m-d');
        $query = AssignedNews::query();
        $query->select(DB::raw('DATE(assigned_news.created_at) AS day, companies.id AS companyid, companies.name AS company, COUNT(assigned_news.news_id) AS total'));
        $query->join('companies', 'company_id', '=', 'companies.id');
        $query->whereIn('assigned_news.company_id', $companiesIds);
        // $query->whereRaw("DATE(created_at) between ? and ?", [$startWeek, $endWeek]);
        $query->groupBy(DB::raw('DATE(assigned_news.created_at), companies.id, companies.name'));

        return $query->get();
    }

    public function getNewsForMonitor($day = 'now', $start = null, $end = null) {
        $day = ($day == 'now' || $day == null) ? \Carbon\Carbon::now()->format('Y-m-d') : $day;

        $query = News::query();

        $query->select(DB::raw('users.id, users.name, count(news.id) AS count'))
            ->join('users', 'user_id', '=', 'users.id');
            if($start && is_null($end)){
                $query->whereRaw("DATE(news.created_at) = ? ", $start);
            } elseif ($start && $end) {
                $query->whereRaw("DATE(news.created_at) between ? and ?", [$start, $end]);
            } else {
                $query->whereRaw("DATE(news.created_at) = ? ", $day);
            }
            $query->groupBy(DB::raw('users.name, users.id'))
            ->orderBy('count', 'desc');

        return $query->get();
    }

    public function getNotesForMeanAndWeek($day = 'now') {
        $dt = new Carbon($day);
        $startWeek = $dt->startOfWeek()->format('Y-m-d');
        $endWeek = $dt->endOfWeek()->format('Y-m-d');

        $notes = News::whereBetween('created_at', [$startWeek, $endWeek])->get()->map(function($note){
                if($note->user){
                    if($note->user->isMonitor()){
                        return ['mean_short_name' => $note->user->getMonitorType()->short_name, 'note_id' => $note->id];
                    } else {
                        return ['mean_short_name' => 'admin', 'note_id' => $note->id];
                    }
                }
        })->filter(function($item){
            return !is_null($item);
        })->countBy(function ($item){
            return $item['mean_short_name'];
        });

        return $notes;

    }
}
