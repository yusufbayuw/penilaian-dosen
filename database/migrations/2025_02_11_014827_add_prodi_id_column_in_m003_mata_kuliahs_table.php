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
        Schema::table('m003_mata_kuliahs', function (Blueprint $table) {
            $table->foreignId('prodi_id')->nullable()->constrained('m010_prodis')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('m003_mata_kuliahs', function (Blueprint $table) {
            $table->dropForeign('prodi_id');
            $table->dropColumn('prodi_id');
        });
    }
};
