<?php

namespace Database\Factories;

use App\Models\Kategori;
use Illuminate\Database\Eloquent\Factories\Factory;

class KategoriFactory extends Factory
{
    protected $model = Kategori::class;

    private static array $kategoriList = [
        'Elektronik', 'Fashion', 'Makanan & Minuman',
        'Peralatan Rumah', 'Olahraga', 'Otomotif',
        'Kecantikan', 'Buku & Alat Tulis',
    ];

    public function definition(): array
    {
        return [
            'nama_kategori' => $this->faker->unique()->randomElement(self::$kategoriList),
        ];
    }
}
