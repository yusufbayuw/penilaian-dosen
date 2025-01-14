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
            $table->integer('q_12')->after('q_03')->nullable();
            $table->integer('q_11')->after('q_03')->nullable();
            $table->integer('q_10')->after('q_03')->nullable();
            $table->integer('q_09')->after('q_03')->nullable();
            $table->integer('q_08')->after('q_03')->nullable();
            $table->integer('q_07')->after('q_03')->nullable();
            $table->integer('q_06')->after('q_03')->nullable();
            $table->integer('q_05')->after('q_03')->nullable();
            $table->integer('q_04')->after('q_03')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('m009_penilaian_dosens', function (Blueprint $table) {
            $table->dropColumn('q_04');
            $table->dropColumn('q_05');
            $table->dropColumn('q_06');
            $table->dropColumn('q_07');
            $table->dropColumn('q_08');
            $table->dropColumn('q_09');
            $table->dropColumn('q_10');
            $table->dropColumn('q_11');
            $table->dropColumn('q_12');
        });
    }
};
