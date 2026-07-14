<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KamarSeeder extends Seeder
{

    public function run(): void
    {
        DB::table('kamar')->insert([
            [
                'id' => 'K1',
                'nomor_kamar' => '1',
                'tipe_kamar' => 'Non AC',
                'luas_kamar' => '15.0',
                'harga_kamar' => '950000',
                'tipe_sewa' => 'Bulanan',
                'status' => 'Terisi',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}