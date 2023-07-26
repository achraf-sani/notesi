<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Module>
 */
class ModuleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'moduleName' => $this->faker->realText(20),
            'moduleCoeff' => $this->faker->randomFloat(2, 0, 100),
            'moduleMajor' => $this->faker->numerify('####'),
        ];
    }
}
