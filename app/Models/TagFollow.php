<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TagFollow extends Model
{
   
    public $timestamps = false;

    protected $table = 'tag_follows';

    protected $fillable = [
        'id_user',
        'id_tag',
    ];
    

    public function follower(){
        return $this->belongsTo(User::class, 'id_user');
    }

    public function tag(){
        return $this->belongsTo(Tag::class, 'id_tag');
    }
}
