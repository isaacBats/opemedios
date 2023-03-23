<?php
namespace App\Filters;

use App\Models\AssignedNews;
use Illuminate\Database\Eloquent\Builder;

class AssignedNewsFilter
{
    /**
     * @param array $filters
     * @return Builder
     */
    public static function filter(array $filters): Builder
    {
        return AssignedNews::query()
            ->when(isset($filters['company']), function ($q) use ($filters) {
                return $q->where('company_id', $filters['company']);
            })
            ->when(isset($filters['theme_id']), function ($q) use ($filters) {
                $where = is_array($filters['theme_id']) ? 'whereIn' : 'where';
                return $q->$where('theme_id', $filters('theme_id'));
            });
    }
}
