<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'nama_lengkap' => 'Raja Administrator',
            'email'        => 'admin@gmail.com',
            'password'     => Hash::make('admin123'),
            'nomor_hp'     => '081234567890',
            'role'         => 'admin',
            'id_admin'     => 'ADMIN-RAJA',
        ]);
    }
}
