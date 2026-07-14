<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PropertiSeeder extends Seeder
{

    public function run(): void
    {
        DB::table('properti')->insert([
            [
                'nama_properti' => 'Pojok Hunian',
                'alamat' => 'Jl. Tusam Raya No. 20J, Semarang',
                'jenis_properti' => 'Campur',
                'kontak_pemilik' => '082255074780',
                'fasilitas_umum' => 'Kamar mandi dalam & kitchen set',
                'peraturan' => 'Dilarang merokok, Dilarang membawa hewan peliharaan',
            ]
        ]);
    }
}
