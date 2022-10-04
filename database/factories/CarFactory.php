<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Car>
 */
class CarFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name_id'=> $this->faker->numberBetween(1,30),
            'model'=>$this->faker->date('Y'),
            'color'=>$this->faker->text(15),
            'description'=>$this->faker->text(50),
            'vendor_id'=>$this->faker->numberBetween(1,30),
        ];
    }
}
