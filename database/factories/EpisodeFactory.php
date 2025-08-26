<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class EpisodeFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title'        => 'Episode ' . $this->faker->numberBetween(1, 100),
            'description'  => $this->faker->boolean(70) ? $this->faker->sentence(12) : null,
            'video_url'    => 'https://example.com/video/'.$this->faker->uuid(),
            'duration'     => $this->faker->numberBetween(15, 60),
            'release_date' => $this->faker->date(),
        ];
    }
}
