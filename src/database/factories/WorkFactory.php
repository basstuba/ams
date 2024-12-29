<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Work>
 */
class WorkFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static $combinations = [];

        if (empty($combinations)) {
            $userIds = range(2, 51);
            $dates = collect(Carbon::parse('2024-12-01')->daysUntil('2024-12-31')->toArray());

            foreach ($userIds as $userId) {
                foreach ($dates as $date) {
                    $combinations[] = [
                        'user_id' => $userId,
                        'date' => $date->format('Y-m-d'),
                    ];
                }
            }

            shuffle($combinations);
        }

        if (empty($combinations)) {
            throw new \Exception('No more unique combinations available');
        }

        $combination = array_pop($combinations);

        return [
            'user_id' => $combination['user_id'],
            'date' => $combination['date'],
            'work_start' => '09:00:00',
            'work_end' => '18:00:00',
            'break_total' => '01:00:00',
            'work_time' => '08:00:00',
        ];
    }
}
