<!-- resources/views/components/navbar.blade.php -->

<nav class="mainNav">
    <div class="logo">
      <img src="{{ asset('images/logo.png') }}" alt="Roman Rostock Websolutions" class="logoImg">  
    </div>
    <ul class="menueList">
        <li class="menueItems"><a href="/">Home</a></li>
        <li class="menueItems"><a href="/about">Über uns</a></li>
        <li class="menueItems"><a href="/forum">Forum</a></li>
        <li class="menueItems"><a href="/blogArticles">Lernen</a></li>
        @auth
           <li class="menueItems">
            <form action="{{ route('logout') }}" method="POST" style="display:inline;">
            @csrf
            <button type="submit" class="logoutBtn">Logout</button>
        </form>
           </li>
           @if (auth()->user()->role === 'admin')
               <li class="menueItems"><a href="/dashboard">Dashboard</a></li>
           @endif
           <li class="menueItems"><a href="/myAccount">Mein Account</a></li>
            @endauth
        @guest
            <li class="menueItems"><a href="/register">Register</a></li>  
        @endguest
    </ul>
</nav>