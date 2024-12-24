<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Comment extends Model
{
    use HasFactory;

    protected $table = 'comment';

    public $timestamps = false;

    protected $fillable = [
        'id_user',
        'id_post',
        'content',
        'date'
    ];
    protected $casts = [
        'date' => 'datetime'
    ];
    public function user(): BelongsTo{
        return $this->belongsTo(User::class, 'id_user');
    }
    public function post(): BelongsTo {
        return $this->belongsTo(Post::Class, 'id_post');
    }

    public function votes(): HasMany{
        return $this->hasMany(CommentVote::class, 'id_comment');
    }

    public function upvotes() {
        return $this->votes()->where('upvote_bool', true)->count();
    }

    public function downvotes() {
        return $this->votes()->where('upvote_bool', false)->count();
    }

}
