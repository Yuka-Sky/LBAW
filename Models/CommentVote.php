<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CommentVote extends Model
{
    use HasFactory;

    protected $table = 'comment_vote';

    protected $primaryKey = ['id_user', 'id_comment'];  
    
    public $incrementing = false;
    
    protected $keyType = 'array'; 

    public $timestamps = false;

    protected $fillable = [
        'id_user',
        'id_comment',
        'upvote_bool'
        
    ];
    public function comment() : BelongsTo {
        return $this->belongsTo(Comment::Class, 'id_comment');
    }

    public function user() : BelongsTo {
        return $this->belongsTo(User::Class, 'id_user');
    }

    public static function userHasUpvoted($userId, $commentId){
        return self::where('id_user', $userId)
                ->where('id_comment', $commentId)
                ->where('upvote_bool', true)
                ->exists();
    }

    public static function userHasDownvoted($userId, $commentId){
        return self::where('id_user', $userId)
                ->where('id_comment', $commentId)
                ->where('upvote_bool', false)
                ->exists();
    }
}
