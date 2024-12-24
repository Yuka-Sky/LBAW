<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Ban extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'ban';

    protected $fillable = [
        'id_user',
        'id_admin',
        'reason',
        'permanent_bool',
        'begin_date',
        'end_date',
    ];

    protected $casts = [
        'begin_date' => 'datetime',
        'end_date' => 'datetime',
    ];
}