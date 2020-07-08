<?php

namespace App\Models;

use App\Traits\Uuid;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;

class Genre extends Model implements HasMedia
{
    use Uuid;

    public $incrementing = false;

    protected $fillable = ['name'];

    protected $appends = ['resource_url', 'media_url'];


    public function stories()
    {
        return $this->hasMany(Story::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
