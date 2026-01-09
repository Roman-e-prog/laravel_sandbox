
@extends('layouts.main')

@section('content')
    <h1 class="edittitle">{{$ressort}} Forumpost editieren</h1>
    <form action="{{ route('forumposts.update', ['ressort' => $ressort, 'id'=>$post->id])}}" method="POST" enctype="multipart/form-data" class="forumpostsform">
        @csrf
        @method('put')
        <div class="formGroup">
            <label class="label required">Title</label>
            <input type="text" name="title" class="input" value="{{$post->title}}" required/>
        </div>
        <div class="formGroup">
            <label class="label">Forum Post</label>
            @include('quill.container', ['field' => 'blog_post_body'])
            <input type="hidden" name="blog_post_body" id="blog_post_body">
        </div>
        @if ($post->images_path)
            <div class="formGroup">
                <label class="label">Current Image</label>
                <img src="{{ asset('storage/' . $post->images_path) }}" 
                    alt="Current image" 
                    style="max-width: 200px; display:block; margin-bottom:10px;">
            </div>
        @endif
        <div class="formGroup">
            <label class="label">Image</label>
            <input type="file" name="image" class="input"/>
        </div>
        <div class="formGroup">
            <label class="label required">Slug</label>
            <input type="text" name="slug" class="input" value="{{$post->slug}}" required/>
        </div>
        <button type="submit" class="sendBtn">Store</button>
        <script>
            window.addEventListener('DOMContentLoaded', () => {
                window.dispatchEvent(new CustomEvent('quill-set-content-global', {
                    detail: {
                        field: 'blog_post_body',
                        value: @json($post->blog_post_body)
                    }
                }));
            });
            </script>
    </form>
@endsection