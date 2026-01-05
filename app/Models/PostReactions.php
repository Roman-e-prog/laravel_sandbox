<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Post;
class PostReactions extends Model
{
    protected $fillable = [
        'answer_id',
        'post_id', 
        'user_id', 
        'type'
    ];
    //here also laravel looks autmatically for the ids that are in reactions and also post, answer or user, so I have not to put this in
      public function post()
    {
        return $this->belongsTo(Post::class);
    }
      public function answer()
    {
        return $this->belongsTo(Answer::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
