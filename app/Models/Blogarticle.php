<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\BlogarticleImages;
class Blogarticle extends Model
{
    protected $fillable = [
       'user_id',
       'author',
       'external_links',
       'title',
       'article_content',
       'description',
       'published_at',
       'views',
       'ressort',
       'unit',
       'tasks',
    ];
    protected $casts = [
        'external_links'=> 'array',
        'published_at'=>'datetime',
        'views'=>'integer',
        'tasks'=>'array',
        'article_content'=>'array',
    ];

    public function images()
    {
        return $this->hasMany(BlogarticleImages::class);
    }
}