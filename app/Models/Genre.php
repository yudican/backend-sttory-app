<?php

namespace App\Models;

use App\Traits\Uuid;
use App\User;
use Brackets\Media\HasMedia\AutoProcessMediaTrait;
use Brackets\Media\HasMedia\HasMediaCollectionsTrait;
use Brackets\Media\HasMedia\HasMediaThumbsTrait;
use Brackets\Media\HasMedia\ProcessMediaTrait;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\Models\Media;

class Genre extends Model implements HasMedia
{
    use Uuid;
    use ProcessMediaTrait;
    use HasMediaThumbsTrait;
    use AutoProcessMediaTrait;
    use HasMediaCollectionsTrait;

    public $incrementing = false;

    protected $fillable = ['name'];

    protected $appends = ['resource_url', 'media_url'];


    public function registerMediaCollections()
    {
        $this->addMediaCollection('cover')
            ->disk('media') // Specify a disk where to store this collection
            ->accepts('image/*')
            ->maxNumberOfFiles(1);
    }

    public function registerMediaConversions(Media $media = null)
    {
        $this->autoRegisterThumb200();
    }

    public function stories()
    {
        return $this->hasMany(Story::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }


    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/genres/' . $this->getKey());
    }

    public function getMediaUrlAttribute()
    {
        return url($this->getThumbs200ForCollection('cover')->pluck('url')->toArray()[0]);
    }
}
