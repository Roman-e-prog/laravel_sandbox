@extends('layouts.main')

@section('content')
<div class="container-forum">
    <ul class="forumList">
        @foreach ($ressorts as $ressort)
                <li class="forumItems"><a href="{{ route('forumposts.show', ['ressort' => $ressort]) }}">{{$ressort}}</a></li>
        @endforeach
    </ul>
    <div class="forumUsage">
        <p class="forumMessage">In den Themenforen können Sie Fragen zu der jeweiligen Programmiersprache stellen. Diskussionen führen. Oder Hilfe beim debuggen von Komponenten bekommen, die Ihnen Fehler melden. Auch wenn etwas mal nicht funktioniert, ohne dass Sie eine Fehlermeldung bekommen, stellen Sie den Code für die jeweilige Programmiersprache ein, sodass andere einen Blick darauf werfen können.<br/>Viel Spaß bei der Nutzung des Forums.</p>
    </div>
</div>
    
@endsection