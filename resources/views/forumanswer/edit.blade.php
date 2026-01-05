
@extends('layouts.main')

@section('content')
    <h1 class="title">ForumAnswer edit Form</h1>
    <form action="{{ route('forumanswer.update', ['id'=>$answer->id])}}" method="POST"  class="forumpostsform">
        @csrf
        @method('put')
        <div class="formGroup">
            <label class="label">Forum Post</label>
            @include('quill.container', ['field' => 'answer_body'])>
        </div>
        <button type="submit" class="sendBtn">Store</button>
    </form>
@endsection