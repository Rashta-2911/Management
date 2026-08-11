<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('karyawan', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('properti_id');
            $table->string('nama');
            $table->string('jabatan')->nullable();
            $table->string('no_telepon', 20);
            $table->string('email')->nullable();
            $table->decimal('gaji_pokok', 10, 2);
            $table->date('tanggal_masuk')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('properti_id')->references('id')->on('properti')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('karyawan');
    }
};
