<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;

class Part extends Model
{
    use Uuid;

    public $incrementing = false;

    protected $fillable = ['part_cover', 'part_title', 'part_description', 'story_id'];

    public function stories()
    {
        return $this->hasMany(Story::class);
    }
}
