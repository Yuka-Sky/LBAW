<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    public $timestamps = false;

    protected $table = 'follows';

    protected $fillable = [
        'id_user_follower',
        'id_user_followed',
    ];
    

    public function follower(){
        return $this->belongsTo(User::class, 'id_user_follower');
    }

    public function followedUser(){
        return $this->belongsTo(User::class, 'id_user_followed');
    }
}