<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Rest>
 */
class RestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'work_id' => $this->faker->unique(true, 20000)->numberBetween(1, 500),
            'break_start' => '12:00:00',
            'break_end' => '13:00:00',
            'break_time' => '01:00:00',
        ];
    }
}
