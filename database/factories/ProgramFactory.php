<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Program>
 */
class ProgramFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'Name' => fake()->unique()->sentence(3),
            'Description' => fake()->paragraph(),
            'NationalAlignment' => fake()->randomElement(['NDPIII', 'DigitalRoadmap2023_2028', '4IR', 'NDPIII,4IR']),
            'FocusAreas' => fake()->randomElement(['AI,IoT', 'Robotics', 'Green Tech,Renewable Energy', null]),
            'Phases' => fake()->randomElement([
                'Cross-Skilling',
                'Collaboration',
                'Technical Skills',
                'Prototyping',
                'Commercialization'
            ]),
        ];
    }

    /**
     * Indicate that the program has focus areas with national alignment.
     */
    public function withFocusAreas(): static
    {
        return $this->state(fn (array $attributes) => [
            'FocusAreas' => 'AI,IoT,Robotics',
            'NationalAlignment' => 'NDPIII,4IR',
        ]);
    }

    /**
     * Indicate that the program has no focus areas.
     */
    public function withoutFocusAreas(): static
    {
        return $this->state(fn (array $attributes) => [
            'FocusAreas' => null,
            'NationalAlignment' => null,
        ]);
    }

    /**
     * Indicate specific national alignment.
     */
    public function withNationalAlignment(string $alignment): static
    {
        return $this->state(fn (array $attributes) => [
            'NationalAlignment' => $alignment,
        ]);
    }
}
