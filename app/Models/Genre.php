<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany as BelongsToManyAlias;

class Genre extends Model
{
    public $timestamps = false;

    protected $guarded = [];

    public function getRouteKeyName(){
        return 'slug';
    }

    /**
     * RELATION :: return any movie associated with current genre
     *
     * @return BelongsToManyAlias
     */
    public function movies(){
        return $this->belongsToMany(Movie::class);
    }

    public function viewLink(){
        return route('genre.single', $this);
    }
}
