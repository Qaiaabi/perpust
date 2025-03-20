<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;


use Illuminate\Http\Request;

use App\Models\User;
use App\Models\book;
use App\Models\Borrow;
use App\Models\Archive;
use App\Models\Category;
use GuzzleHttp\Psr7\Message;
use Illuminate\Support\Facades\Auth;
use DateTime;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel; 


class AdminController extends Controller
{
    public function index()
    {
        if (Auth::id()) // Memeriksa apakah user sudah login
        {
            $user_type = Auth()->user()->usertype; // Mengambil usertype dari user yang login
            $totalPengguna = User::where('usertype', 'user')->count();
            $totalpegawai = User::where('usertype', 'pegawai')->count();
            $totalbuku = book::count();

            if ($user_type == 'admin') {
                return view("admin.index", compact("totalPengguna", "totalpegawai", "totalbuku")); // Mengarahkan ke view admin.index jika usertype adalah admin
            } else if ($user_type == 'pegawai') {
                return view("pegawai.index",compact("totalPengguna", "totalpegawai", "totalbuku")); // Mengarahkan ke view pegawai.index jika usertype adalah pegawai
            } else if ($user_type == 'user') {
                return redirect()->action([HomeController::class, 'index']); // Memanggil method index di HomeController                
            } else {
                return redirect()->back()->with('error', 'Usertype tidak valid.'); // Jika usertype tidak dikenali, kembalikan ke halaman sebelumnya dengan pesan error
            }
        }
    }
    public function content()
    {
        // Hitung jumlah user dengan usertype 'user'

        // Kirim variabel ke view 'admin.content'
        return view('admin.content', compact("totalPengguna"));
    }
    public function category_page(Request $request)
    {
        $data = Category::orderBy('created_at', 'desc')->get(); // Urutkan dari yang terbaru
        return view('admin.category', compact('data'));
    }
    public function add_category(Request $request)
    {
        // Validasi input
        $request->validate([
            'category' => 'required|string|max:255',
        ]);

        // Periksa apakah kategori sudah ada (case-insensitive)
        $existingCategory = Category::whereRaw('LOWER(cat_title) = ?', [strtolower($request->category)])->first();

        if ($existingCategory) {
            return redirect()->back()->with('error', 'Kategori sudah ada!');
        }

        // Simpan kategori jika belum ada
        $data = new Category;
        $data->cat_title = $request->category;
        $data->save();

        return redirect()->back()->with('success', 'Kategori berhasil ditambahkan.');
    }

    //fungsi untuk menghapus kategori
    public function cat_delete($id)
    {
        $data = Category::find($id);

        if ($data) {
            $data->delete();
            return redirect()->back()->with('success', 'Kategori berhasil dihapus!');
        }

        return redirect()->back()->with('error', 'Kategori tidak ditemukan.');
    }
    public function edit_category($id)
    {
        $data = category::find($id);
        return view('admin.edit_category', compact('data'));
    }
    public function update_category(Request $request, $id)
    {
        $data = Category::find($id);
        $data->cat_title = $request->cat_name;
        $data->save();
        return redirect('/category_page')->with('message', 'Kategori berhasil di edit!');
    }


    public function viewPegawai()
    {
        // Ambil semua user dengan usertype 'pegawai'
        $pegawai = User::where('usertype', 'pegawai')->get();

        // Kirim data ke view
        return view('admin.view_pegawai', compact('pegawai'));
    }
    public function create()
    {
        return view('admin.add_pegawai');
    }

