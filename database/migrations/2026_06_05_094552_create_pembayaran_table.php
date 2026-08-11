<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('sewa_id');
            $table->string('tagihan_id')->nullable();
            $table->date('tanggal_pembayaran');
            $table->string('metode_pembayaran');
            $table->decimal('jumlah', 10, 2);
            $table->enum('status', ['Lunas']);
            $table->string('bukti_pembayaran')->nullable();

            $table->foreign('sewa_id')->references('id')->on('sewa');
            $table->foreign('tagihan_id')->references('id')->on('tagihan')->nullOnDelete();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pembayaran');
    }
};
