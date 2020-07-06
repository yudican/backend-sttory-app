<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;

class Library extends Model
{
    use Uuid;

    public $incrementing = false;

    protected $fillable = ['access_type', 'status', 'expired_at', 'read_on', 'user_id', 'story_id'];

    protected $dates = ['expired_at', 'read_on'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function story()
    {
        return $this->belongsTo(Story::class);
    }
}
