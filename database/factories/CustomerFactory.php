<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "name" => $this->faker->name(),
            "email" => $this->faker->unique()->safeEmail(),
            "phone" => $this->faker->numerify('0#########'),
            "address" => "69 - blackpink - in - your - area",
            "created_at" => now(),
            "updated_at" => now(),
            "admin_created" => 1,
            "admin_updated" => 1,
        ];
    }
}
