<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use Uuid;

    public $incrementing = false;

    protected $fillable = ['name', 'story_id'];

    public function stories()
    {
        return $this->belongsTo(Story::class);
    }
}
