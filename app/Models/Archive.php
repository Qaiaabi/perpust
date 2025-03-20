<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Archive extends Model
{
    use HasFactory;

    public function user()
{
    return $this->belongsTo(User::class);
}

public function book()
{
    return $this->belongsTo(Book::class);
}

    protected $table = 'arsip'; // Nama tabel di database

    protected $fillable = [
        'user_id', 'nama_user', 'email_user', 'book_id', 'judul_buku', 
        'tanggal_pengambilan', 'tanggal_pengembalian', 'durasi_pinjam'
    ];
}
