@extends('layouts.main')

@section('content')
    <div class="ressort">
        <h1 class="ressortHeadline">{{$ressort}}</h1>
    </div>
    <div class="createBtnWrapper">
        @auth
            <a href="{{ route('forumposts.create', ['ressort' => $ressort]) }}" class="createBtn">
                Create a Forumpost
            </a>
        @endauth

        @guest
            <button type="button" class="createBtn" onclick="showLoginToast()">
                Create a Forumpost
            </button>
        @endguest
    </div>
    @foreach($posts as $post)
                <div class="fieldWrapper">
                    <a href="{{route('forumposts.detail', ['ressort'=>$ressort, 'id'=>$post->id])}}" class="link">
                        <h4> A post from: {{$post->username}}</h4>
                        <h4>Posted at {{$post->published_at->format('d.m.Y H:i')}}</h4>
                        <h3>{{ $post->title }}</h3>
                        <img src="{{ Storage::url($post->images_path) }}" alt="{{$post->title}}" class="postImage">
                        @php
                            $decoded = is_string($post->blog_post_body)
                                ? json_decode($post->blog_post_body, true)
                                : $post->blog_post_body;
                        @endphp
                        <x-quill-viewer :delta="$decoded" :id="$post->id" />
                        <p>{{$post->slug}}</p>
                   </a>
                <div class="evaluationWrapper">
                    <script>
                           const handleWrongPage = (type) =>{
                            toastify(`Please go to the detaile page to ${type} this post`)
                           }
                        </script>
                     <x-ri-thumb-up-fill class="icons" title="{{count($post->likes)}} likes until now" onclick="handleWrongPage(like)"/>
                    <x-ri-thumb-down-fill class="icons" title="{{count($post->dislikes)}} dislikes until now" onclick="handleWrongPage(dislike)" /> 
                    <x-heroicon-o-check-circle class="icons" title="Not answered yet"/>
                    <x-carbon-view class="icons" title="Seen by: {{$post->views}}"/>
                    <h5>Posted {{ $post->published_at->diffForHumans() }}</h5>
                </div>
        </div>
    @endforeach
    </div>
@endsection