<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SeriesFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title'       => $this->faker->unique()->sentence(3),
            'description' => $this->faker->paragraph(),
            'status'      => $this->faker->boolean(85) ? 'active' : 'inactive',
            'cover_image' => null, // use storage later if needed
        ];
    }
}
