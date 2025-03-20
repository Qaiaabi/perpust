<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('borrows', function (Blueprint $table) {
            $table->timestamp('returned_at')->nullable(); // Bisa NULL jika buku belum dikembalikan
        });
    }

    /**
 * Reverse the migrations.
 */
public function down()
{
    Schema::table('borrows', function (Blueprint $table) {
        $table->dropColumn('returned_at'); // Menghapus kolom returned_at jika rollback dilakukan
    });
}

};
