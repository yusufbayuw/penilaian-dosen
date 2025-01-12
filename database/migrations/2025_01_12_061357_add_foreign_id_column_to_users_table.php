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
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('dosen_id')->after('id')->nullable()->constrained('m004_dosens')->cascadeOnDelete();
            $table->foreignId('mahasiswa_id')->after('id')->nullable()->constrained('m005_mahasiswas')->cascadeOnDelete();
            $table->string('username')->after('email')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign('dosen_id');
            $table->dropForeign('mahasiswa_id');
            $table->dropColumn('mahasiswa_id');
            $table->dropColumn('dosen_id');
            $table->dropColumn('username');
        });
    }
};
