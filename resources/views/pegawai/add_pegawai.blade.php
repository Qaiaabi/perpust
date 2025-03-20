<!DOCTYPE html>
<html lang="id">

<head>
    @include('admin.css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        .form-header {
            background-color: #f8f9fa;
            color: #333;
            padding: 15px;
            border-radius: 10px 10px 0 0;
            border: 2px solid #ddd;
        }

        .form-container {
            border: 2px solid #ddd;
            border-radius: 0 0 10px 10px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }

        .form-group label {
            font-weight: 500;
            color: #333;
            margin-bottom: 5px;
        }

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

    <div id="page-content-wrapper">
        @include('admin.navbar')

        <div class="container mt-4">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                    @endif


                    <div class="form-header">
                        <h5 class="mb-0">Tambahkan Pegawai</h5>
                    </div>
                    <div class="form-container">
                        <form action="{{ route('add_pegawai.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="name">Nama Pegawai</label>
                                <input type="text" class="form-control" name="name" value="{{ old('name') }}" required>
                            </div>

                            <div class="form-group">
                                <label for="email">Email Pegawai</label>
                                <input type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                            </div>

                            <div class="form-group">
                                <label for="phone">No. HP (Opsional)</label>
                                <input type="text" class="form-control" name="phone" value="{{ old('phone') }}">
                            </div>

                            <div class="form-group">
                                <label for="address">Alamat (Opsional)</label>
                                <input type="text" class="form-control" name="address" value="{{ old('address') }}">
                            </div>

                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" name="password" required>
                            </div>

                            <div class="form-group">
                                <label for="password_confirmation">Konfirmasi Password</label>
                                <input type="password" class="form-control" name="password_confirmation" required>
                            </div>

                            <!-- Dropdown usertype -->
                            <div class="form-group">
                                <label for="usertype">Tipe Pengguna</label>
                                <select class="form-control" name="usertype" required>
                                    <option value="pegawai" selected>Pegawai</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary">Tambah Pegawai</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>

        @include('admin.footer')
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>