<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Adminmessage extends Model
{
    use HasFactory;
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
