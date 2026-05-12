<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        return [
            'nama_lengkap' => $this->faker->name(),
            'email'        => $this->faker->unique()->userName() . '@gmail.com',
            'password'     => Hash::make('password123'),
            'nomor_hp'     => '08' . $this->faker->numerify('#########'),
            'role'         => 'user',
            'id_admin'     => null,
        ];
    }

    public function admin(): static
    {
        return $this->state(fn () => [
            'role'     => 'admin',
            'id_admin' => 'ADMIN-' . strtoupper($this->faker->lexify('???')),
        ]);
    }
}
