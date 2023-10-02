<?php

namespace Database\Factories;

use App\Models\Unit;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Warning>
 */
class WarningFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $photos = [
            md5(rand(0, 1000)) . '.png',
            md5(rand(0, 1000)) . '.png',
            md5(rand(0, 1000)) . '.png',
        ];
        return [
            'unit_id' => Unit::all()->random(),
            'title' => fake()->text(30),
            'photos' => json_encode($photos),
        ];
    }
}
