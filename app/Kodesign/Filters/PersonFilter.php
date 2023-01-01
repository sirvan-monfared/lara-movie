<?php


namespace App\Kodesign\Filters;


class PersonFilter extends Filter
{
    protected $filters = ['id', 'slug', 'name', 'start_character'];

    public function startCharacter($value){
        if (empty ($value)) return false;

        return $this->builder->where('name', 'LIKE', "{$value}%");
    }
}
