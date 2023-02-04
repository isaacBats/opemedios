<?php
namespace App\Filters;

use Carbon\Carbon;
use App\AssignedNews;
use Illuminate\Http\Request;

class AssignedNewsFilter
{
    /**
     * @param Request $request
     * @param array $params
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function filter(Request $request, array $params): \Illuminate\Database\Eloquent\Builder
    {
        return AssignedNews::query()
            ->join('news', 'news.id', '=', 'assigned_news.news_id')
            ->when(
                ($request->input('start_date') !== null && $request->input('end_date') !== null),
                function ($queryBuilder) use ($request) {
                    $from = Carbon::create($request->input('start_date'));
                    $to = Carbon::create($request->input('end_date'));
                    return $queryBuilder->whereBetween('news_date', [$from, $to]);
                }
            )
            ->when(isset($params['company']), function ($q) use ($params) {
                $company = $params['company'];
                return $q->where('company_id', $company->id);
            })
            ->when($request->input('theme_id') !== null, function ($q) use ($request) {
                $where = is_array($request->input('theme_id')) ? 'whereIn' : 'where';
                return $q->$where('theme_id', $request->input('theme_id'));
            });
    }
}
