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
        Schema::create("t_rekomendasi", function (Blueprint $table) {
            $table->bigIncrements("rekomendasi_id");
            $table->unsignedBigInteger("lomba_id");
            $table->unsignedBigInteger("nim");

            $table->foreign("lomba_id")->references("lomba_id")->on("m_lomba");
            $table->foreign("nim")->references("nim")->on("m_mahasiswa");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("t_rekomendasi");

    }
};
