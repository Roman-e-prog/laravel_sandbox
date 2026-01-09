<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Usermessage extends Model
{
    use HasFactory;
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
