<?php

namespace App\Models;

use App\Traits\Uuid;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use Uuid;

    public $incrementing = false;

    protected $fillable = ['description', 'star', 'user_id', 'story_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function story()
    {
        return $this->belongsTo(Story::class);
    }
}