    // Menyimpan data pegawai
    public function store(Request $request)
    {
        // Validasi data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'phone' => 'nullable|string|max:15',
            'address' => 'nullable|string|max:255',
            'password' => 'required|string|min:8|confirmed',
            'usertype' => 'required|in:pegawai',
        ]);

        // Simpan data ke tabel users
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'password' => Hash::make($request->password),
            'usertype' => $request->usertype,
        ]);

        // Redirect ke halaman view_pegawai dengan pesan sukses
        return redirect()->route('admin.view_pegawai')->with('success', 'Pegawai berhasil ditambahkan!');
    }
    public function editPegawai($id)
    {
        $pegawai = User::where('usertype', 'pegawai')->findOrFail($id);
        return view('admin.edit_pegawai', compact('pegawai'));
    }

    // Menyimpan Perubahan Data Pegawai
    public function updatePegawai(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:15',
            'address' => 'nullable|string',
        ]);

        $pegawai = User::where('usertype', 'pegawai')->findOrFail($id);
        $pegawai->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        return redirect()->route('admin.view_pegawai')->with('success', 'Data pegawai berhasil diperbarui!');
    }public function hapusPegawai($id)
    {
        $pegawai = User::where('usertype', 'pegawai')->findOrFail($id);
        $pegawai->delete();

        return redirect()->route('admin.view_pegawai')->with('success', 'Pegawai berhasil dihapus!');
    }




    public function add_book()
    {
        $data = category::all();
        return view('admin.add_book', compact('data'));
    }

    public function upload_book(Request $request)
    {
        $data = new Book;
        $data->judul = $request->judul;
        $data->penulis = $request->penulis;
        $data->penerbit = $request->penerbit;
        $data->deskripsi = $request->deskripsi;
        $data->tahun_terbit = $request->tahun_terbit;
        $data->category_id = $request->kategori;
        $data->stock = $request->stock;

        // Simpan gambar jika ada
        if ($request->hasFile('book_img')) {
            $file = $request->file('book_img');
            $filename = time() . '_' . $file->getClientOriginalName();

            // Pastikan folder ada
            $destinationPath = public_path('uploads/book_images');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            $file->move($destinationPath, $filename);
            $data->book_img = 'uploads/book_images/' . $filename; // Perbaikan path
        }

        $data->save();

        return redirect()->route('view_books')->with('success', 'Buku berhasil ditambahkan!');
    }

    public function view_books()
    {
        $books = Book::with('category')->orderBy('created_at', 'desc')->get();
        return view('admin.view_books', compact('books'));
    }

    public function delete_book(Request $request, $id)
{
    try {
        $book = Book::findOrFail($id);

        // Hapus gambar jika ada
        if ($book->book_img && file_exists(public_path($book->book_img))) {
            unlink(public_path($book->book_img));
        }

        $book->delete();

        return response()->json(['success' => true, 'message' => 'Buku berhasil dihapus!']);
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => 'Gagal menghapus buku!']);
    }
}


    public function edit_book($id)
    {
        $data = Book::findOrFail($id);
        $categories = Category::all();
        return view('admin.edit_book', compact('data', 'categories'));
    }

    public function update_book(Request $request, $id)
    {
        $data = Book::findOrFail($id);

        $data->judul = $request->judul;
        $data->penulis = $request->penulis;
        $data->penerbit = $request->penerbit;
        $data->deskripsi = $request->deskripsi;
        $data->tahun_terbit = $request->tahun_terbit;
        $data->stock = $request->stock;
        $data->category_id = $request->kategori;

        // Update gambar jika ada file baru
        if ($request->hasFile('book_img')) {
            // Hapus gambar lama jika ada
            if ($data->book_img && file_exists(public_path($data->book_img))) {
                unlink(public_path($data->book_img));
            }

            $file = $request->file('book_img');
            $filename = time() . '_' . $file->getClientOriginalName();

            // Pastikan folder ada
            $destinationPath = public_path('uploads/book_images');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            $file->move($destinationPath, $filename);
            $data->book_img = 'uploads/book_images/' . $filename;
        }

        $data->save();

        return redirect()->route('view_books')->with('success', 'Buku berhasil diperbarui!');
    }

    public function request()
    {
        // Pastikan memuat relasi 'book'
        $data = Borrow::with('book')->get();
        return view('admin.request', compact('data'));
    }

    public function disetujui($id)
    {
        $data = Borrow::find($id);

        if (!$data) {
            return redirect()->back()->with('error', 'Data tidak ditemukan');
        }

        $data->status = 'Menunggu pengambilan';
        $data->save();

        return redirect()->back()->with('success', 'Status berhasil diperbarui menjadi Menunggu Pengambilan');
    }

    public function diambil($id)
    {
        $data = Borrow::with('book')->findOrFail($id); // Ambil data peminjaman dan relasi bukunya
        if (!$data) {
            return redirect()->back()->with('error', 'Data peminjaman tidak ditemukan');
        }
        $book = $data->book;
        if ($book->stock > 0) {
            $book->stock -= 1; // Kurangi stok buku
            $book->save(); // Simpan perubahan stok
        } else {
            return redirect()->back()->with('error', 'Stok buku habis');
        }
        $data->status = 'Dipinjam'; // Ubah status menjadi dipinjam
        $data->save();
        return redirect()->back()->with('success', 'Buku berhasil diambil dan stok berkurang.');
    }
    public function dikembalikan($id)
    {
        $data = Borrow::with('book', 'user')->findOrFail($id);
        if ($data->status !== 'Dipinjam') {
            return redirect()->back()->with('error', 'Buku sudah dikembalikan atau status tidak valid.');
        }
        $book = $data->book;
        $book->stock += 1; // Tambahkan kembali stok buku
        $book->save();
        $user = $data->user;
        // Hitung durasi peminjaman dalam hari
        $durasi = $data->created_at->diffInDays(now());
        // Pindahkan data ke arsip
        Archive::create([
            'user_id' => $user->id,
            'nama_user' => $user->name,
            'email_user' => $user->email,
            'book_id' => $book->id,
            'judul_buku' => $book->judul,
            'tanggal_pengambilan' => $data->created_at,
            'tanggal_pengembalian' => now(),
            'durasi_pinjam' => $durasi
        ]);
        // Hapus data dari tabel borrow
        $data->delete();
        return redirect()->back()->with('success', 'Buku berhasil dikembalikan dan masuk ke arsip.');
    }


    public function hapus_Arsip($id)
    {
        $arsip = Archive::find($id);
        if (!$arsip) {
            return redirect()->back()->with('error', 'Data arsip tidak ditemukan.');
        }
        $arsip->delete();
        return redirect()->back()->with('success', 'Arsip berhasil dihapus.');
    }

    public function laporan()
    {
        return view('admin.laporan');
    }
    public function downloadBooks()
    {
        $books = Book::with('category')->get(); // Ambil data buku + kategori
    
        $pdf = Pdf::loadView('pdf.books', compact('books'))->setPaper('a4', 'landscape');
    
        return $pdf->download('data_buku.pdf');
    }
    
    public function downloadEmployees()
{
    // Ambil semua data pegawai (usertype = pegawai) beserta semua kolom
    $employees = User::where('usertype', 'pegawai')->get();

    $pdf = Pdf::loadView('pdf.employees', compact('employees'))->setPaper('a4', 'landscape');

    return $pdf->download('data_pegawai.pdf');
}

