<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1 user tetap untuk testing
        User::create([
            'nama_lengkap' => 'Budi Santoso',
            'email'        => 'budi@gmail.com',
            'password'     => \Illuminate\Support\Facades\Hash::make('budi123'),
            'nomor_hp'     => '081298765432',
            'role'         => 'user',
        ]);

        // 9 user random
        User::factory()->count(9)->create();
    }
}
