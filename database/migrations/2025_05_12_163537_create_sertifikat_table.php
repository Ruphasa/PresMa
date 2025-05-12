<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSertifikatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sertifikat', function (Blueprint $table) {
            $table->id();
            $table->integer('nomorSeri');
            $table->string('kategoriSertif');
            $table->string('image');  // Anda dapat menyesuaikan tipe data jika image disimpan sebagai file
            $table->unsignedBigInteger('prestasi_id');  // Foreign key untuk prestasi
            $table->timestamps();

            // Menambahkan foreign key constraint
            $table->foreign('prestasi_id')->references('id')->on('prestasi')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sertifikat');
    }
}
