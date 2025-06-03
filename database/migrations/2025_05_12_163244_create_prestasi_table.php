<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrestasiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_prestasi', function (Blueprint $table) {
            $table->id('prestasi_id');
            $table->unsignedBigInteger('lomba_id');
            $table->unsignedBigInteger('mahasiswa_id');
            $table->string('tingkat_prestasi');
            $table->integer('juara_ke');
            $table->enum('status', ['pending', 'validated', 'rejected','outdated'])->default('pending');
            $table->string('keterangan')->nullable();
            $table->integer('point')->default(0);
            $table->timestamps();

            $table->foreign('mahasiswa_id')->references('nim')->on('m_mahasiswa');
            $table->foreign('lomba_id')->references('lomba_id')->on('m_lomba');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('t_prestasi');
    }
}
