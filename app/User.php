<?php

namespace App;

use App\Models\Genre;
use App\Models\Profile;
use App\Models\Review;
use App\Models\Story;
use App\Models\Wallet;
use App\Traits\Uuid;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fullname', 'username', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function wallets()
    {
        return $this->hasMany(Wallet::class);
    }

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    public function stories()
    {
        return $this->hasMany(Story::class);
    }

    public function review()
    {
        return $this->hasOne(Review::class);
    }

    public function genres()
    {
        return $this->belongsToMany(Genre::class);
    }
}
