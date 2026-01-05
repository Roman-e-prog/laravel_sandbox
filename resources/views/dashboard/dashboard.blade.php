@extends('layouts.main')

@section('content')
    @include('quill.container', ['field' => 'article_content'])
<livewire:dashboard-articles/>
<livewire:adminmessages/>
@endsection