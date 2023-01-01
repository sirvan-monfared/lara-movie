<?php


namespace App\Traits;


use App\Kodesign\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

trait Filterable
{
    /**
     * SCOPE :: applies filter to query builder
     *
     * @param $query
     * @param Filter $filter
     * @return Builder
     */
    public function scopeFilter($query, Filter $filter){
        return $filter->apply($query);
    }
}
