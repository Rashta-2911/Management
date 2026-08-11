<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $rolePemilik = Role::firstOrCreate(['name' => 'pemilik', 'guard_name' => 'web']);
        $roleAdmin = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);

        $rashta = User::firstOrCreate(
            [
                'email' => 'shinta2020@gmail.com',
            ],
            [
                'nama' => 'Shinta',
                'password' => bcrypt('PojokHunian2020$'),
            ]
        );
        $rashta->syncRoles('pemilik');

        $admin = User::firstOrCreate(
            [
                'email' => 'Rashta2020@gmail.com',
            ],
            [
                'nama' => 'Rashta',
                'password' => bcrypt('Admin123'),
            ]
        );
        $admin->syncRoles('admin');
    }
}
