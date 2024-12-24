<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model{
    use HasFactory;
    
    protected $table = 'post';

    public $timestamps = false;

    protected $fillable = [
        'id_user',
        'title',
        'subtitle',
        'content',
        'date'
    ];

    protected $casts = [
        'date' => 'datetime'
    ];

    public function user(): BelongsTo{
        return $this->belongsTo(User::class, 'id_user');
    }

    public function tags(): HasMany{
        return $this->hasMany(PostTag::class,'id_post');
    }

    public function votes(): HasMany{
        return $this->hasMany(PostVote::class, 'id_post');
    }

    public function upvotes() {
        return $this->votes()->where('upvote_bool', true)->count();
    }

    public function downvotes() {
        return $this->votes()->where('upvote_bool', false)->count();
    }
    public function comments() : HasMany{
        return $this->hasMany(Comment::class, 'id_post');
    }
}
