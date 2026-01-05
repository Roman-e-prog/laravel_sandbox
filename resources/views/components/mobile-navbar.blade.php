<!-- resources/views/components/navbar.blade.php -->

<nav class="mainNav">
    <div class="logo">
      <img src="{{ asset('images/logo.png') }}" alt="Roman Rostock Websolutions" class="logoImg">  
    </div>
    <div class="naviWrapper">
        <div class="hamburger" id="clickBtn">
            <div class="line"><div class="strich"></div></div>
            <div class="line"><div class="strich"></div></div>
            <div class="line"><div class="strich"></div></div>
        </div>
        <ul class="mobileMenueList">
            <li class="mobileMenueItems"><a href="/">Home</a></li>
            <li class="mobileMenueItems"><a href="/about">Über uns</a></li>
            <li class="mobileMenueItems"><a href="/forum">Forum</a></li>
            <li class="mobileMenueItems"><a href="/blogArticles">Lernen</a></li>
            @auth
            <li class="mobileMenueItems">
                <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="logoutBtn">Logout</button>
            </form>
            </li>
            @if (auth()->user()->role === 'admin')
                <li class="mobileMenueItems"><a href="/dashboard">Dashboard</a></li>
            @endif
            <li class="mobileMenueItems"><a href="/myAccount">Mein Account</a></li>
                @endauth
            @guest
                <li class="mobileMenueItems"><a href="/register">Register</a></li>  
            @endguest
        </ul>
    </div>
    <script> 
    const hamburger = document.getElementById('clickBtn'); const menu = document.querySelector('.mobileMenueList'); hamburger.addEventListener('click', () => { menu.classList.toggle('open'); }); 
    </script>
</nav>