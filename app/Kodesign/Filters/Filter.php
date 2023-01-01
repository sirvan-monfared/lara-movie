<?php

namespace App\Kodesign\Filters;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

abstract class Filter
{
    /**
     * @var Request
     */
    protected $request;

    /**
     * @var Request
     */
    protected $builder;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }


    public function apply(Builder $builder)
    {
        $this->builder = $builder;

        $filters = $this->getFilters();

        foreach ($filters as $filter => $value) {
            $method_name = camelize($filter);

            if (! method_exists($this, $method_name)) {
                continue;
            }

            $this->$method_name($value);
        }

        return $this->builder;
    }

    /**
     * Returns the array of all filters and their associated value in request
     *
     * @return array
     */
    public function getFilters()
    {
        return $this->request->only($this->filters);
    }

    /**
     * Filter by id
     *
     * @param $value
     * @return mixed
     */
    public function id($value)
    {
        if (empty ($value)) return false;

        return $this->builder->where('id', $value);
    }

    /**
     * Filter by name
     *
     * @param $value
     * @return mixed
     */
    public function name($value)
    {
        if (empty ($value)) return false;

        return $this->builder->where('name', 'LIKE', "%{$value}%");
    }

    /**
     * Filter by name
     *
     * @param $value
     * @return mixed
     */
    public function title($value)
    {
        if (empty ($value)) return false;

        return $this->builder->where('title', 'LIKE', "%{$value}%");
    }

    /**
     * Filter by name
     *
     * @param $value
     * @return mixed
     */
    public function slug($value)
    {
        if (empty ($value)) return false;

        return $this->builder->where('slug', 'LIKE', "%{$value}%");
    }
}
