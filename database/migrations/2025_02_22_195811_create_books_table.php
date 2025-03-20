<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    //>php artisan migrate:refresh --path=database/migrations/2025_02_22_195811_create_books_table.php 
    //jaga jaga kalau lupa cuy haha
    {
        Schema::create('books', function (Blueprint $table) {
        $table->id();
        $table->string('judul')->nullable();
        $table->string('penulis')->nullable();
        $table->string('penerbit')->nullable();
        $table->text('deskripsi')->nullable(); // Lebih baik gunakan text untuk deskripsi panjang
        $table->year('tahun_terbit')->nullable(); // Lebih semantik untuk tahun
        $table->integer('stock')->default(0); // Gunakan integer, bukan string
        $table->string('book_img')->nullable();
    
        $table->foreignId('category_id')->constrained()->onDelete('cascade');
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
