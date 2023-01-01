<?php

namespace App\Models;

use App\Kodesign\Traits\Mediable;
use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany as BelongsToManyAlias;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Spatie\Image\Manipulations;

class Movie extends Model
{
    use Filterable;
    use Mediable;

    protected $guarded = [];

    protected $casts = [
        'metas' => 'json'
    ];

    protected $appends = [
        'featured_image',
        'view_link',
        'genres_list'
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * RELATION :: returns all cast for movie
     *
     * @return BelongsToManyAlias
     */
    public function cast(){
        return $this->belongsToMany(Person::class)->withPivot(['role', 'role_name']);
    }

    /**
     * RELATION :: each movie can have many person as director
     *
     * @return BelongsToManyAlias
     */
    public function directors() {
        return $this->belongsToMany(Person::class)->wherePivot('role', 'director')->withPivot(['role', 'role_name']);
    }

    /**
     * RELATION :: each movie can have many person as actor
     *
     * @return BelongsToManyAlias
     */
    public function actors() {
        return $this->belongsToMany(Person::class)->wherePivot('role', 'actor')->withPivot(['role', 'role_name']);
    }

    /**
     * RELATION :: each movie can belongs to many genres
     *
     * @return BelongsToManyAlias
     */
    public function genres(){
        return $this->belongsToMany(Genre::class);
    }

    /**
     * Returns the link to movie page
     *
     * @return string
     */
    public function viewLink(){
        return route('movie.single', $this);
    }

    public function getViewLinkAttribute(){
        return $this->viewLink();
    }

    public function GetGenresListAttribute(){
        return optional($this->genres)->take(2)->pluck('name')->implode(', ');
    }

    public function imdbLink(){
        return ($this->metas && $this->metas['imdb_id']) ? "https://www.imdb.com/title/{$this->metas['imdb_id']}/" : null;
    }
}
