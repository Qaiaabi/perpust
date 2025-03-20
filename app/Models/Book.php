<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = ['judul', 'stock', 'category_id', 'book_img'];

    
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    public function borrows()
    {
        return $this->hasMany(Borrow::class, 'book_id');
    }
}
