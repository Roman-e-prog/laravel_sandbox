@extends('layouts.main')

@section('content')
   <div class="singlePostWrapper">
    <button onclick="history.back()" class="backBt">
    Zurück
</button>
    <div class="fieldWrapper">
        <h4> Ein Post von: {{$post->username}}</h4>
        <h4> Am {{$post->published_at->format('d.m.Y H:i')}}</h4>
        <h3>{{ $post->title }}</h3>
        <img src="{{ Storage::url($post->images_path) }}" alt="{{$post->title}}" class="postImage">
        @php
            $decoded = is_string($post->blog_post_body)
                ? json_decode($post->blog_post_body, true)
                : $post->blog_post_body;
        @endphp
        <x-quill-viewer :delta="$decoded" :id="$post->id" />
        <p>{{$post->slug}}</p>
        <div class="evaluationWrapper">
             @auth
                @if((auth()->id() === $post->user_id || auth()->user()->is_admin) && !$post->is_answered)
                    <a href="{{route('forumposts.edit', ['ressort'=>$post->ressort,'id'=>$post->id])}}" class="link" title="edit">
                        <x-ri-edit-line class="icons"/>
                    </a>
                <form action="{{route('forumposts.destroy', ['ressort'=>$post->ressort,'id'=>$post->id])}}" class="form" style="color:transparent" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit">
                        <x-ri-delete-bin-2-line class="icons" style="color:black"/>
                    </button>
                </form>
                @endif
            @endauth
            <livewire:post-likes :post="$post" />
            @if($post->is_answered)
                <x-heroicon-o-check-circle class="icons" style="color:green" title="Answered"/>
            @else
                <x-heroicon-o-check-circle class="icons" style="color:gray" title="Not answered yet"/>
            @endif
            <x-carbon-view class="icons" title="Seen by: {{$post->views}}"/>
                <a href="{{ route('forumanswer.create', $post->id) }}" class="answer-link">
                    <x-heroicon-s-arrow-left-start-on-rectangle class="icons" title="answer this post"/>
                </a>
                <script>
                document.querySelectorAll('.answer-link').forEach(link => {
                    const loggedIn = @json(auth()->check());
                    link.addEventListener('click', function(e) {
                        if (!loggedIn) {
                            e.preventDefault();
                           toastify().error("You must be logged in, to answer this post")
                        }
                    });
                });
                </script>
            <h5>Posted {{ $post->published_at->diffForHumans() }}</h5>
        </div>
    </div>
    <div class="answerWrapper">
      
            @foreach ($post->answers as $answer)
                <div class="fieldWrapper">
                        <h4> Anwort von: {{$answer->username}}</h4>
                        <h4> @ {{$answer->questioner_name}}</h4>
                        @php
                            $decoded = is_string($answer->answer_body)
                                ? json_decode($answer->answer_body, true)
                                : $answer->answer_body;
                        @endphp
                        <x-quill-viewer :delta="$decoded" :id="$answer->id" />
                        <div class="evaluationWrapper">
                            @auth
                                @if((auth()->id() === $answer->user_id || auth()->user()->is_admin) && !$answer->has_answered)
                                    <a href="{{route('forumanswer.edit', $answer->id)}}" class="link">
                                        <x-ri-edit-line class="icons"/>
                                    </a>
                                <form action="{{route('forumanswer.destroy', $answer->id)}}" class="form" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="submitIconWrapper">
                                        <x-ri-delete-bin-2-line class="icons"/>
                                    </button>
                                </form>
                                @endif
                            @endauth
                            <livewire:answer-likes :answer="$answer" />
                            <livewire:accept-answer-button :answer="$answer" :post="$post" />
                                <a href="{{ route('forumanswer.create', ['post' => $post->id, 'parent_id' => $answer->id]) }}" class="answer-link">
                                    <x-heroicon-s-arrow-left-start-on-rectangle class="icons" title="answer this answer"/>
                                </a>
                                <script>
                                document.querySelectorAll('.answer-link').forEach(link => {
                                    const loggedIn = @json(auth()->check());
                                    link.addEventListener('click', function(e) {
                                        if (!loggedIn) {
                                            e.preventDefault();
                                        toastify().error("You must be logged in, to answer this post")
                                        }
                                    });
                                });
                                </script>
                            <h5>Posted {{ $answer->published_at->diffForHumans() }}</h5>
                        </div>
                    </div>
            @endforeach
    
    </div>
   </div>
@endsection