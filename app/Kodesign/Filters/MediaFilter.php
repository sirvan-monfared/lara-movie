<?php
namespace App\Kodesign\Filters;


use Carbon\Carbon;

class MediaFilter extends Filter
{
    protected $filters = ['media_type', 'created_at', 'keyword'];

    /**
     * Filter by Year
     *
     * @param $value
     * @return bool
     */
    public function mediaType($value){
        if (empty ($value)) return false;

        if (in_array($value, ['image', 'video'])) {
            return $this->builder->where('type', $value);
        }

        return false;
    }

    /**
     * Filter by Year
     *
     * @param $value
     * @return bool
     */
    public function createdAt($value){
        if (empty ($value)) return false;

        $date = Carbon::now()->subDays($value)->startOfDay()->format('Y-m-d H:i:s');

        return $this->builder->where('created_at', '>=', $date);
    }

    /**
     * Filter by order
     *
     * @param $value
     * @return bool
     */
    public function keyword($value){

        if (empty ($value)) return false;

        return $this->builder->where('name', 'LIKE', "%{$value}%")
                      ->orWhere('title', 'LIKE', "%{$value}%")
                      ->orWhere('metas->description', 'LIKE', "%{$value}%");
    }
}
