<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penggajian', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('karyawan_id');
            $table->unsignedTinyInteger('bulan');
            $table->unsignedSmallInteger('tahun');
            $table->decimal('nominal_gaji', 12, 2);
            $table->string('status')->default('Belum Dibayar');
            $table->date('tanggal_dibayar')->nullable();
            $table->foreign('karyawan_id')->references('id')->on('karyawan')->cascadeOnDelete();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penggajian');
    }
};
