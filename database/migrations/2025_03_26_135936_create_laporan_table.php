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
        Schema::create('laporan', function (Blueprint $table) {
            $table->id();
            $table->string('judul_laporan', 50);
            $table->string('deskripsi_laporan', 100);
            $table->date('tanggal_pelaporan');
            $table->string('tempat_kejadian', 50);
            $table->decimal('latitude', 10, 8)->nullable(); // Tambah kolom latitude
            $table->decimal('longitude', 11, 8)->nullable(); // Tambah kolom longitude
            $table->string('status_verifikasi')->nullable();
            $table->string('status_penanganan')->nullable();
            $table->string('deskripsi_penanganan', 255)->nullable();
            $table->string('tipe_pelapor', 20);
            $table->string('pengurus_lingkungan_username', 50)->nullable();
            $table->string('warga_username', 50)->nullable();
            $table->string('kategori_laporan', 50);
            $table->string('deskripsi_penolakan')->nullable();
            $table->timestamps();

            // Foreign Keys
            $table->foreign('warga_username')
                  ->references('username')
                  ->on('warga')
                  ->onDelete('set null');

            $table->foreign('pengurus_lingkungan_username')
                  ->references('username')
                  ->on('pengurus_lingkungan')
                  ->onDelete('set null');

            $table->foreign('kategori_laporan')
                  ->references('nama_kategori')
                  ->on('kategori')
                  ->onDelete('cascade');
                  
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan');
    }
};
