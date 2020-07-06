<?php

namespace App\Models;

use App\Traits\Uuid;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use Uuid;

    public $incrementing = false;

    protected $fillable = ['avatar', 'phone', 'description', 'user_id'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
