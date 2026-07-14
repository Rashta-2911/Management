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
        Schema::create('tagihan', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('sewa_id');
            $table->decimal('jumlah', 10, 2);
            $table->date('tanggal_tagihan');
            $table->date('tanggal_jatuh_tempo');
            $table->enum('status', ['Belum lunas', 'Lunas', 'Terlambat']);
            $table->text('catatan')->nullable();
            $table->foreign('sewa_id')->references('id')->on('sewa')->restrictOnDelete();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tagihan');
    }
};
