
@extends('layouts.main')

@section('content')
    <h1 class="title">{{$ressort}} Forumpost edit Form</h1>
    <form action="{{ route('forumposts.update', ['ressort' => $ressort, 'id'=>$id])}}" method="POST" enctype="multipart/form-data" class="forumpostsform">
        @csrf
        @method('put')
        <div class="formGroup">
            <label class="label required">Title</label>
            <input type="text" name="title" class="input" required/>
        </div>
        <div class="formGroup">
            <label class="label">Forum Post</label>
            @include('quill.container', ['field' => 'blog_post_body'])
        </div>
        <div class="formGroup">
            <label class="label">Image</label>
            <input type="file" name="image" class="input"/>
        </div>
        <div class="formGroup">
            <label class="label required">Slug</label>
            <input type="text" name="slug" class="input" required/>
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