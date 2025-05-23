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
        Schema::table('laporan', function (Blueprint $table) {
            $table->time('time_laporan')->nullable();
            $table->string('jenis_laporan', 20)->nullable();
        });
    }

    public function down()
    {
        Schema::table('laporan', function (Blueprint $table) {
            $table->dropColumn(['time_laporan', 'jenis_laporan']);
        });
    }
};
