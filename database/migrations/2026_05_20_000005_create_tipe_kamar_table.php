<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('tipe_kamar', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('properti_id');
            $table->string('nama_tipe');
            $table->text('fasilitas');
            $table->decimal('harga', 10, 2);
            $table->decimal('luas_kamar', 8, 2);
            $table->unsignedTinyInteger('kapasitas');
            $table->enum('tipe_sewa', ['Harian', 'Mingguan', 'Bulanan']);
            $table->foreign('properti_id')->references('id')->on('properti')->cascadeOnDelete();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipe_kamar');
    }
};
