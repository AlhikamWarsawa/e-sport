<?php

namespace Database\Factories;

use App\Models\Merchandise;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class MerchandiseFactory extends Factory
{
    protected $model = Merchandise::class;

    public function definition(): array
    {
        $name = $this->faker->words(3, true);

        return [
            'name'        => ucfirst($name),
            'slug'        => Str::slug($name) . '-' . $this->faker->unique()->numberBetween(100, 999),
            'description' => $this->faker->paragraph(4),
            'price'       => $this->faker->numberBetween(50000, 250000),
            'image'       => 'default.jpg',
            'created_by'  => User::factory(),
        ];
    }
}
