@extends('layouts.main')
  
@section('content')
    <div class="container">
        @if ($article)
            <div class="fieldWrapper">
                <div class="headWrapper">
                    <h1 class="single_headline">{{$article->title}}</h1>
                    <p class="author">Von {{$article->author}}</p>
                    <p class="ressort">{{$article->ressort}}</p>
                     <p class="created_at">
                        {{ optional($article->published_at)->diffForHumans() ?? 'Noch kein Datum' }}
                    </p>
                    <div class="singlePostWrapper">
                        <button onclick="history.back()" class="backBt">
                        Zurück
                    </button>
                    <hr class="underline">
                </div>
                <div class="articleContent">
                    <p class="desc">{{$article->description}}</p>
                    <p class="content">
                        @php
                            $decoded = is_string($article->article_content)
                                ? json_decode($article->article_content, true)
                                : $article->article_content;
                        @endphp
                        <x-quill-viewer :delta="$decoded" :id="$article->id" />
                    </p>
                </div>
                <div class="imagesWrapper">
                    @if ($article->images && count($article->images) > 0)
                    <hr class="underline">
                    <h3 class="img">Bilder zum Artikel</h3>
                    @foreach ($article->images as $image)
                        <img src="{{ Storage::url($image->path) }}" alt="{{$image->alt}} title="{{$image->title}}" class="articleImage">
                    @endforeach
                    @endif
                    <hr class="underline">
                </div>
                <div class="tasks">
                    @if ($article->tasks && count($article->tasks) > 0)
                        <h3 class="aufgaben">Aufgaben zum Artikel</h3>
                        <ul class="taskList">
                        @foreach ( $article->tasks as $task)
                            <li class="task">
                                <p>{{ $task['task'] }}</p>
                                <p>{{ $task['description'] }}</p>
                            </li>
                        @endforeach
                        </ul>
                    @endif
                </div>
                <div class="external_links">
                    @if ($article->external_links && count($article->external_links) > 0)
                    <hr class="underline">
                        <h3 class="links">Links zum Artikel</h3>
                        <ul class="linkList">
                        @foreach ( $article->external_links as $link)
                            <li class="task">
                                <p>{{ $link['url'] }}</p>
                                <p>{{ $task['label'] }}</p>
                            </li>
                        @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        @endif
    </div>
@endsection