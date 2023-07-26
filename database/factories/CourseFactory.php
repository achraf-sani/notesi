<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'moduleId' => $this->faker->numerify('####'),
            'courseName' => $this->faker->realText(1),
            'courseCoeff' => $this->faker->randomFloat(2, 0, 100),
        ];
    }
}
