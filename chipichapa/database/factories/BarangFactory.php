<?php

namespace Database\Factories;

use App\Models\Barang;
use App\Models\Kategori;
use Illuminate\Database\Eloquent\Factories\Factory;

class BarangFactory extends Factory
{
    protected $model = Barang::class;

    public function definition(): array
    {
        return [
            'kategori_id'   => Kategori::inRandomOrder()->first()?->id ?? Kategori::factory(),
            'nama_barang'   => $this->faker->words(3, true), // min 5 char via faker
            'harga_barang'  => $this->faker->numberBetween(5000, 5000000),
            'jumlah_barang' => $this->faker->numberBetween(0, 100),
            'foto_barang'   => null,
        ];
    }
}
