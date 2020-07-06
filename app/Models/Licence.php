<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;

class Licence extends Model
{
    use Uuid;

    public $incrementing = false;

    protected $fillable = ['name', 'descriptions'];

    protected $appends = ['resource_url'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at',
    ];

    public function stories()
    {
        return $this->hasOne(Story::class);
    }

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/licences/' . $this->getKey());
    }
}
