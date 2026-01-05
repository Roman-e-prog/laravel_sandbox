<!-- resources/views/home.blade.php -->
@extends('layouts.main')

@section('content')
    @if (session('status'))
    <div id="toast" class="toast">
        {{ session('status') }}
    </div>
    <script>
        setTimeout(() => {
            document.getElementById('toast').style.display = 'none';
        }, 3000); // hide after 3 seconds
    </script>
@endif
<div class="container-home">
    <div class="greetImage">
        <img src="{{ asset('images/titleImage.png') }}" alt="Ein Mann über 40 programmiert" class="img">
    </div>
    <div class="greeting">
        <h1 class="headline">{{$title['blogTitle']}}</h1>
        <h2 class="greetAuthor">Ein Blog von {{$title['blogAuthor']}}</h2>
    </div>
</div>
@endsection
@section('footer')
<div class="footer">
    <h3 class="copyright">Copyright Roman Armin Rostock 2025</h3>
    </div>
@endsection