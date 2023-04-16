<?php
namespace App\Filters;

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
            ->when(isset($params['company']), function($q) use ($params) {
                $company = $params['company'];
                return $q->where('company_id', $company->id);
            })
<<<<<<< Updated upstream
            ->when( $request->input('theme_id') !== null, function ($q) use ($request) {
                if(is_array($request->input('theme_id')))
                    return $q->whereIn('theme_id', $request->input('theme_id'));
                else
                    return $q->where('theme_id', $request->input('theme_id'));
=======
            ->when(isset($params['theme_id']), function ($q) use ($params) {
                $company = $params['theme_id'];
                return $q->where('theme_id', $company);
            })
            ->when($request->input('theme_id') !== null, function ($q) use ($request) {
                $where = is_array($request->input('theme_id')) ? 'whereIn' : 'where';
                return $q->$where('theme_id', $request->input('theme_id'));
>>>>>>> Stashed changes
            });
    }
}
