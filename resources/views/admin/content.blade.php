<div class="container-fluid p-4">
    <h2 class="mb-4">Dashboard Admin</h2>
    <div class="row">
        <div class="col-md-4">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h5 class="card-title">Total Pengguna</h5>
                    <p class="card-text">{{ $totalPengguna }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h5 class="card-title">Total Pegawai</h5>
                    <p class="card-text">{{ $totalpegawai }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <h5 class="card-title">Total Buku</h5>
                    <p class="card-text">{{ $totalbuku }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container mt-4">
    <h2 class="mb-4">Quick Actions</h2>
    <div class="row">
        <div class="col-md-4">
            <a href="{{ route('add_pegawai') }}">
                <button class="btn btn-primary w-100 d-flex align-items-center justify-content-center">
                    <i class="bi bi-people-fill me-2"></i> TAMBAH PEGAWAI
                </button>
            </a>
        </div>
        <div class="col-md-4">
            <a href="{{ url('add_book') }}">
                <button class="btn btn-success w-100 d-flex align-items-center justify-content-center">
                    <i class="bi bi-plus-lg me-2"></i> TAMBAH BUKU
                </button>
            </a>
        </div>
        <div class="col-md-4">
            <button class="btn btn-primary w-100 d-flex align-items-center justify-content-center">
                <i class="bi bi-file-earmark-text-fill me-2"></i> DOWNLOAD LAPORAN
            </button>
        </div>
    </div>
</div>
<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>