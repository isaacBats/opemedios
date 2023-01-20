<?php
namespace App\Filters;

use App\News;
use Carbon\Carbon;
use Illuminate\Http\Request;

class NewsFilter
{
    /**
     * @param Request $request
     * @param array $params
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function filter(Request $request, array $params): \Illuminate\Database\Eloquent\Builder
    {
        $where = 'where';

        return  News::query()
        ->when($params['ids'] !== null, function ($queryBuilder) use ($params) {
            return $queryBuilder->whereIn('id', $params['ids']);
        })
        ->when($request->input('sector') !== null, function ($queryBuilder) use ($request) {
            $where = is_array($request->input('sector')) ? 'whereIn' : 'where';
            return $queryBuilder->$where('sector_id', $request->input('sector'));
        })
        ->when($request->input('genre') !== null, function ($queryBuilder) use ($request) {
            $where = is_array($request->input('genre')) ? 'whereIn' : 'where';
            return $queryBuilder->$where('genre_id', $request->input('genre'));
        })
        ->when($request->input('mean') !== null, function ($queryBuilder) use ($request) {
            $where = is_array($request->input('mean')) ? 'whereIn' : 'where';
            return $queryBuilder->$where('mean_id', $request->input('mean'));
        })
        ->when($request->input('source_id') !== null, function ($queryBuilder) use ($request) {
            $where = is_array($request->input('source_id')) ? 'whereIn' : 'where';
            return $queryBuilder->$where('source_id', $request->input('source_id'));
        })
        ->when(
            ($request->input('start_date') !== null && $request->input('end_date') !== null),
            function ($queryBuilder) use ($request) {
                $from = Carbon::create($request->input('start_date'));
                $to = Carbon::create($request->input('end_date'));
                return $queryBuilder->whereBetween('news_date', [$from, $to]);
            }
        )
        ->when(
            ($request->input('start_date') !== null && $request->input('end_date') === null),
            function ($queryBuilder) use ($request) {
                return $queryBuilder->whereDate('news_date', Carbon::create($request->input('start_date')));
            }
        )
        ->when($request->input('word') !== null, function ($queryBuilder) use ($request) {
            return $queryBuilder->where('title', 'like', "%{$request->input('word')}%")
                ->orWhere('synthesis', 'like', "%{$request->input('word')}%");
        });
    }
}
