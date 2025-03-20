<!DOCTYPE html>
<html lang="id">

<head>
    @include('admin.css')
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome untuk ikon -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <style>
        /* Custom CSS untuk form tanpa card */
        .form-header {
            background-color: #f8f9fa;
            color: #333;
            padding: 15px;
            border-radius: 10px 10px 0 0;
            border: 2px solid #ddd;
            /* Border lebih tebal */
        }

        .form-container {
            border: 2px solid #ddd;
            /* Border lebih tebal */
            border-radius: 0 0 10px 10px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }

        .form-group label {
            font-weight: 500;
            color: #333;
        }

        .form-control {
            border-radius: 5px;
            border: 2px solid #ddd;
            /* Border lebih tebal */
            padding: 10px;
            font-size: 14px;
        }

        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }

        .btn-primary {
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            font-size: 14px;
            font-weight: bold;
            transition: background 0.3s ease;
        }

        .alert-success {
            border-radius: 5px;
            background-color: #d4edda;
            border-color: #c3e6cb;
            color: #155724;
            padding: 10px;
            margin-bottom: 20px;
        }

        /* Custom CSS untuk tabel */
        .custom-table {
            width: 100%;
            /* Lebar tabel 100% */
            border-collapse: collapse;
            margin-top: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            overflow: hidden;
            border: 2px solid #ddd;
            /* Border lebih tebal */
        }

        .custom-table th,
        .custom-table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 2px solid #ddd;
            /* Border lebih tebal */
        }

        .custom-table th {
            background-color: #f8f9fa;
            color: #333;
            font-weight: bold;
            border: 2px solid #ddd;
            /* Border lebih tebal */
        }
    </style>
</head>

<body>
    @include('admin.sidebar')

    <!-- Page Content -->
    <div id="page-content-wrapper">
        @include('admin.navbar')

        <!-- Content -->
        <div class="container mt-4">
            <div class="row justify-content-center">
                <div class="col-md-10"> <!-- Lebar kolom diperbesar dari col-md-8 ke col-md-10 -->
                    @if(session()->has('message'))
                    <div class="alert alert-success">
                        {{ session()->get('message') }}
                    </div>
                    @endif

                    @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                    @endif

                    @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif


                    <div class="form-header">
                        <h5 class="mb-0">Tambah Kategori</h5>
                    </div>
                    <div class="form-container">
                        <form action="{{ url('/add_category') }}" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="category">Nama Kategori</label>
                                <input type="text" class="form-control" id="category" name="category" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Tambah Kategori</button>
                        </form>
                    </div>

                    <br><br>
                    <!-- Tabel Kategori -->
                    <table id="categoryTable" class="display">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Kategori</th>
                                <th>Dibuat Pada</th>
                                <th>Diperbarui Pada</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $index => $category)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $category->cat_title }}</td>
                                <td>{{ $category->created_at->format('d-m-Y H:i') }}</td>
                                <td>{{ $category->updated_at->format('d-m-Y H:i') }}</td>

                                <td>
                                    <a href="{{ url('edit_category',$category->id) }}" class="btn btn-warning">
                                        <i class="fas fa-pencil"></i>
                                        Edit
                                    </a>
                                    <button class="btn btn-danger delete-btn" data-id="{{ $category->id }}">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </td>

                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>

        <!-- Footer -->
        @include('admin.footer')
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- jQuery & DataTables JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.delete-btn').click(function(e) {
                e.preventDefault(); // Hentikan aksi default

                const categoryId = $(this).data('id'); // Ambil ID kategori
                const deleteUrl = "{{ url('cat_delete') }}/" + categoryId; // Buat URL hapus

                Swal.fire({
                    title: 'Apakah kamu yakin?',
                    text: "Data yang dihapus tidak bisa dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = deleteUrl; // Redirect jika konfirmasi
                    }
                });
            });
        });
        $(document).ready(function() {
            $('#categoryTable').DataTable({
                order: [
                    [2, 'desc']
                ], // Urutkan berdasarkan kolom "Dibuat Pada" secara descending
                language: {
                    search: "Cari:",
                    lengthMenu: "Tampilkan _MENU_ data",
                    info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                    zeroRecords: "Kategori tidak ditemukan",
                    paginate: {
                        previous: "«",
                        next: "»"
                    }
                }
            });
        });
    </script>
</body>

</html>