<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('penggajian', function (Blueprint $table) {
            $table->timestamp('dikirim_at')->nullable()->after('bukti_transfer');
            $table->string('dikirim_via')->nullable()->after('dikirim_at');
        });
    }

    public function down(): void
    {
        Schema::table('penggajian', function (Blueprint $table) {
            $table->dropColumn(['dikirim_at', 'dikirim_via']);
        });
    }
};
