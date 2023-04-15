<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Voucher>
 */
class VoucherFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "name" => $this->faker->word(),
            "code" => $this->faker->bothify('???###'),
            "quantity" => 10,
            "description" => $this->faker->sentence(),
            "discount" => $this->faker->numerify('##'),
            "start_day" => now(),
            "exp" => $this->faker->dateTimeInInterval($startDate = '+ 2 days', $interval = '+ 5 days', $timezone = 'Asia/Ho_Chi_Minh') ,
            "allow_multi" => 1,
            "available" => 0,
            "admin_created" => 1,
            "admin_updated" => 1,
        ];
    }
}
