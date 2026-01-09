<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Post;
class Answer extends Model
{
    use HasFactory;
    protected $fillable = [
        'post_id',
        'user_id',
        'username',
        'answer_body',
        'questioner_id',
        'questioner_name',
        'views',
        'is_admin',
        'has_answered',
        'published_at',
        'created_at',
        'updated_at',
    ];
    protected $casts = [
        'views' =>'integer',
        'is_admin' => 'boolean',
        'has_answered' => 'boolean',
        'published_at' => 'datetime',
        'created_at' =>'datetime',
        'updated_at' =>'datetime',
    ];

        public function post() {
        return $this->belongsTo(Post::class, 'post_id');
    }
     public function reactions()
        {
            return $this->hasMany(PostReactions::class);
        }

        public function likes()
        {
            return $this->reactions()->where('type', 'like');
        }

        public function dislikes()
        {
            return $this->reactions()->where('type', 'dislike');
        }
        
            public function answers()
        {
            return $this->hasMany(Answer::class);
        }
        //for nested relations so answers on answers I need to define parent and child
          public function parent()
            {
                return $this->belongsTo(Answer::class, 'parent_id');
            }

            public function children()
            {
                return $this->hasMany(Answer::class, 'parent_id');
            }
}
