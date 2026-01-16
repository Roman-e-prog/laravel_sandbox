<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blogarticle;
use App\Models\BlogarticleImages;
class BlogArticleController extends Controller
{
    //show articles
    public function showArticles(){
        $articles = Blogarticle::all();

        return view('blogarticles', [
            'articles'=> $articles
            ]
    );
    }
    //show detail article
    public function showArticleDetail($id){
        $article = Blogarticle::with([
            'images'
        ])->findOrFail($id);
        $article->increment('views');
        return view('blogarticle.article_detail', 
        [ 'article' => $article, 
        'images' => $article->images, 
        'id' => $id, ]);
    }
   
}