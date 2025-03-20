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
        /* Header Form */
        .form-header {
            background-color: #f8f9fa;
            color: #333;
            padding: 15px;
            border-radius: 10px 10px 0 0;
            border: 2px solid #ddd;
        }

        /* Container Form */
        .form-container {
            border: 2px solid #ddd;
            border-radius: 0 0 10px 10px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }

        /* Label */
        .form-group label {
            font-weight: 500;
            color: #333;
            margin-bottom: 5px;
        }

        /* Styling konsisten untuk input, select, dan textarea */
        .form-control,
        select.form-control {
            border-radius: 5px;
            border: 2px solid #ddd;
            padding: 10px;
            font-size: 14px;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .form-control:focus,
        select.form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }

        /* Tombol Submit */
        .btn-primary {
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            font-size: 14px;
            font-weight: bold;
            background-color: #007bff;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        /* Alert */
        .alert-success {
            border-radius: 5px;
            background-color: #d4edda;
            border-color: #c3e6cb;
            color: #155724;
            padding: 10px;
            margin-bottom: 20px;
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
    <h2>Edit Pegawai</h2>

    <form action="{{ route('admin.update_pegawai', $pegawai->id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Nama Pegawai -->
        <div class="mb-3">
            <label for="name" class="form-label">Nama Pegawai</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $pegawai->name }}" required>
        </div>

        <!-- Email -->
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ $pegawai->email }}" required>
        </div>

        <!-- No. HP -->
        <div class="mb-3">
            <label for="phone" class="form-label">No. HP</label>
            <input type="text" class="form-control" id="phone" name="phone" value="{{ $pegawai->phone ?? '' }}">
        </div>

        <!-- Alamat -->
        <div class="mb-3">
            <label for="address" class="form-label">Alamat</label>
            <textarea class="form-control" id="address" name="address" rows="3">{{ $pegawai->address ?? '' }}</textarea>
        </div>

        <!-- Tombol Submit -->
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        <a href="{{ route('admin.view_pegawai') }}" class="btn btn-secondary">Batal</a>
    </form>
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