<div id="buku" class="container mt-5 pt-5">
  <h1 style="padding-top: 30px;" class="text-center">📚 Koleksi Buku</h1>
  <div style="display: flex; justify-content: center;">
    <svg width="200" height="25" viewBox="0 0 200 25" fill="none" xmlns="http://www.w3.org/2000/svg">
      <path d="M5 15 C 50 30, 150 5, 195 15" stroke="#007bff" stroke-width="6" stroke-linecap="round" fill="none"
        stroke-opacity="0.8" />
    </svg>
  </div>
  <br>
  <div class="genre-section">
    <div class="genre-title">
      <h4>📚 Fiksi / Fantasi</h4>
    </div>
    <div class="book-container">
      @foreach($fiksi as $fiksi)
      <div class="koleksi-buku">
        <img src="{{ asset($fiksi->book_img) }}" alt="{{ $fiksi->judul }}" class="card-img-top" style="height: 250px; object-fit: cover;" />
        <h6>{{ $fiksi->judul }}</h6>
        <p>{{ $fiksi->penulis ?? 'Tidak diketahui' }}</p>
        <p>Stock: {{ $fiksi->stock > 0 ? $fiksi->stock : 'Habis' }}</p>

        @if ($fiksi->stock > 0)
        <button class="btn btn-primary" onclick="showBorrowPopup('{{ $fiksi->id }}')">
          Pinjam
        </button>
        @else
        <button class="btn btn-secondary" disabled>Buku Tidak Tersedia</button>
        @endif
      </div>
      @endforeach
    </div>
  </div>
  <br>
  <div class="genre-section">
    <div class="genre-title">
      <h4>📚 Non-Fiksi</h4>
    </div>
    <div class="book-container">
      @foreach($non_fiksi as $non_fiksi)
      <div class="koleksi-buku">
        <img src="{{ asset($non_fiksi->book_img) }}" alt="{{ $non_fiksi->judul }}" class="card-img-top" style="height: 250px; object-fit: cover;" />
        <h6>{{ $non_fiksi->judul }}</h6>
        <p>{{ $non_fiksi->penulis ?? 'Tidak diketahui' }}</p>
        <p>Stock: {{ $non_fiksi->stock > 0 ? $non_fiksi->stock : 'Habis' }}</p>

        @if ($non_fiksi->stock > 0)
        <button class="btn btn-primary" onclick="showBorrowPopup('{{ $non_fiksi->id }}')">
          Pinjam
        </button>
        @else
        <button class="btn btn-secondary" disabled>Buku Tidak Tersedia</button>
        @endif
      </div>
      @endforeach
    </div>
  </div>

  <div style="text-align: center;" class="more">
    <a href="{{ url('book_all') }}">
      <button
        style="padding: 10px 30px; color: white; background-color: #007bff; font-weight: 400; border: none; border-radius: 5px;">
        Lihat Semua Buku
      </button>
    </a>
  </div>
</div>