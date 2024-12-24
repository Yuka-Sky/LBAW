<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class PostVote extends Model
{
    use HasFactory;
    
    protected $table = 'post_vote';

    protected $primaryKey = ['id_user', 'id_post'];  
    
    public $incrementing = false;
    
    protected $keyType = 'array'; 

    public $timestamps = false;

    protected $fillable = [
        'id_user',
        'id_post',
        'upvote_bool'
        
    ];
    public function post() : BelongsTo {
        return $this->belongsTo(Post::Class, 'id_post');
    }

    public function user() : BelongsTo {
        return $this->belongsTo(User::Class, 'id_user');
    }

    public static function userHasUpvoted($userId, $postId){
        return self::where('id_user', $userId)
                ->where('id_post', $postId)
                ->where('upvote_bool', true)
                ->exists();
    }

    public static function userHasDownvoted($userId, $postId){
        return self::where('id_user', $userId)
                ->where('id_post', $postId)
                ->where('upvote_bool', false)
                ->exists();
    }
}