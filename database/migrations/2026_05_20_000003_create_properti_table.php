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
        Schema::create('properti', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('nama_properti');
            $table->string('alamat');
            $table->enum('jenis_properti', ['Pria', 'Wanita', 'Campur']);
            $table->string('kontak_pemilik');
            $table->text('fasilitas_umum')->nullable();
            $table->text('peraturan')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properti');
    }
};
