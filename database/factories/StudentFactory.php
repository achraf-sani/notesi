<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */


    public function definition()
    {
        return [
            'firstName' => $this->faker->name(),
            'lastName' => $this->faker->name(),
            'fullName' => "adnanebenazzou",
            'studentPromo' => $this->faker->numerify('####'),
            'studentGroup' => $this->faker->realText(10),
            //'studentMajor' => $this->faker->numerify('####'),

        ];
    }
}
