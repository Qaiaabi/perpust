<!DOCTYPE html>
<html lang="id">

<head>
    @include('pegawai.css')
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
    @include('pegawai.sidebar')

    <!-- Page Content -->
    <div id="page-content-wrapper">
        @include('pegawai.navbar')

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
                        <h5 class="mb-0">Tambahkan Buku</h5>
                    </div>
                    <div class="form-container">
                        <form action="{{ url('/emp_upload_book') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="judul">Judul Buku</label>
                                <input type="text" class="form-control" name="judul" required>
                            </div>
                            <div class="form-group">
                                <label for="kategori">Kategori</label>                       
                                <select name="kategori" required>
                                    @foreach ($data as $item)
                                        <option value="{{ $item->id }}">{{ $item->cat_title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="penulis">Penulis</label>
                                <input type="text" class="form-control" name="penulis" required>
                            </div>
                            <div class="form-group">
                                <label for="penerbit">Penerbit</label>
                                <input type="text" class="form-control" name="penerbit" required>
                            </div>
                            <div class="form-group">
                                <label for="deskripsi">Deskripsi</label>
                                <textarea class="form-control" name="deskripsi" rows="3" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="tahun_terbit">Tahun Terbit</label>
                                <input type="number" class="form-control" name="tahun_terbit" required>
                            </div>
                            <div class="form-group">
                                <label for="stock">Jumlah Buku</label>
                                <input type="number" class="form-control" name="stock" required>
                            </div>
                            <div class="form-group">
                                <label for="gambar">Gambar Buku</label>
                                <input type="file" class="form-control" name="book_img" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Tambah Kategori</button>
                        </form>
                    </div>

                </div>
            </div>
        </div>

        <!-- Footer -->
        @include('pegawai.footer')
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