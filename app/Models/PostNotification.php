<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class PostNotification extends Model
{
    protected $table = 'post_notification';

    protected $fillable = [
        'id_post',
        'type',
        'id_user_notified',
        'id_user_generator',
        'date',
    ];

    protected $casts = [
        'date' => 'datetime'
    ];

    public $timestamps = false;

    public function post()
    {
        return $this->belongsTo(Post::class, 'id_post');
    }

    public function notifiedUser()
    {
        return $this->belongsTo(User::class, 'id_user_notified');
    }

    public function generatorUser()
    {
        return $this->belongsTo(User::class, 'id_user_generator');
    }
}