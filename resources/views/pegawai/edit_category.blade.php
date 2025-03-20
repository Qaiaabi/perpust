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
    @include('pegawai.sidebar')

    <!-- Page Content -->
    <div id="page-content-wrapper">
        @include('pegawai.navbar')

        <!-- Content -->
        <div class="container mt-4">
            <div class="row justify-content-center">
                <div class="col-md-10"> <!-- Lebar kolom diperbesar dari col-md-8 ke col-md-10 -->
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
                        <form action="{{ url('emp_update_category', $data->id) }}" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="category">Nama Kategori</label>
                                <input type="text" class="form-control" name="cat_name" value="{{ $data->cat_title }}" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Tambah Kategori</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>