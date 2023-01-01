<?php
namespace App\Kodesign\Traits;

use App\Models\Media;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait Mediable {
    /*
     * RELATION :: returns all featured media
     *
     * @return MorphToMany
     */
    public function featured(){
        return $this->media()->wherePivot('collection', 'featured');
    }

    /*
     * RELATION :: returns all featured media
     *
     * @return MorphToMany
     */
    public function poster(){
        return $this->media()->wherePivot('collection', 'poster');
    }

    /**
     * RELATION :: returns all gallery media
     *
     * @return MorphToMany
     */
    public function gallery(){
        return $this->media()->wherePivot('collection', 'gallery');
    }

    /**
     * RELATION :: returns all media related to model
     *
     * @return MorphToMany
     */
    public function media(){
        return $this->morphToMany(Media::class, 'mediable');
    }

    /**
     * RELATION :: Returns all video medias associated with model
     */
    public function videos(){
        return $this->gallery()->with('poster')->where('type', 'video');
    }

    /**
     * RELATION :: Returns all video medias associated with model
     */
    public function images(){
        return $this->gallery()->where('type', 'image');
    }

    /**
     * MUTATOR :: returns featured image
     *
     * @return mixed|null
     */
    public function getFeaturedImageAttribute(){
        return $this->featured()->first();
    }

    /**
     * returns the array of featured image
     *
     * @return Collection
     */
    public function featuredImageArray(){
        return $this->featured()->get();
    }

    /**
     * returns the array of poster image
     *
     * @return Collection
     */
    public function posterImageArray(){
        return $this->poster()->get();
    }

    public function cover($size_name = 'cover'){
        return optional($this->featured()->first())->url($size_name);
    }

    public function posterImage($size_name = 'poster'){
        return optional($this->poster()->first())->url($size_name);
    }
}
