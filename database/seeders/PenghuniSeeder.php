<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenghuniSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('penghuni')->insert([
            [
                'id' => 'P1',
                'kamar_id' => 'K1',
                'nama_penghuni' => 'Lina Dewi',
                'no_hp' => '085868122445',
                'email' => 'lina@example.com',
                'alamat_asal' => 'Boyolali, Jawa Tengah',
                'status' => 'Pekerja',

                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
