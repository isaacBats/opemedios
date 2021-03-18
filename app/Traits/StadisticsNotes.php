<?php

namespace App\Traits;

use App\News;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

trait StadisticsNotes
{
    public function getNotesPerDay($typeUser = '') {
        $dt = Carbon::now();
        $startWeek = $dt->startOfWeek()->format('Y-m-d');
        $endWeek = $dt->endOfWeek()->format('Y-m-d');
        // $startWeek = '2020-05-29';
        // $endWeek = '2020-06-04';
        if($typeUser == 'admin') {
            $query = News::query();
            $query->select(DB::raw('DATE(created_at) AS day, COUNT(id) AS total'));
            $query->whereRaw("DATE(created_at) between ? and ?", [$startWeek, $endWeek]);
            $query->groupBy(DB::raw('DATE(created_at)'));
        }

        return $query->get();
    }
}