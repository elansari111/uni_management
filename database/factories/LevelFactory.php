<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Level;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Level>
 */
class LevelFactory extends Factory
{
    protected $model = Level::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $levels = [
            ['name' => 'Licence 1', 'code' => 'L1'],
            ['name' => 'Licence 2', 'code' => 'L2'],
            ['name' => 'Licence 3', 'code' => 'L3'],
            ['name' => 'Master 1', 'code' => 'M1'],
            ['name' => 'Master 2', 'code' => 'M2'],
        ];
        
        $level = $levels[$this->faker->unique()->numberBetween(0, 4)];
        
        return [
            'name' => $level['name'],
            'code' => $level['code'],
            'description' => fake()->sentence(),
            'order' => fake()->unique()->numberBetween(1, 5),
        ];
    }
}
