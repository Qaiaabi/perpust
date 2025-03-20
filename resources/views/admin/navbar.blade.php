<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
    <button class="btn btn-primary" id="menu-toggle">☰</button>
    <div class="ms-auto">
        <span>
            @if (Route::has('login'))
            @auth
            <x-app-layout></x-app-layout>
            @else
            <a href="{{ route('login') }}" class="btn btn-primary me-2">Login</a>
            @if (Route::has('register'))
            <a href="{{ route('register') }}register.html}" class="btn btn-outline-light">Register</a>
            @endif
            @endauth
            @endif
        </span>
    </div>
</nav>