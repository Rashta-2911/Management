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
        Schema::create('sewa', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('kamar_id');
            $table->string('penghuni_id');
            $table->string('tipe_kamar_id');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai')->nullable();
            $table->decimal('harga_disepakati', 10, 2);
            $table->enum('status', ['Aktif', 'Selesai', 'Dibatalkan']);
            $table->text('catatan')->nullable();
            $table->foreign('kamar_id')->references('id')->on('kamar')->cascadeOnDelete();
            $table->foreign('penghuni_id')->references('id')->on('penghuni')->cascadeOnDelete();
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
        Schema::dropIfExists('sewa');
    }
};
