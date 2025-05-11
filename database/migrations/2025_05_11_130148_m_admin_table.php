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
        $table = 'm_admin';
        if (!Schema::hasTable($table)) {
            Schema::create($table, function (Blueprint $table) {
                $table->id('nip');
                $table->unsignedBigInteger('user_id');
                $table->timestamps();

                $table->foreign('user_id')->references('user_id')->on('m_user');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_admin');
    }
};
