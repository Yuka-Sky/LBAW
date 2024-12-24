<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PostTag extends Model
{
    use HasFactory;

    protected $table = 'post_tag';
    public $timestamps  = false;

    protected $fillable = [
        'id_post', 'id_tag'
    ];    
    public function tag(): BelongsTo {
        $this->belongsTo(Tag::class, 'id_tag');
    }


    public function getTagName(){
        $tag = Tag::find($this->id_tag);
        return $tag->name; 
    }
}
