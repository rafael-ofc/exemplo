<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Area>
 */
class AreaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $days = [
            rand(0, 1),
            rand(2, 3),
            rand(4, 6),
        ];
        return [
            'title' => fake()->text(30),
            'cover' => md5(rand(0, 1000)) . '.png',
            'days' => json_encode($days),
            'start_time' => fake()->time(),
            'end_time' => fake()->time(),
        ];
    }
}
