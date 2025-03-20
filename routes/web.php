<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ArchiveController;
use App\Http\Controllers\DendaController;

/*
|----------------------------------------------------------------------
| Web Routes
|----------------------------------------------------------------------
*/

// Route Home
Route::get('/', [HomeController::class, 'index']);

// Dashboard Route dengan Middleware
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

// Admin Routes
    // Halaman Admin
    Route::get('/home', [AdminController::class, 'index']);

    // Halaman Kategori
    Route::get('/category_page', [AdminController::class, 'category_page']);
    Route::post('/add_category', [AdminController::class, 'add_category']);
    Route::get('/cat_delete/{id}', [AdminController::class, 'cat_delete']);
    Route::get('/edit_category/{id}', [AdminController::class, 'edit_category']);
    Route::post('/update_category/{id}', [AdminController::class, 'update_category']);
    
    // Request dan Arsip
    Route::get('/request', [AdminController::class, 'request']);
    Route::get('/arsip', [AdminController::class, 'arsip'])->name('admin.arsip');

    // Laporan  
    Route::get('/laporan', [AdminController::class, 'laporan'])->name('laporan');

    // Buku
    Route::get('/add_book', [AdminController::class, 'add_book']);
    Route::post('/upload_book', [AdminController::class, 'upload_book']);
    Route::get('/view_books', [AdminController::class, 'view_books'])->name('view_books');

    Route::post('/delete_book/{id}', [AdminController::class, 'delete_book'])->name('delete_book');

    Route::get('/edit_book/{id}', [AdminController::class, 'edit_book'])->name('edit_book');
    Route::post('/update_book/{id}', [AdminController::class, 'update_book'])->name('update_book');
    
    // Pegawai
    Route::get('/add_pegawai', [AdminController::class, 'create'])->name('add_pegawai');
    Route::post('/upload_pegawai', [AdminController::class, 'store'])->name('add_pegawai.store');
    Route::get('/view_pegawai', [AdminController::class, 'viewPegawai'])->name('admin.view_pegawai');
    Route::get('/edit_pegawai/{id}', [AdminController::class, 'editPegawai'])->name('admin.edit_pegawai');
    Route::put('/update_pegawai/{id}', [AdminController::class, 'updatePegawai'])->name('admin.update_pegawai');
    Route::delete('/hapus_pegawai/{id}', [AdminController::class, 'hapusPegawai'])->name('admin.hapus_pegawai');
    
    // Download Laporan
    Route::get('/download-books', [AdminController::class, 'downloadBooks'])->name('admin.download.books');
    Route::get('/download-pegawai', [AdminController::class, 'downloadEmployees'])->name('download.pegawai');
    Route::get('/download-user-report', [AdminController::class, 'downloadUserReport'])->name('download.user.report');
    Route::get('/download-borrow-report', [AdminController::class, 'downloadBorrowReport'])->name('download.borrow.report');
    Route::get('/download-archive-report', [AdminController::class, 'downloadArchiveReport'])->name('download.archive.report');

    Route::get('/emp_category_page', [PegawaiController::class, 'emp_category_page']);
    Route::post('/emp_add_category', [PegawaiController::class, 'emp_add_category']);
    Route::get('/emp_cat_delete/{id}', [PegawaiController::class, 'emp_cat_delete']);
    Route::get('/emp_edit_category/{id}', [PegawaiController::class, 'emp_edit_category']);
    Route::post('/emp_update_category/{id}', [PegawaiController::class, 'emp_update_category']);

    Route::get('/emp_request', [PegawaiController::class, 'emp_request']);
    Route::get('/emp_arsip', [PegawaiController::class, 'emp_arsip']);
    Route::get('/emp_laporan', [PegawaiController::class, 'emp_laporan'])->name('emp_laporan');
    
    // Buku
    Route::get('/emp_add_book', [PegawaiController::class, 'emp_add_book']);
    Route::post('/emp_upload_book', [PegawaiController::class, 'emp_upload_book']);
    Route::get('/emp_view_books', [PegawaiController::class, 'emp_view_books'])->name('emp_view_books');
    Route::get('/emp_edit_book/{id}', [PegawaiController::class, 'emp_edit_book'])->name('emp_edit_book');
    Route::post('/emp_update_book/{id}', [PegawaiController::class, 'emp_update_book'])->name('emp_update_book');
    
    // Peminjaman
    Route::patch('/emp_disetujui/{id}', [PegawaiController::class, 'emp_disetujui'])->name('borrow.emp_disetujui');
    Route::patch('/emp_borrow/{id}/diambil', [PegawaiController::class, 'diambil'])->name('emp_borrow.diambil');
    Route::patch('/emp_borrow/{id}/dikembalikan', [PegawaiController::class, 'dikembalikan'])->name('emp_borrow.dikembalikan');
    Route::get('/emp_arsip', [PegawaiController::class, 'emp_arsip'])->name('pegawai.arsip');

// User Routes (Home)
Route::get('/index', [HomeController::class, 'index']);

// Fitur Peminjaman
Route::post('/borrow_books', [HomeController::class, 'borrow_books']);

Route::patch('/disetujui/{id}', [AdminController::class, 'disetujui'])->name('borrow.disetujui');
Route::patch('/borrow/{id}/diambil', [AdminController::class, 'diambil'])->name('borrow.diambil');
Route::patch('/borrow/{id}/dikembalikan', [AdminController::class, 'dikembalikan'])->name('borrow.dikembalikan');

// History dan Pembatalan Peminjaman
Route::get('book_history', [HomeController::class, 'book_history']);
Route::get('batal_pinjam/{id}', [HomeController::class, 'batal_pinjam']);

// Hapus Arsip
Route::patch('/hapus-arsip/{id}', [AdminController::class, 'hapus_Arsip'])->name('hapus_arsip');

Route::get('/denda', [DendaController::class, 'index'])->name('denda.index');
Route::post('/lunas-denda/{id}', [DendaController::class, 'lunasDenda'])->name('lunas.denda')
;Route::post('/ganti_buku/{id}', [DendaController::class, 'gantiBuku'])->name('ganti_buku');


    Route::get('/cari-buku', [HomeController::class, 'search'])->name('book.search');