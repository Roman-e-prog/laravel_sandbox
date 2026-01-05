<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usermessage extends Model
{
    protected $fillable = [
        'user_id',
        'username',
        'usermessage',
        'is_answered',
        'published_at',
    ];
    protected $cast = [
        'published_at' => 'datetime',
        'is_answered' => 'boolean',
    ];
}
