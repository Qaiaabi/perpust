<!DOCTYPE html>
<html lang="id">

<head>
    @include('admin.css')
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
    @include('admin.sidebar')
    <div id="page-content-wrapper">
        @include('admin.navbar')

        <div class="container mt-4">
            <div class="table-container">
                <table id="booksTable" class="table custom-table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Judul Buku</th>
                            <th>Jumlah</th>
                            <th>Gambar</th>
                            <th>Status</th>
                            <th>Validasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $index => $data)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $data->user->name }}</td>
                            <td>{{ $data->user->email }}</td>
                            <td>{{ $data->user->phone }}</td>
                            <td>{{ $data->book->judul }}</td>
                            <td>{{ $data->book->stock }}</td>
                            <td>
                                @if($data->book->book_img)
                                <img src="{{ asset($data->book->book_img) }}" alt="Cover Buku">
                                @else
                                <span class="text-muted">Tidak ada gambar</span>
                                @endif
                            </td>
                            <td>
                                <span class="status-badge bg-{{
                                    $data->status == 'Dibooking' ? 'primary' : (
                                    $data->status == 'Menunggu pengambilan' ? 'warning' : (
                                    $data->status == 'Dipinjam, menunggu pengembalian' ? 'danger' : 'success'))
                                }}">{{ $data->status }}</span>
                            </td>
                            <td>
                                <form action="{{ route('borrow.disetujui', $data->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-success btn-sm btn-action">
                                        <i class="fas fa-check"></i> Setuju
                                    </button>
                                </form>

                                <form action="{{ route('borrow.diambil', $data->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-warning btn-sm btn-action">
                                        <i class="fas fa-box"></i> Diambil
                                    </button>
                                </form>

                                <form action="{{ route('borrow.dikembalikan', $data->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-primary btn-sm btn-action">
                                        <i class="fas fa-undo"></i> Dikembalikan
                                    </button>
                                </form>

                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            
        </div>
    </div>   


    </div>   
        @include('admin.footer')
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