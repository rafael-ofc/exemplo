<?php

namespace Database\Factories;

use App\Models\Area;
use App\Models\Unit;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reservation>
 */
class ReservationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'unit_id' => Unit::all()->random(),
            'area_id' => Area::all()->random(),
            'date' => fake()->dateTime(),
        ];
    }
}
