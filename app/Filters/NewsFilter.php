<?php
namespace App\Filters;

use App\Models\News;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class NewsFilter
{
    /**
     * @param array $filters
     * @return Builder
     */
    public static function filter(array $filters): Builder
    {
        $where = 'where';

        return  News::query()
        ->when(isset($filters['notesIds']), function ($queryBuilder) use ($filters) {
            return $queryBuilder->whereIn('id', $filters['notesIds']);
        })
        ->when(isset($filters['sector']), function ($queryBuilder) use ($filters) {
            $where = is_array($filters['sector']) ? 'whereIn' : 'where';
            return $queryBuilder->$where('sector_id', $filters['sector']);
        })
        ->when(isset($filters['genre']), function ($queryBuilder) use ($filters) {
            $where = is_array($filters['genre']) ? 'whereIn' : 'where';
            return $queryBuilder->$where('genre_id', $filters['genre']);
        })
        ->when(isset($filters['mean']), function ($queryBuilder) use ($filters) {
            $where = is_array($filters['mean']) ? 'whereIn' : 'where';
            return $queryBuilder->$where('mean_id', $filters['mean']);
        })
        ->when(isset($filters['source_id']), function ($queryBuilder) use ($filters) {
            $where = is_array($filters['source_id']) ? 'whereIn' : 'where';
            return $queryBuilder->$where('source_id', $filters['source_id']);
        })
        ->when(
            (isset($filters['start_date']) && isset($filters['end_date'])),
            function ($queryBuilder) use ($filters) {
                $from = Carbon::create($filters['start_date']);
                $to = Carbon::create($filters['end_date']);
                return $queryBuilder->whereBetween('news_date', [$from, $to]);
            }
        )
        ->when(
            (isset($filters['start_date'])  && empty($filters['end_date'])),
            function ($queryBuilder) use ($filters) {
                return $queryBuilder->whereDate('news_date', Carbon::create($filters['start_date']));
            }
        )
        ->when(isset($filters['word']), function ($queryBuilder) use ($filters) {
            return $queryBuilder->where('title', 'like', "%{$filters['word']}%")
                ->orWhere('synthesis', 'like', "%{$filters['word']}%");
        });
    }
}
