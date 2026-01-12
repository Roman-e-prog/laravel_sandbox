
@extends('layouts.main')

@section('content')
    <h1 class="forumtitle">{{$ressort}} Forumpost senden</h1>
    <form action="{{ route('forumposts.store', ['ressort' => $ressort])}}" method="POST" enctype="multipart/form-data" class="forumpostsform">
        @csrf
        <div class="formGroup">
            <label class="label required">Titel</label>
            <input type="text" name="title" class="input" required/>
        </div>
        <div class="formGroup">
            <label class="label required">Forum Post</label>
            @include('quill.container', ['field' => 'blog_post_body'])
            <input type="hidden" name="blog_post_body" id="blog_post_body">
        </div>
        <div class="formGroup">
            <label class="label">Bild</label>
            <input type="file" name="image" class="input"/>
        </div>
        <div class="formGroup">
            <label class="label required">Slug</label>
            <input type="text" name="slug" class="input" required/>
        </div>
        <button type="submit" class="sendBtn">Speichern</button>
    </form>
@endsection