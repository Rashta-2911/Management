<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penghuni', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('kamar_id');
            $table->string('nama_penghuni');
            $table->string('no_hp', 15);
            $table->string('email');
            $table->string('alamat_asal');
            $table->enum('status', ['Mahasiswa', 'Pekerja', 'Lainnya']);
            $table->foreign('kamar_id')->references('id')->on('kamar')->cascadeOnDelete();

            $table->timestamps();
            $table->softDeletes();
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('penghuni');
    }
};
