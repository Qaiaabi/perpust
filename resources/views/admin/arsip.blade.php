<!DOCTYPE html>
<html lang="id">

<head>
    @include('admin.css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Poppins', sans-serif;
        }

        .container {
            background-color: #ffffff;
            border-radius: 16px;
            padding: 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .custom-table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            border-radius: 12px;
            overflow: hidden;
        }

        .custom-table thead {
            background-color: #343a40;
            color: #ffffff;
        }

        .custom-table th,
        .custom-table td {
            padding: 12px;
            text-align: center;
            vertical-align: middle;
        }

        .custom-table tbody tr:hover {
            background-color: #f1f1f1;
            transition: 0.3s;
        }

        .custom-table img {
            width: 60px;
            border-radius: 8px;
        }

        .btn-action {
            margin: 2px;
            font-size: 14px;
        }

        /* Styling Form Filter */
        .form-container {
            background: #ffffff;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-wrap: wrap;
            /* Responsif di layar kecil */
        }

        /* Label Styling */
        .form-label {
            font-size: 14px;
            color: #495057;
        }

        /* Input dan Select Styling */
        .form-control,
        .form-select {
            padding: 10px;
            border-radius: 8px;
            border: 1px solid #ced4da;
            transition: border 0.3s ease;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #198754;
            box-shadow: 0 0 8px rgba(25, 135, 84, 0.3);
        }

        /* Button Styling */
        .btn-success {
            padding: 10px 16px;
            font-size: 14px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
            /* Jarak antara ikon dan teks */
            transition: background-color 0.3s ease;
        }

        .btn-success:hover {
            background-color: #157347;
        }

        /* Responsif di Layar Kecil */
        @media (max-width: 576px) {
            .form-container {
                flex-direction: column;
                gap: 12px;
            }

            .btn-success {
                width: 100%;
                justify-content: center;
                /* Tombol di tengah */
            }
        }
    </style>
</head>

<body>
    @include('admin.sidebar')
    <div id="page-content-wrapper">
        @include('admin.navbar')

        <div class="container mt-4">
            <h2 class="mb-4">Arsip Peminjaman</h2>

            <form method="GET" action="{{ route('admin.arsip') }}" class="form-container d-flex align-items-center gap-3 mb-4 flex-wrap">
    <!-- Menyimpan Parameter Sortir -->
    <input type="hidden" name="sort" value="{{ request('sort', 'created_at') }}">
    <input type="hidden" name="order" value="{{ request('order', 'desc') }}">

    <!-- Pilih Genre -->
    <div class="flex-grow-1">
        <label for="category" class="form-label fw-semibold">Pilih Genre</label>
        <select name="category" id="category" class="form-select shadow-sm">
            <option value="">Pilih Genre</option>
            @foreach($category as $cat)
                <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                    {{ $cat->cat_title }}
                </option>
            @endforeach
        </select>
    </div>

    <!-- Tanggal Mulai -->
    <div>
        <label for="start_date" class="form-label fw-semibold">Tanggal Mulai</label>
        <input type="date" id="start_date" name="start_date" class="form-control shadow-sm" value="{{ request('start_date') }}">
    </div>

    <!-- Tanggal Akhir -->
    <div>
        <label for="end_date" class="form-label fw-semibold">Tanggal Akhir</label>
        <input type="date" id="end_date" name="end_date" class="form-control shadow-sm" value="{{ request('end_date') }}">
    </div>

    <!-- Tombol Perbarui -->
    <button type="submit" name="action" value="update" class="btn btn-primary shadow-sm mt-4 mt-sm-0">
        <i class="fas fa-sync-alt me-2"></i>Perbarui Tampilan
    </button>

    <!-- Tombol Download -->
    <button type="submit" name="action" value="download" class="btn btn-success shadow-sm mt-4 mt-sm-0">
        <i class="fas fa-download me-2"></i>Download Arsip
    </button>
</form>


            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama User</th>
                        <th>Email User</th>
                        <th>Judul Buku</th>
                        <th>Genre</th>
                        <th>Tanggal Pengambilan</th>
                        <th>Tanggal Pengembalian</th>
                        <th>Durasi Pinjam</th>
                        <th>Dibuat Pada</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($arsip as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->nama_user }}</td>
                        <td>{{ $item->email_user }}</td>
                        <td>{{ $item->judul_buku }}</td>

                        <!-- Menampilkan genre dengan aman -->
                        <td>{{ optional($item->book->category)->cat_title ?? 'Tidak Ada Kategori' }}</td>

                        <td>{{ $item->tanggal_pengambilan }}</td>
                        <td>{{ $item->tanggal_pengembalian }}</td>
                        <td>{{ $item->durasi_pinjam }} hari</td>
                        <td>{{ $item->created_at->format('d-m-Y H:i') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center">Tidak ada data arsip</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="pagination">
                {{ $arsip->appends(request()->query())->links() }}
            </div>


        </div>

        @include('admin.footer')
    </div>

    <!-- JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#archiveTable').DataTable({
                responsive: true,
                paging: false, // Menggunakan pagination bawaan Laravel
                language: {
                    search: "Cari:",
                    lengthMenu: "Tampilkan _MENU_ entri",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
                    paginate: {
                        previous: "Sebelumnya",
                        next: "Berikutnya"
                    }
                }
            });
        });
    </script>
</body>

</html>