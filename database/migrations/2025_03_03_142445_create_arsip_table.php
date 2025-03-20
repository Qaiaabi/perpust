<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('arsip', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('nama_user');
            $table->string('email_user');
            $table->unsignedBigInteger('book_id');
            $table->string('judul_buku');
            $table->timestamp('tanggal_pengambilan');
            $table->timestamp('tanggal_pengembalian');
            $table->integer('durasi_pinjam');
            $table->timestamps();

            

            // Foreign keys
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('book_id')->references('id')->on('books')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('arsip');
    }
};
