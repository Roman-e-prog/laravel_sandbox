<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PostReactions;
use App\Models\Answer;
class Post extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'user_id',
        'username',
        'ressort',
        'title',
        'blog_post_body',
        'images_path',
        'is_admin',
        'views',
        'is_answered',
        'published_at',
        'created_at',
        'updated_at',
        'slug',
        'status'
    ];
     protected $casts = [
        'is_admin' => 'boolean',
        'is_answered' => 'boolean',
        'views' => 'integer',
        'published_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
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
// Laravel automatically assumes in hasMany answers:

// The foreign key is post_id on the answers table.

// The local key is id on the posts table.

//on $post->answers laravel build automatically a SELECT on post_id is equal id
    public function answers()
{
    return $this->hasMany(Answer::class);
}

}
