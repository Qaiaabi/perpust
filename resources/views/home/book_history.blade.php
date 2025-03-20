<!DOCTYPE html>
<html lang="id">

<head>
    @include('home.css')
    <style>
        /* Container untuk tabel */
        .table-container {
            width: 90%;
            margin: 80px auto;
            overflow-x: auto;
        }

        /* Style untuk tabel */
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #162245;
            color: aliceblue;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
        }

        /* Header tabel */
        thead {
            background-color: #213264;
            color: #ffffff;
        }

        th,
        td {
            padding: 12px;
            text-align: center;
            border-bottom: 1px solid #30363d;
            word-wrap: break-word;
            /* Agar teks tidak overflow */
        }

        th {
            font-weight: bold;
            border-bottom: 2px solid #146acc;
        }

        /* Zebra striping */
        tbody tr:nth-child(odd) {
            background-color: #1e2a4a;
        }

        tbody tr:hover {
            background-color: #213264;
            transition: 0.3s ease-in-out;
        }

        /* Gambar dalam tabel */
        .book-img {
            width: 50px;
            height: auto;
            border-radius: 5px;
            display: block;
            max-width: 100%;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .table-container {
                overflow-x: auto;
            }

            table {
                display: block;
                overflow-x: auto;
                white-space: nowrap;
            }
        }
    </style>
</head>

<body>
<nav class="navbar navbar-expand-lg navbar-dark fixed-top">
  <div class="container">
    <a style="font-weight: 600;" class="navbar-brand" href="#">𓍢ִ໋🀦 LibraryQ</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav mx-auto">
        <li class="nav-item"><a class="nav-link" href="{{url ('index') }}">Beranda</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ url('index') }}">Tentang</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ url('index') }}">Buku</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ url('index') }}">Fitur</a></li>
        @auth
        <li class="nav-item"><a class="nav-link" href="{{ url('index') }}">Profile</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ url('book_history') }}">History</a></li>
        @endauth
      </ul>

      <div class="d-flex align-items-center">
        <form class="d-flex me-2">
          <input class="form-control me-2" type="search" placeholder="Cari buku...">
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

    <br><br><br><br>
    @if(session('message'))
    <div class="alert alert-danger" style="text-align: center;">
        {{ session('message') }}
    </div>
    @endif

    @if(session('success'))
    <div class="alert alert-success" style="text-align: center;">
        {{ session('success') }}
    </div>
    @endif

    @if (session('error'))
    <div class="alert alert-danger" style="text-align: center;">
        {{ session('error') }}
    </div>
    @endif

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Nama Buku</th>
                    <th>Penulis</th>
                    <th>Status</th>
                    <th>Batalkan Peminjaman</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $borrow)
                <tr>
                    <td>
                        @if (!empty($borrow->book) && !empty($borrow->book->book_img))
                        <img class="book-img" src="{{ asset($borrow->book->book_img) }}" alt="Cover Buku" style="width: 50px; height: auto;">
                        @else
                        <span>Tidak ada gambar</span>
                        @endif
                    </td>
                    <td>{{ $borrow->book->judul ?? 'Tidak diketahui' }}</td>
                    <td>{{ $borrow->book->penulis ?? 'Tidak diketahui' }}</td>
                    <td>{{ $borrow->status }}</td>
                    <td>
                        @if ($borrow->status == 'Menunggu Konfirmasi')
                        <a href="{{ url('batal_pinjam', $borrow->id) }}" class="btn btn-danger">Batalkan</a>
                        @else
                        <button class="btn btn-danger" disabled>Batalkan</button>
                        @endif
                    </td>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</body>

</html>