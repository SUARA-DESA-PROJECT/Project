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
        Schema::create('komentar', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('laporan_id');
            $table->text('isi_komentar');
            $table->string('username', 50);
            $table->string('tipe_user', 20); // 'warga' or 'pengurus'
            $table->timestamps();

            // Foreign key to laporan table
            $table->foreign('laporan_id')
                  ->references('id')
                  ->on('laporan')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('komentar');
    }
};