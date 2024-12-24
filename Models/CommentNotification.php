<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class CommentNotification extends Model
{
    protected $table = 'comment_notification';

    protected $fillable = [
        'id_comment',
        'id_user_notified',
        'id_user_generator',
        'date',
    ];

    protected $casts = [
        'date' => 'datetime'
    ];

    public $timestamps = false; 

    public function comment()
    {
        return $this->belongsTo(Comment::class, 'id_comment');
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