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
        Schema::create('m009_penilaian_dosens', function (Blueprint $table) {
            $table->id();
            $table->integer('q_01')->nullable();
            $table->integer('q_02')->nullable();
            $table->integer('q_03')->nullable();
            $table->foreignId('kelas_mahasiswa_id')->nullable()->constrained('m007_kelas_mahasiswas')->cascadeOnDelete();
            $table->foreignId('kelas_dosen_id')->nullable()->constrained('m008_kelas_dosens')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m009_penilaian_dosens');
    }
};
