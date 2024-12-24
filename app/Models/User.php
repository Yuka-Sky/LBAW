<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory;
    

    public $timestamps  = false;
    
    
    protected $fillable = [
        'name',
        'email',
        'password',
    ];
    
    protected $casts = [
        'password' => 'hashed',
    ];
    
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function following()
    {
        return $this->hasMany(Follow::class, 'id_user_follower');
    }

    public function tag_following()
    {
        return $this->hasMany(TagFollow::class, 'id_user');
    }

}

