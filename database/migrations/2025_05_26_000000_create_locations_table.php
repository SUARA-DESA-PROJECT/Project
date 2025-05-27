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
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->unique(); // Make name unique for proper referencing
            $table->decimal('latitude', 10, 8);
            $table->decimal('longitude', 11, 8);
            $table->timestamps();
        });
        
        // Add foreign key to laporan table if it exists
        if (Schema::hasTable('laporan')) {
            Schema::table('laporan', function (Blueprint $table) {
                // Add foreign key for tempat_kejadian referencing locations.name
                $table->foreign('tempat_kejadian')
                      ->references('name')
                      ->on('locations')
                      ->onDelete('restrict');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove foreign key from laporan table if it exists
        if (Schema::hasTable('laporan')) {
            Schema::table('laporan', function (Blueprint $table) {
                $table->dropForeign(['tempat_kejadian']);
            });
        }
        
        Schema::dropIfExists('locations');
    }
};