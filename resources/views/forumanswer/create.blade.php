
@extends('layouts.main')
@section('content')
<form action="{{ route('forumanswer.store', $post->id) }}" method="POST">
    @csrf
    @include('quill.container', ['field' => 'answer_body'])
     <input type="hidden" name="answer_body" id="answer_body">
     <input type="hidden" name="parent_id" value="{{ request('parent_id') }}">
    <button type="submit">Absenden</button>
</form>
@endsection