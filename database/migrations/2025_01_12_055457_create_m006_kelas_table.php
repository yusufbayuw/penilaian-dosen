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
        Schema::create('m006_kelas', function (Blueprint $table) {
            $table->id();
            $table->string('nama')->nullable();
            $table->string('kode')->nullable();
            $table->foreignId('semester_id')->nullable()->constrained('m002_semesters')->cascadeOnDelete();
            $table->foreignId('mata_kuliah_id')->nullable()->constrained('m003_mata_kuliahs')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m006_kelas');
    }
};
