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
        Schema::create('m002_semesters', function (Blueprint $table) {
            $table->id();
            $table->string('nama')->nullable();
            $table->string('kode')->nullable();
            $table->boolean('aktif')->default(false);
            $table->boolean('penilaian')->default(false);
            $table->foreignId('tahun_ajaran_id')->nullable()->constrained('m001_tahun_ajarans')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m002_semesters');
    }
};
