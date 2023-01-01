<?php


namespace App\Kodesign\Filters;


class MovieFilter extends Filter
{
    protected $filters = ['id', 'slug', 'title', 'year', 'order', 'genre'];

    /**
     * Filter by order
     *
     * @param $value
     * @return bool
     */
    public function order($value){

        if (empty ($value)) return false;

        switch($value) {
            case 'popularity':
                return $this->builder->orderBy('views', 'DESC');
                break;
            case 'year-asc':
                return $this->builder->orderBy('year', 'ASC');
                break;
            case 'year-desc':
                return $this->builder->orderBy('year', 'DESC');
                break;
            case 'alphabetic-asc':
                return $this->builder->orderBy('title', 'ASC');
                break;
            case 'alphabetic-desc':
                return $this->builder->orderBy('title', 'DESC');
                break;
        }
    }

    public function genre($value) {
        if (empty ($value)) return false;

        return $this->builder->whereHas('genres', function($query) use ($value){
            $query->whereIn('genre_id', $value);
        });
    }

    public function year($value){
        if (empty ($value)) return false;

        return $this->builder->whereIn('year', $value);
    }
}
