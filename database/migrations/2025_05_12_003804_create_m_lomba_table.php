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
        // Create the 'lomba' table with the specified columns
        // and their respective data types.

        Schema::create('m_lomba', function (Blueprint $table) {
            $table->id('lomba_id')->autoIncrement(); // Primary key for the lomba table
            //tingkat, tanggal, nama, detail, kategori
            $table->unsignedBigInteger('kategori_id');
            $table->unsignedBigInteger('user_id'); // Foreign key to the user who created the lomba
            $table->enum('lomba_tingkat', ['Regional','Nasional', 'Internasional']);
            $table->date('lomba_tanggal');
            $table->string('lomba_nama');
            $table->text('lomba_detail');
            $table->enum('status', ['pending', 'validated', 'rejected','outdated'])->default('pending');
            $table->string('keterangan')->nullable();
            $table->timestamps();

            // Foreign key constraint to ensure referential integrity
            $table->foreign('kategori_id')->references('kategori_id')->on('m_kategori');
            $table->foreign('user_id')->references('user_id')->on('m_user');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_lomba');
    }
};
