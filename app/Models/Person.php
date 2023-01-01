<?php

namespace App\Models;

use App\Kodesign\Traits\Mediable;
use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Person extends Model
{
    use Filterable;
    use Mediable;

    protected $guarded = [];
    public $timestamps = false;

    public function getRouteKeyName(){
        return 'slug';
    }

    protected $appends = [
        'featured_image',
        'view_link',
        'roles_list'
    ];

    /**
     * RELATION :: Each person can hav participate in many movies
     *
     * @return BelongsToMany
     */
    public function movies(){
        return $this->belongsToMany(Movie::class)->withPivot(['role', 'role_name'])->orderBy('year', 'DESC');
    }

    /**
     * RELATION :: Returns all movies that person have acted on them
     *
     * @return BelongsToMany
     */
    public function moviesPlayed(){
        return $this->belongsToMany(Movie::class)->withPivot(['role', 'role_name'])->wherePivot('role', 'actor')->orderBy('year', 'DESC');
    }

    /**
     * RELATION :: return movies directed by person
     *
     * @return BelongsToMany
     */
    public function moviesDirected(){
        return $this->belongsToMany(Movie::class)->withPivot(['role', 'role_name'])->wherePivot('role', 'director')->orderBy('year', 'DESC');
    }

    /**
     * MUTATOR :: Returns Role
     *
     * @param $value
     * @return false|string[]
     */
    public function getRolesAttribute($value){
        return explode(',', $value);
    }

    /**
     *
     *
     * @return string
     */
    public function viewLink() {
        return route('person.single', $this->slug);
    }

    public function getViewLinkAttribute(){
        return $this->viewLink();
    }

    public function getRolesListAttribute(){
        return implode(', ', $this->roles);
    }
}
