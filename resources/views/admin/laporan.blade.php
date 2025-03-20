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
<!-- Content -->
<div class="container mt-4">
    <h2 class="text-center mb-4">Download Laporan</h2>

    <div class="d-flex flex-wrap justify-content-center gap-3">
        <a href="{{ route('admin.download.books') }}" class="btn btn-primary btn-lg">Download Data Buku</a>

        <a href="{{ route('download.pegawai') }}" class="btn btn-warning btn-lg">Download Data Pegawai</a>
        <a href="{{ route('download.user.report') }}" class="btn btn-info btn-lg">Download Laporan User</a>
        <a href="{{ route('download.borrow.report') }}" class="btn btn-dark btn-lg">Download Laporan Peminjaman</a>
        <a href="{{ route('download.archive.report') }}" class="btn btn-secondary btn-lg">Download Laporan Arsip</a>
    </div>
</div>

<style>
    @media (max-width: 576px) {
        .btn {
            width: 100%;
            text-align: center;
        }
    }
</style>


        <!-- Footer -->
        @include('admin.footer')
    </div>
</body>
</html>
