<?php
namespace App\Filters;

use App\Models\AssignedNews;
use Carbon\Carbon;
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
