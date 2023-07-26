<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Mark>
 */
class MarkFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'courseId' => $this->faker->numerify('####'),
            'mark' => $this->faker->randomFloat(2, 0, 20),
            'studentId' => $this->faker->numerify('####'),

            
        ];
    }
}
