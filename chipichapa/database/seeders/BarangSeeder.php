<?php

namespace Database\Seeders;

use App\Models\Barang;
use App\Models\Kategori;
use Illuminate\Database\Seeder;

class BarangSeeder extends Seeder
{
    public function run(): void
    {
        $barangs = [
            ['kategori' => 'Elektronik',       'nama' => 'Laptop ASUS VivoBook',    'harga' => 8500000, 'jumlah' => 10],
            ['kategori' => 'Elektronik',       'nama' => 'Headphone Sony WH-1000',  'harga' => 3200000, 'jumlah' => 25],
            ['kategori' => 'Fashion',          'nama' => 'Kaos Polos Cotton',       'harga' => 75000,   'jumlah' => 50],
            ['kategori' => 'Fashion',          'nama' => 'Celana Jeans Slim Fit',   'harga' => 250000,  'jumlah' => 30],
            ['kategori' => 'Makanan & Minuman','nama' => 'Bakmi Instan Premium',     'harga' => 5000,    'jumlah' => 200],
            ['kategori' => 'Makanan & Minuman','nama' => 'Kopi Arabika 500g',        'harga' => 120000,  'jumlah' => 40],
            ['kategori' => 'Peralatan Rumah',  'nama' => 'Sapu Lantai Gagang Panjang','harga' => 35000, 'jumlah' => 0],  // sengaja habis
            ['kategori' => 'Olahraga',         'nama' => 'Sepatu Lari Nike',        'harga' => 950000,  'jumlah' => 15],
        ];

        foreach ($barangs as $b) {
            $kategori = Kategori::where('nama_kategori', $b['kategori'])->first();
            if ($kategori) {
                Barang::create([
                    'kategori_id'   => $kategori->id,
                    'nama_barang'   => $b['nama'],
                    'harga_barang'  => $b['harga'],
                    'jumlah_barang' => $b['jumlah'],
                    'foto_barang'   => null,
                ]);
            }
        }
    }
}
