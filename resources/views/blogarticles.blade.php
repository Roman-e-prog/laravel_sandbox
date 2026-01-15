@extends('layouts.main')

@section('content')
    <div class="container-blogarticles">
        @if ($articles && count($articles) > 0)
        @foreach ( $articles as $article)
        <a href="{{route('blogarticle.article_detail', ['id'=>$article->id])}}" class="articleDetail">
            <div class="fieldWrapper">
                <div class="headWrapper">
                    <h3 class="blog_headline">{{$article->title ?? ''}}</h3>
                    <p class="author">Von {{$article->author ?? ''}}</p>
                    <p class="ressort">{{$article->ressort ?? ''}}</p>
                    <p class="created_at">
                        {{ optional($article->published_at)->diffForHumans() ?? 'Noch kein Datum' }}
                    </p>
                </div>
            </div>
            </a>
        @endforeach 
        @else
        <div class="noArticlesYet">
            <p>Wir haben derzeit noch keine Artikel erstellt.</p>
        </div>
        @endif
    </div>
@endsection