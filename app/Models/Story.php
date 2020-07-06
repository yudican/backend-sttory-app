<?php

namespace App\Models;

use App\Traits\Uuid;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Story extends Model
{
    use Uuid;

    public $incrementing = false;

    protected $fillable = ['title', 'cover', 'description', 'language', 'price', 'genre_id', 'licence_id'];

    // protected $appends = ['cover_url'];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function genre()
    {
        return $this->belongsTo(Genre::class);
    }

    public function licence()
    {
        return $this->belongsTo(Licence::class);
    }

    public function tags()
    {
        return $this->hasMany(Tag::class);
    }

    public function parts()
    {
        return $this->hasMany(Part::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function libraries()
    {
        return $this->hasMany(Library::class);
    }

    // ACCESOR
    // public function getCoverUrlAttribute()
    // {
    //     return 'storage/' . $this->attributes['cover'];
    // }
}
