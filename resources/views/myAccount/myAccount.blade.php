@extends('layouts.main')

@section('content')
    <div class="container-account">
        @auth
            <h1 class="welcome">Willkommen auf Ihrem Account {{auth()->user()->username}}</h1>  
            @endauth
    </div>
    <div class="dataContainer">
        <livewire:my-account/>
     </div>
    
@endsection