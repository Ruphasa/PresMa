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
        $table = 'm_user';
        if (!Schema::hasTable($table)) {
            Schema::create($table, function (Blueprint $table) {
                $table->id('user_id')->autoIncrement();
                $table->unsignedBigInteger('level_id');
                $table->string('nama');
                $table->string('password');
                $table->string('img');
                $table->timestamps();

                $table->foreign('level_id')->references('level_id')->on('m_level');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_user');
    }
};
