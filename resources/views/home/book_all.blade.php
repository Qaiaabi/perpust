<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LibraryQ</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    @include('home.css')

    <style>
        /* Styling tambahan */
        body {
            font-family: 'Poppins', sans-serif;
        }


        .genre-item:hover {
            background-color: #007bff;
            color: white;
        }

        .card {
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: translateY(-8px);
        }

        .pagination .page-link {
            color: #007bff;
        }

        .pagination .page-item.active .page-link {
            background-color: #007bff;
            border-color: #007bff;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    @include('home.navbar')

    <!-- Slogan -->
    <div id="beranda" class="container mt-5">
        <div class="slogan">"Jelajahi Dunia Ilmu, Temukan Buku Favoritmu di LibraryQ!"</div>
    </div>

    <!-- Genre List -->
    <div class="container">
        <div class="genre-list">
            @foreach($categories as $category)
                <span class="genre-item" onclick="filterByGenre('{{ $category->cat_title }}')">
                    {{ $category->cat_title }}
                </span>
            @endforeach
        </div>
    </div>

    <!-- Hasil Pencarian -->
    <div class="container mt-4">
        @if(isset($query) && !empty($query))
            <h2>Hasil Pencarian: "{{ $query }}"</h2>
        @endif

        @if($books->isEmpty())
            <p class="text-muted">Tidak ada hasil yang ditemukan untuk "{{ $query ?? 'Pencarian Anda' }}".</p>
        @else
            <h3 class="mt-3">Buku yang Tersedia:</h3>
            <div class="row">
                @foreach($books as $book)
                    <div class="col-md-4 mb-4">
                        <div class="card shadow-sm">
                            <img src="{{ asset($book->book_img) }}" class="card-img-top" alt="{{ $book->judul }}" style="height: 300px; object-fit: cover;">
                            <div class="card-body">
                                <h5 class="card-title">{{ $book->judul }}</h5>
                                <p class="card-text">Penerbit: {{ $book->penerbit }}</p>
                                <p class="card-text">Genre: {{ $book->category->cat_title }}</p>
                                @if($book->stock > 0)
                                    <button class="btn btn-primary" onclick="showBorrowPopup('{{ $book->id }}')">Pinjam Buku</button>
                                @else
                                    <button class="btn btn-secondary" disabled>Habis</button>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-4 d-flex justify-content-center">
                {{ $books->appends(['query' => $query])->links() }}
            </div>
        @endif
    </div>

    @include('home.footer')

    <!-- JavaScript untuk Filter Genre -->
    <script>
        function filterByGenre(genre) {
            window.location.href = "{{ route('book.search') }}?query=" + encodeURIComponent(genre);
        }

        function showBorrowPopup(bookId) {
            alert("Fitur pinjam buku ID " + bookId + " akan segera tersedia!");
        }
    </script>

</body>

</html>
