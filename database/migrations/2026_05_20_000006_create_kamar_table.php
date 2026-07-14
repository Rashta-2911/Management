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
        Schema::create('kamar', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('tipe_kamar_id');
            $table->integer('nomor_kamar');
            $table->enum('status', ['Tersedia', 'Terisi']);
            $table->foreign('tipe_kamar_id')->references('id')->on('tipe_kamar')->cascadeOnDelete();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kamar');
    }
};
