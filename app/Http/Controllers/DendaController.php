<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Borrow;
use App\Models\Archive;
use App\Models\Book;
use App\Models\Category;
use Carbon\Carbon;

class DendaController extends Controller
{
    public function index()
    {
        $dendaList = Borrow::with(['user', 'book'])
            ->where('status', 'dipinjam')
            ->where('returned_at', '<', now())
            ->get()
            ->map(function ($borrow) {
                $today = Carbon::now();
                $returnedAt = Carbon::parse($borrow->returned_at);

                // Hitung denda (Rp 10.000 per hari keterlambatan)
                if ($today->greaterThan($returnedAt)) {
                    $lateDays = $today->diffInDays($returnedAt);
                    $borrow->setAttribute('denda', $lateDays * 10000);
                } else {
                    $borrow->setAttribute('denda', 0);
                }

                $borrow->setAttribute('formatted_denda', number_format($borrow->denda, 0, ',', '.'));
                return $borrow;
            });

        // dd($dendaList);


        return view('admin.denda', compact('dendaList'));
    }
    public function lunasDenda($id)
    {
        $borrow = Borrow::with(['user', 'book'])->findOrFail($id);

        // Pindahkan data ke tabel arsip
        Archive::create([
            'user_id' => $borrow->user_id,
            'nama_user' => $borrow->user->name,
            'email_user' => $borrow->user->email,
            'book_id' => $borrow->book_id,
            'judul_buku' => $borrow->book->judul,
            'tanggal_pengambilan' => $borrow->borrow_at,
            'tanggal_pengembalian' => $borrow->returned_at,
            'durasi_pinjam' => now()->diffInDays($borrow->borrow_at),
        ]);

        // Hapus data dari tabel borrow
        $borrow->delete();

        return redirect()->back()->with('success', 'Denda telah dilunasi dan dipindahkan ke arsip.');
    }
}    