            <div id="beranda" class="container" style="padding-top: 20px;">
                <div class="slogan">"Jelajahi Dunia Ilmu, Temukan Buku Favoritmu di LibraryQ!"</div>
            </div>

            <div class="container">
                <div class="genre-list">
                    <span>Fiksi</span>
                    <span>Sejarah</span>
                    <span>Fantasi</span>
                    <span>Self-Help</span>
                    <span>Biografi</span>
                    <span>Misteri</span>
                    <span>Romansa</span>
                    <span>Teknologi</span>z
                </div>
            </div>

            {{-- 🔔 Notifikasi Pengembalian --}}
            @if($notifKembali->isNotEmpty())
            <center>
                <div class="alert alert-warning alert-dismissible fade show" role="alert" style="text-align: center; max-width: 1250px;">
                    @foreach($notifKembali as $notif)
                    📚 Buku <strong>{{ $notif->book->judul }}</strong> harus dikembalikan pada
                    <strong>{{ $notif->returned_at ? $notif->returned_at->format('d-m-Y') : 'Tanggal tidak tersedia' }}!</strong>. <br>
                    @endforeach
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </center>
            @endif

            @if($dendaNotif->isNotEmpty())
            <center>
                <div class="alert alert-danger alert-dismissible fade show" role="alert" style="text-align: center; max-width: 1250px;">
                    @foreach($dendaNotif as $denda)
                    ⚠️ Buku: <strong>{{ $denda->book->judul }}</strong> -
                    Denda: <strong>Rp {{ $denda->formatted_denda }}</strong> karena keterlambatan!<br>
                    @endforeach
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </center>
            @endif



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

            <div style="margin-top: 20px;" class="container">
                <h1>📖Buku Terbaru</h1>
                <div style="display: flex; justify-content: center;">
                    <svg width="200" height="20" viewBox="0 0 200 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M5 15 C 50 30, 150 5, 195 15" stroke="#007bff" stroke-width="6" stroke-linecap="round" fill="none" stroke-opacity="0.8" />
                    </svg>
                </div>
                <div class="swiper-container mt-4">
                    <div class="swiper-wrapper">
                        @foreach($data as $book)
                        <div class="swiper-slide">
                            <div class="card shadow-sm rounded-4">
                                <img src="{{ asset($book->book_img) }}" alt="{{ $book->judul }}" class="card-img-top" style="height: 250px; object-fit: cover;" />
                                <div class="card-body">
                                    <h1>{{ $book->judul }}</h1>
                                    <p class="mb-1"><strong>Penulis:</strong> {{ $book->penulis }}</p>
                                    <p class="mb-1"><strong>Penerbit:</strong> {{ $book->penerbit }}</p>
                                    <p class="mb-1"><strong>Tahun:</strong> {{ $book->tahun_terbit }}</p>
                                    <p><strong>Stok:</strong> {{ $book->stock > 0 ? $book->stock . ' tersedia' : 'Habis' }}</p>


                                    @if ($book->stock > 0)
                                    <button class="btn btn-primary" onclick="showBorrowPopup('{{ $book->id }}')">
                                        Pinjam
                                    </button>

                                    @else
                                    <button class="btn btn-secondary" onclick="alert('Buku tidak tersedia.')" disabled>
                                        Buku Tidak Tersedia
                                    </button>
                                    @endif

                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Navigation Buttons -->
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>

                    <!-- Pagination -->
                    <div class="swiper-pagination"></div>
                </div>
            </div>
            <div class="modal fade" id="borrowPopup" tabindex="-1" aria-labelledby="borrowPopupLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title" id="borrowPopupLabel">Informasi Peminjaman</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ url('borrow_books') }}" method="POST">
                                @csrf
                                <input type="hidden" id="popupBookId" name="book_id">
                                <div class="mb-3">
                                    <label style="color: black;" for="borrow_at" class="form-label style=" color: black;"">Tanggal Pinjam:</label>
                                    <input type="date" class="form-control" id="borrow_at" name="borrow_at" required>
                                </div>
                                <div class="mb-3">
                                    <label style="color: black;" for="returned_at" class="form-label">Tanggal Kembali:</label>
                                    <input type="date" class="form-control" id="returned_at" name="returned_at" required>
                                </div>
                                <div class="text-end">
                                    <button type="submit" class="btn btn-success">Kirim</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- JavaScript -->
            <script>
                function showBorrowPopup(bookId) {
                    document.getElementById('popupBookId').value = bookId;
                    let borrowPopup = new bootstrap.Modal(document.getElementById('borrowPopup'));
                    borrowPopup.show();
                }
            </script>

            <!-- Bootstrap CSS & JS -->
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>