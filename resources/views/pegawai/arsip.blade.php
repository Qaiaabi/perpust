<!DOCTYPE html>
<html lang="id">

<head>
    @include('pegawai.css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
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

        .table-container {
            overflow-x: auto;
            border-radius: 12px;
        }

        .custom-table {
            width: 100%;
            border-collapse: collapse;
            overflow: hidden;
            background-color: #fff;
            border-radius: 12px;
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

        .status-badge {
            padding: 6px 12px;
            border-radius: 8px;
            font-weight: 500;
        }

        .btn-action {
            margin: 2px;
            font-size: 14px;
        }
    </style>
</head>

<body>
    @include('pegawai.sidebar')
    <div id="page-content-wrapper">
        @include('pegawai.navbar')

        <div class="container mt-4">
            <h2>Arsip Peminjaman</h2>

            <!-- Form Pencarian -->
            <form method="GET" action="{{ route('pegawai.arsip') }}" class="mb-3">
                <input type="text" name="search" class="form-control d-inline-block w-50" placeholder="Cari nama, email, atau judul buku..." value="{{ request('search') }}">
                <button type="submit" class="btn btn-primary">Cari</button>
            </form>

            <!-- Tabel Data -->
            <table class="table custom-table table-bordered table-striped">
                <thead>
                    <tr>
                        <th><a href="?sort=id&order={{ $sort === 'id' && $order === 'asc' ? 'desc' : 'asc' }}">ID</a></th>
                        <th><a href="?sort=nama_user&order={{ $sort === 'nama_user' && $order === 'asc' ? 'desc' : 'asc' }}">Nama User</a></th>
                        <th>Email</th>
                        <th>Judul Buku</th>
                        <th>Tanggal Pengambilan</th>
                        <th>Tanggal Pengembalian</th>
                        <th>Durasi Pinjam</th>
                        <th>Dibuat Pada</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($arsip as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->nama_user }}</td>
                        <td>{{ $item->email_user }}</td>
                        <td>{{ $item->judul_buku }}</td>
                        <td>{{ $item->tanggal_pengambilan }}</td>
                        <td>{{ $item->tanggal_pengembalian }}</td>
                        <td>{{ $item->durasi_pinjam }} hari</td>
                        <td>{{ $item->created_at->format('d-m-Y H:i') }}</td>
                        <th>
                        <form action="{{ route('emp_hapus_arsip', $item->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-danger btn-sm btn-action">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </form>
                        </th>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center">Tidak ada data arsip</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination -->
            {{ $arsip->appends(request()->query())->links() }}
        </div>
        @include('pegawai.footer')
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#booksTable').DataTable({
                responsive: true,
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