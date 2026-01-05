<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Blogarticle;

class BlogarticleImages extends Model
{
protected $fillable = [
        'id',
        'blogarticle_id',
        'path',
        'alt',
        'title',
        'created_at',
        'updated_at',
    ];
    protected $casts = [
        'created_at'=>'datetime',
        'updated_at'=>'datetime',
    ];
    public function blogArticle(){
        return $this->belongsTo(Blogarticle:: class);
    }
}