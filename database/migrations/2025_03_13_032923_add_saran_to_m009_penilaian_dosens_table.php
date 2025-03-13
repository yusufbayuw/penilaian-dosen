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
        Schema::table('m009_penilaian_dosens', function (Blueprint $table) {
            $table->string('saran')->nullable()->after('q_12');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('m009_penilaian_dosens', function (Blueprint $table) {
            $table->dropColumn('saran');
        });
    }
};
