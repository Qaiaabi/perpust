<!DOCTYPE html>
<html lang="id">

<head>
    @include('admin.css')
</head>

<body>
    @include('admin.sidebar')

    <!-- Page Content -->
    <div id="page-content-wrapper">
        @include('admin.navbar')


        <div class="container mt-5">
            <h2>Daftar Denda</h2>

            @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Peminjam</th>
                        <th>Judul Buku</th>
                        <th>Tanggal Kembali</th>
                        <th>Durasi</th>
                        <th>Denda (Rp)</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($dendaList as $index => $borrow)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $borrow->user->name }}</td>
                        <td>{{ $borrow->book->judul }}</td>
                        <td>{{ \Carbon\Carbon::parse($borrow->returned_at)->format('d-m-Y') }}</td>
                        <td>{{ now()->diffInDays($borrow->returned_at) }} hari</td>
                        <td>{{ $borrow->formatted_denda }}</td>
                        <td>
                            <form id="formLunas" method="POST" action="{{ route('lunas.denda', ['id' => $borrow->id]) }}">
                                @csrf
                                <button type="submit" class="btn btn-success">Lunas</button>
                            </form>
                            <form id="formLunas" method="POST" action="{{ route('lunas.denda', ['id' => $borrow->id]) }}">
                                @csrf
                                <button type="submit" class="btn btn-warning">Diganti BUku</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Footer -->
            @include('admin.footer')
        </div>
    </div>

    </script>


</body>

</html>