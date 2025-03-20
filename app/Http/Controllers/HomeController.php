<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Borrow;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    public function index()
    {
        // ✅ 1. Ambil data buku dan kategori
        $data = Book::orderBy('created_at', 'desc')->get();
        $fiksi = Book::whereHas('category', function ($query) {
            $query->where('cat_title', 'Fiksi');
        })->get();
        $non_fiksi = Book::whereHas('category', function ($query) {
            $query->where('cat_title', 'Non-Fiksi');
        })->get();

        // ✅ 2. Cek peminjaman user yang belum dikembalikan
        $user_id = Auth::id();
        $borrows = Borrow::where('user_id', $user_id)
            ->whereNull('returned_at') // Belum dikembalikan
            ->get();

        // ✅ 3. Notifikasi pengembalian hari ini atau besok
        $notifKembali = Borrow::where('user_id', $user_id)
            ->where(function ($query) {
                $query->whereDate('returned_at', Carbon::tomorrow())
                    ->orWhereDate('returned_at', Carbon::today());
            })->get()->map(function ($borrow) {
                $borrow->returned_at = Carbon::parse($borrow->returned_at);
                return $borrow;
            });

// ✅ Notifikasi denda (hanya untuk user yang login)
$dendaPerHari = 10000; // Denda Rp 10.000 per hari

$dendaNotif = Borrow::with('book') // Ambil relasi book agar bisa diakses di Blade
    ->where('user_id', Auth::id()) // Hanya denda milik user yang login
    ->where('status', 'Dipinjam') // Buku masih dalam status Dipinjam
    ->where('returned_at') // Belum dikembalikan
    ->whereNull('borrow_at', '<', now()) // Telah melewati tanggal pinjam
    ->get();

// Hitung denda dan tambahkan atribut dinamis
$dendaNotif->each(function ($borrow) use ($dendaPerHari) {
    $today = Carbon::now();
    $returnedAt = Carbon::parse($borrow->returned_at);

    // Hitung jumlah hari keterlambatan
    $telatHari = $today->diffInDays($returnedAt, true);

    // Tambahkan atribut denda dan formatted_denda secara dinamis
    $borrow->setAttribute('denda', $telatHari > 0 ? $telatHari * $dendaPerHari : 0);
    $borrow->setAttribute('formatted_denda', number_format($borrow->denda, 0, ',', '.'));
});

// ✅ Return ke view dengan semua data
return view('home.index', compact('data', 'fiksi', 'non_fiksi', 'borrows', 'notifKembali', 'dendaNotif'));


        }

    public function beranda()
    {
        return view('home.index');
    }
    public function borrow_books(Request $request)
    {
        $data = Book::find($request->book_id);
        if (!$data) {
            return redirect()->back()->with('message', 'Buku tidak ditemukan.');
        }

        if ($data->stock >= 1) {
            if (Auth::check()) {
                $user_id = Auth::id();

                // Cek apakah user sudah meminjam buku ini
                $existingBorrow = Borrow::where('book_id', $request->book_id)
                    ->where('user_id', $user_id)
                    ->whereNull('returned_at') // Pastikan belum dikembalikan
                    ->exists();

                if ($existingBorrow) {
                    return redirect()->back()->with('message', 'Kamu sudah meminjam buku ini. Kembalikan dulu sebelum meminjam lagi!');
                }

                // Simpan data peminjaman
                $borrow = new Borrow();
                $borrow->book_id = $request->book_id;
                $borrow->user_id = $user_id;
                $borrow->borrow_at = $request->borrow_at;      // Simpan tanggal peminjaman
                $borrow->returned_at = $request->returned_at;  // Simpan tanggal pengembalian
                $borrow->save();

                return redirect()->back()->with('success', 'Booking buku berhasil, Menunggu konfirmasi!');
            } else {
                return redirect('/login');
            }
        } else {
            return redirect()->back()->with('message', 'Bukunya tidak tersedia brok');
        }
    }


    public function book_history()
    {
        if (Auth::id()) { // Gunakan Auth::check() untuk memeriksa apakah pengguna sudah login
            $userid = Auth::id(); // Langsung ambil ID pengguna yang sedang login

            $data = Borrow::where('user_id', $userid)->get(); // Menggunakan $userid yang benar

            return view('home.book_history', compact('data'));
        }

        return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu'); // Redirect ke halaman login jika belum login
    }
    public function batal_pinjam($id)
    {
        $data = Borrow::find($id);

        if ($data) {
            $data->delete();
            return redirect()->back()->with('message', 'Peminjaman berhasil dibatalkan');
        }

        return redirect()->back()->with('error', 'Data tidak ditemukan');
    }
    public function search(Request $request)
{
    $query = $request->input('query');
    
    $data = Book::with('category')->orderBy('created_at', 'desc')->get();

    // ✅ Cari buku berdasarkan judul, deskripsi, atau kategori (genre)
    $books = Book::where('judul', 'like', "%$query%")
        ->orWhere('deskripsi', 'like', "%$query%")
        ->orWhereHas('category', function ($q) use ($query) {
            $q->where('cat_title', 'like', "%$query%");
        })
        ->with('category')
        ->paginate(20);
    $categories = Category::where('cat_title', 'like', "%$query%")->get();

    return view('home.book_all', compact('books', 'categories', 'query', 'data'));
}

}
