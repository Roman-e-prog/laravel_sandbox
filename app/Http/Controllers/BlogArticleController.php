<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BlogArticle;
use App\Models\BlogArticleImages;
class BlogArticleController extends Controller
{
    //show articles
    public function showArticles(){
        $articles = BlogArticle::all();

        return view('blogarticles', [
            'articles'=> $articles
            ]
    );
    }
    //show detail article
    public function showArticleDetail($id){
        $article = BlogArticle::with([
            'images'
        ])->findOrFail($id);
        return view('blogarticle.article_detail', 
        [ 'article' => $article, 
        'images' => $article->images, 
        'id' => $id, ]);
    }
   
}