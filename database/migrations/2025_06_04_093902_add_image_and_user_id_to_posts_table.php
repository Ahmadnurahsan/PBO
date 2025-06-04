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
    {
        Schema::table('posts', function (Blueprint $table) {
            // Tambahkan kolom user_id setelah kolom id (atau sesuaikan posisinya)
            // Pastikan tabel 'users' dan kolom 'id' di tabel 'users' sudah ada
            $table->foreignId('user_id')
                  ->after('id') // Opsional: untuk mengatur posisi kolom
                  ->constrained() // Ini mengasumsikan ada tabel 'users' dengan kolom 'id'
                  ->onDelete('cascade'); // Jika user dihapus, post terkait juga dihapus

            // Tambahkan kolom image setelah kolom content (atau sesuaikan posisinya)
            $table->string('image')
                  ->after('content') // Opsional: untuk mengatur posisi kolom
                  ->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            // Urutan drop foreign key dan kolom penting
            $table->dropForeign(['user_id']); // Hapus constraint foreign key dulu
            $table->dropColumn('user_id');    // Baru hapus kolomnya
            $table->dropColumn('image');
        });
    }
};