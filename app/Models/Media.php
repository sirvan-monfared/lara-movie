<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Staudenmeir\EloquentJsonRelations\HasJsonRelationships;

class Media extends Model
{
    use Filterable;
    use HasJsonRelationships;

    protected $guarded = [];

    protected $casts = [
        'metas' => 'json'
    ];

    public $appends = [
        'original_path',
        'original_url',
        'thumb_path',
        'cover_path',
        'mini_path',
        'poster_path',
        'shamsi_date',
        'base_name',
        'video_poster',
    ];

    /**
     * RELATION :: Return all movies morphed to media
     *
     * @return MorphToMany
     */
    public function movies(){
        return $this->morphedByMany(Movie::class, 'mediable');
    }

    /**
     * RELATION :: Return all people morphed to media
     *
     * @return MorphToMany
     */
    public function people(){
        return $this->morphedByMany(Person::class, 'mediable');
    }

    /**
     * RELATION ::each media can have a poster media in metas (for videos)
     *
     * @return BelongsTo
     */
    public function poster(){
        return $this->belongsTo(Media::class, 'metas->video_poster');
    }

    /**
     * Returns the path to media
     *
     * @param string $size_name
     * @param bool $full_path
     * @return string
     */
    public function path($size_name = '', $full_path = false){
        if ($full_path) {
            return "/{$this->path}{$this->fileName($size_name)}";
        }

        return "{$this->path}{$this->fileName($size_name)}";
    }

    /**
     * Returns url to media
     *
     * @param string $size_name
     * @return string
     */
    public function url($size_name = ''){
        return url('/') . "/{$this->path}{$this->fileName($size_name)}";
    }

    /**
     * Returns the file name for requested size
     *
     * @param string $size_name
     * @return string
     */
    public function fileName($size_name = ''){
        if (! empty($size_name)) {
            return "{$this->name}-{$size_name}.{$this->extension}";
        }

        return "{$this->name}.{$this->extension}";
    }

    /**
     * Check if media is a video or not
     *
     * @return bool
     */
    public function isVideo(){
        return ($this->type === 'video');
    }

    public function getThumbPathAttribute(){
        if ($this->isVideo()) {
            return '/images/file_types/video.png';
        }

        return "/{$this->path('thumb')}";
    }
    public function getMiniPathAttribute(){
        return "/{$this->path('mini')}";
    }
    public function getCoverPathAttribute(){
        return "/{$this->path('cover')}";
    }
    public function getPosterPathAttribute(){
        return "/{$this->path('poster')}";
    }
    public function getOriginalPathAttribute(){
        return "/{$this->path}{$this->name}.{$this->extension}";
    }
    public function getOriginalUrlAttribute(){
        return $this->url();
    }
    public function getShamsiDateAttribute(){
        return shamsi()->fromCarbon($this->created_at)->format('Y/m/d');
    }
    public function getBaseNameAttribute(){
        return $this->fileName();
    }
    public function getVideoPosterAttribute(){
        return $this->poster;
    }
}
