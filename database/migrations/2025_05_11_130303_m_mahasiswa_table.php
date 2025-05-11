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
        $table = 'm_mahasiswa';
        if (!Schema::hasTable($table)) {
            Schema::create($table, function (Blueprint $table) {
                $table->id('nim');
                $table->unsignedBigInteger('user_id');
                $table->unsignedBigInteger('prodi_id');
                $table->unsignedBigInteger('dosen_id');
                $table->timestamps();

                $table->foreign('user_id')->references('user_id')->on('m_user');
                $table->foreign('prodi_id')->references('prodi_id')->on('m_prodi');
                $table->foreign('dosen_id')->references('nidn')->on('m_dosen');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_mahasiswa');
    }
};
