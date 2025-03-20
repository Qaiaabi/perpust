<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Borrow extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'book_id', 'status', 'created_at', 'updated_at', 'returned_at'];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Book (menggunakan book_id)
    public function book()
    {
        return $this->belongsTo(Book::class, 'book_id');
    }
}