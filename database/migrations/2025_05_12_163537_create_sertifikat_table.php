<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use PhpParser\Node\NullableType;

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
            $table->id('sertifikat_id');
            $table->integer('nomorSeri');
            $table->string('kategoriSertif');
            $table->string('image')->nullable;  // Anda dapat menyesuaikan tipe data jika image disimpan sebagai file
            $table->unsignedBigInteger('nim');  // Foreign key untuk mahasiswa
            $table->unsignedBigInteger('prestasi_id');  // Foreign key untuk prestasi
            $table->timestamps();

            // Menambahkan foreign key constraint
            $table->foreign('prestasi_id')->references('prestasi_id')->on('prestasi');
            $table->foreign('nim')->references('nim')->on('m_mahasiswa');
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
