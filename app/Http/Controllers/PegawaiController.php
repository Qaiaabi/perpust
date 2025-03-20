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

class PegawaiController extends Controller
{
    public function emp_category_page(Request $request)
    {
        $data = Category::orderBy('created_at', 'desc')->get(); // Urutkan dari yang terbaru
        return view('pegawai.category', compact('data'));
    }
    public function emp_add_category(Request $request)
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

        return redirect()->back()->with('success', 'Kategori berhasil ditambahkan oleh pegawai.');
    }

    //fungsi untuk menghapus kategori
    public function emp_cat_delete($id)
    {
        $data = Category::find($id);

        if ($data) {
            $data->delete();
            return redirect()->back()->with('success', 'Kategori berhasil dihapus!');
        }

        return redirect()->back()->with('error', 'Kategori tidak ditemukan.');
    }
    public function emp_edit_category($id)
    {
        $data = category::find($id);
        return view('pegawai.edit_category', compact('data'));
    }
    public function emp_update_category(Request $request, $id)
    {
        $data = Category::find($id);
        $data->cat_title = $request->cat_name;
        $data->save();
        return redirect('/emp_category_page')->with('message', 'Kategori berhasil di edit!');
    }




    public function emp_add_book()
    {
        $data = category::all();
        return view('pegawai.add_book', compact('data'));
    }

    public function emp_upload_book(Request $request)
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

        return redirect()->route('emp_view_books')->with('success', 'Buku berhasil ditambahkan!');
    }

    public function emp_view_books()
    {
        $books = Book::with('category')->orderBy('created_at', 'desc')->get();
        return view('pegawai.view_books', compact('books'));
    }

    public function emp_delete_book(Request $request, $id)
    {
        $book = Book::findOrFail($id);

        // Hapus gambar jika ada
        if ($book->book_img && file_exists(public_path($book->book_img))) {
            unlink(public_path($book->book_img));
        }

        $book->delete();

        return response()->json(['success' => true, 'message' => 'Buku berhasil dihapus!']);
    }

    public function emp_edit_book($id)
    {
        $data = Book::findOrFail($id);
        $categories = Category::all();
        return view('pegawai.edit_book', compact('data', 'categories'));
    }

    public function emp_update_book(Request $request, $id)
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

        return redirect()->route('emp_view_books')->with('success', 'Buku berhasil diperbarui!');
    }


    public function emp_viewPegawai()
    {
        // Ambil semua user dengan usertype 'pegawai'
        $pegawai = User::where('usertype', 'pegawai')->get();

        // Kirim data ke view
        return view('pegawai.view_pegawai', compact('pegawai'));
    }

    public function emp_request()
    {
        // Pastikan memuat relasi 'book'
        $data = Borrow::with('book')->get();
        return view('pegawai.request', compact('data'));
    }


    public function emp_disetujui($id)
    {
        $data = Borrow::find($id);

        if (!$data) {
            return redirect()->back()->with('error', 'Data tidak ditemukan');
        }

        $data->status = 'Menunggu pengambilan';
        $data->save();

        return redirect()->back()->with('success', 'Status berhasil diperbarui menjadi Menunggu Pengambilan');
    }

    public function emp_diambil($id)
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
    public function emp_dikembalikan($id)
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

    public function emp_arsip(Request $request)
    {
        $query = Archive::with(['user', 'book']);
        // Fitur Pencarian
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_user', 'like', "%$search%")
                    ->orWhere('email_user', 'like', "%$search%")
                    ->orWhere('judul_buku', 'like', "%$search%");
            });
        }
        // Fitur Sortir
        $sort = $request->get('sort', 'created_at'); // Default sorting by created_at
        $order = $request->get('order', 'desc'); // Default descending order
        $query->orderBy($sort, $order);
        // Pagination
        $arsip = $query->paginate(10);
        return view('pegawai.arsip', compact('arsip', 'sort', 'order'));
    }

    public function emp_hapus_Arsip($id)
    {
        $arsip = Archive::find($id);
        if (!$arsip) {
            return redirect()->back()->with('error', 'Data arsip tidak ditemukan.');
        }
        $arsip->delete();
        return redirect()->back()->with('success', 'Arsip berhasil dihapus.');
    }

    public function emp_laporan()
    {
        return view('pegawai.laporan');
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
            'name',
            'email',
            'phone',
            'address',
            'created_at'
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
    public function downloadArchiveReport()
    {
        $archives = Borrow::with(['user', 'book'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Debugging: Cek apakah data relasi sudah diambil
        // dd($archives);

        $pdf = Pdf::loadView('pdf.archive_report', compact('archives'))->setPaper('a4', 'landscape');
        return $pdf->download('laporan_arsip.pdf');
    }
}
