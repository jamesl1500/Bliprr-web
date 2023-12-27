<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the blips that belong to the user.
     */
    public function blips()
    {
        return $this->hasMany(Blips::class, 'blip_author');
    }

    /**
     * Get the followings that belong to the user.
     */
    public function followings()
    {
        return $this->hasMany(Followings::class, 'follower_id');
    }

    /**
     * Get the followers that belong to the user.
     */
    public function followers()
    {
        return $this->hasMany(Followings::class, 'followee_id');
    }

    /**
     * Get the conversations that belong to the user.
     */
    public function conversations()
    {
        return $this->hasMany(Conversation_members::class, 'user_uid');
    }

}
