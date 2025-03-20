<nav class="navbar navbar-expand-lg navbar-dark fixed-top">
  <div class="container">
    <a style="font-weight: 600;" class="navbar-brand" href="#">🀦 LibraryQ</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav mx-auto">
        <li class="nav-item"><a class="nav-link" href="{{url ('index') }}">Beranda</a></li>
        <li class="nav-item"><a class="nav-link" href="#tentang">Tentang</a></li>
        <li class="nav-item"><a class="nav-link" href="#buku">Buku</a></li>
        <li class="nav-item"><a class="nav-link" href="#fitur">Fitur</a></li>
        @auth
        <li class="nav-item"><a class="nav-link" href="#">Profile</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ url('book_history') }}">History</a></li>
        @endauth
      </ul>

      <div class="d-flex align-items-center">
        <form class="d-flex me-2" method="GET" action="{{ route('book.search') }}">
          <input class="form-control me-2" type="search" name="query" placeholder="Cari buku atau genre..." required>
          <button class="btn btn-outline-primary" type="submit">Cari</button>
        </form>



        @if (Route::has('login'))
        <div class="">
          @auth
          <x-app-layout></x-app-layout>
          @else
          <a href="{{ route('login') }}" class="btn btn-primary me-2">Login</a>

          @if (Route::has('register'))
          <a href="{{ route('register') }}" class="btn btn-outline-light">Register</a>
          @endif
          @endauth
        </div>
        @endif

      </div>
    </div>
  </div>
</nav>