public function downloadUserReport()
{
    $users = User::where('usertype', 'user')->get([
        'name', 'email', 'phone', 'address', 'created_at'
    ]);

    $pdf = Pdf::loadView('pdf.user_report', compact('users'))->setPaper('a4', 'landscape');

    return $pdf->download('laporan_user.pdf');
}
public function downloadBorrowReport()
{
    $borrows = Borrow::with(['user', 'book'])
                ->orderBy('created_at', 'desc')
                ->get([
                    'user_id',
                    'book_id',
                    'status',
                    'created_at',
                    'returned_at'
                ]);

    $pdf = Pdf::loadView('pdf.borrow_report', compact('borrows'))->setPaper('a4', 'landscape');

    return $pdf->download('laporan_peminjaman.pdf');

    }




public function arsip(Request $request)
{
    $query = Archive::with(['user', 'book.category']);

    // ✅ Filter berdasarkan Genre
    if ($request->filled('category')) {
        $query->whereHas('book.category', function ($q) use ($request) {
            $q->where('id', $request->category);
        });
    }

    // ✅ Filter Tanggal
    if ($request->filled('start_date') && $request->filled('end_date')) {
        $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
    }

    // ✅ Fitur Sortir
    $sort = $request->get('sort', 'created_at');
    $order = $request->get('order', 'desc');
    $query->orderBy($sort, $order);

    // ✅ Cek aksi dari form (download atau update tampilan)
    if ($request->action === 'download') {
        return $this->downloadReport($query->get());
    }

    // ✅ Ambil data arsip untuk tampilan
    $arsip = $query->paginate(10);
    $category = Category::all();

    return view('admin.arsip', compact('category', 'arsip', 'sort', 'order'));
}

// ✅ Fungsi untuk Download Data
protected function downloadReport($arsip)
{
    // Contoh sederhana untuk download dalam format CSV
    $filename = 'arsip-' . now()->format('YmdHis') . '.csv';
    $headers = ['Content-Type' => 'text/csv'];
    
    $callback = function() use ($arsip) {
        $file = fopen('php://output', 'w');
        fputcsv($file, ['ID', 'Nama User', 'Email User', 'Judul Buku', 'Genre', 'Tanggal Pengambilan', 'Tanggal Pengembalian', 'Durasi Pinjam', 'Dibuat Pada']);

        foreach ($arsip as $item) {
            fputcsv($file, [
                $item->id,
                $item->nama_user,
                $item->email_user,
                $item->judul_buku,
                optional($item->book->category)->cat_title ?? 'Tidak Ada Kategori',
                $item->tanggal_pengambilan,
                $item->tanggal_pengembalian,
                $item->durasi_pinjam . ' hari',
                $item->created_at->format('d-m-Y H:i'),
            ]);
        }

        fclose($file);
    };

    return response()->stream($callback, 200, [
        'Content-Disposition' => "attachment; filename={$filename}",
        'Cache-Control' => 'no-cache, must-revalidate',
        'Expires' => '0',
    ]);
}

}