<!DOCTYPE html>
<html lang="id">

<head>
    @include('pegawai.css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">

    <style>
        .form-header {
            background-color: #007bff;
            color: #fff;
            padding: 20px;
            border-radius: 10px 10px 0 0;
            text-align: center;
        }

        .table-container {
            background-color: #fff;
            border-radius: 0 0 10px 10px;
            padding: 24px;
            box-shadow: 0 6px 14px rgba(0, 0, 0, 0.15);
            overflow-x: auto;
            max-width: 95%;
            margin: 0 auto;
        }

        .custom-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 15px;
        }

        .custom-table th,
        .custom-table td {
            padding: 14px 16px;
            text-align: center;
            word-wrap: break-word;
        }

        .custom-table th {
            background-color: #0056b3;
            color: #fff;
            font-weight: 600;
        }

        .custom-table img {
            max-width: 110px;
            height: auto;
            border-radius: 8px;
        }

        .action-buttons .btn {
            margin: 4px 2px;
            padding: 9px 14px;
            font-size: 14px;
        }

        .status-indicator {
            display: flex;
            justify-content: center;
            align-items: center;
            font-weight: 600;
        }

        .status-low {
            color: #dc3545;
        }

        .status-available {
            color: #28a745;
        }

        @media (max-width: 768px) {
            .form-header h5 {
                font-size: 16px;
            }

            .custom-table th,
            .custom-table td {
                font-size: 13px;
                padding: 12px 10px;
            }

            .custom-table img {
                max-width: 90px;
            }

            .action-buttons .btn {
                font-size: 12px;
                padding: 7px 10px;
            }
        }

        .add-book-btn {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #007bff;
            color: #fff;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 26px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            transition: background-color 0.3s ease, transform 0.2s ease;
            z-index: 1000;
        }

        .add-book-btn:hover {
            background-color: #0056b3;
            transform: scale(1.1);
        }
    </style>
</head>

<body>
    @include('pegawai.sidebar')

    <div id="page-content-wrapper">
        @include('pegawai.navbar')

        <div class="container mt-4">
            <div class="row justify-content-center">
                <div class="col-lg-12">

                    @if(session()->has('message'))
                    <div class="alert alert-success">{{ session()->get('message') }}</div>
                    @endif

                    @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <div class="form-header mb-3">
                        <h5 class="m-0">List Pegawai</h5>
                    </div>

                    <div class="table-container">

                        <a href="{{ url('add_pegawai') }}" class="add-book-btn" title="Tambah Buku">
                            <i class="fas fa-plus"></i>
                        </a>
                        <table class="table table-bordered mt-3 custom-table">
                            <thead class="table-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Nama Pegawai</th>
                                    <th>Email</th>
                                    <th>No. HP</th>
                                    <th>Alamat</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pegawai as $index => $p)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $p->name }}</td>
                                    <td>{{ $p->email }}</td>
                                    <td>{{ $p->phone ?? '-' }}</td>
                                    <td>{{ $p->address ?? '-' }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center">Belum ada pegawai.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>



        @include('pegawai.footer')
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

        $('.delete-book').on('click', function() {
            const bookId = $(this).data('id');

            Swal.fire({
                title: 'Yakin ingin menghapus buku ini?',
                text: "Tindakan ini tidak dapat dibatalkan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`{{ url('/delete_book') }}/${bookId}`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire({
                                    title: 'Terhapus!',
                                    text: data.message,
                                    icon: 'success',
                                    timer: 1500,
                                    showConfirmButton: false
                                });
                                setTimeout(() => location.reload(), 1600);
                            }
                        });
                }
            });
        });
    </script>
</body>

</html>