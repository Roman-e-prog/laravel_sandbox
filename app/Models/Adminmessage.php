<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Adminmessage extends Model
{
     protected $fillable = [
        'user_id',
        'adminname',
        'adminmessage',
        'published_at',
        'has_answered',
        'questioner_name',
        'questioner_id',
        'usermessage_id',
    ];
    protected $casts = [
        'published_at' => 'datetime',
        'has_answered' => 'boolean',
    ];
}
