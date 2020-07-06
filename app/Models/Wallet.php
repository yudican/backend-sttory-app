<?php

namespace App\Models;

use App\Traits\Uuid;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use Uuid;

    public $incrementing = false;

    protected $fillable = ['title', 'type', 'balance', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
