<?php

namespace App\Traits;

use App\AssignedNews;
use App\News;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

trait StadisticsNotes
{
    public function getNoteCountPerWeek($date = 'now') {
        $dt = new Carbon($date);
        $startWeek = $dt->startOfWeek()->format('Y-m-d');
        $endWeek = $dt->endOfWeek()->format('Y-m-d');
        $query = News::query();
        $query->select(DB::raw('DATE(created_at) AS day, COUNT(id) AS total'));
        $query->whereRaw("DATE(created_at) between ? and ?", [$startWeek, $endWeek]);
        $query->groupBy(DB::raw('DATE(created_at)'));

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
}