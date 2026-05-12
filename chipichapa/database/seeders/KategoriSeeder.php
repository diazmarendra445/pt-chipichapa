<?php

namespace Database\Seeders;

use App\Models\Kategori;
use Illuminate\Database\Seeder;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        $kategoris = [
            'Elektronik',
            'Fashion',
            'Makanan & Minuman',
            'Peralatan Rumah',
            'Olahraga',
        ];

        foreach ($kategoris as $nama) {
            Kategori::create(['nama_kategori' => $nama]);
        }
    }
}
