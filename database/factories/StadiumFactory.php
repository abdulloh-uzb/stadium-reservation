<?php

namespace Database\Factories;

use App\Helpers\Constants;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Stadium>
 */
class StadiumFactory extends Factory
{

   
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $times = Constants::get_times();

        $open_time = fake()->randomElement($times);
        $close_time = fake()->randomElement($times);

        if(strtotime($open_time) > strtotime($close_time))
        {
            [$open_time, $close_time] = [$close_time, $open_time];
        }

        return [
            "name" => fake()->name(),
            "location" => fake()->address(),
            "description" => fake()->text(),
            "price" => random_int(50000, 500000),
            "open_time" => $open_time,
            "close_time" => $close_time,
            "is_always_open" => false,
            "owner_id" => 2
        ];
    }
}
