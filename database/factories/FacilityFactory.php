<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Facility>
 */
class FacilityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'Name' => fake()->unique()->company() . ' Lab',
            'Location' => fake()->city(),
            'FacilityType' => fake()->randomElement(['Lab', 'Workshop', 'Research Center', 'Innovation Hub']),
            'Capabilities' => fake()->randomElement([
                'Prototyping,Testing,3D Printing',
                'Assembly,Testing,Design',
                'Research,Development,Testing',
                '3D Printing,Laser Cutting,CNC Machining'
            ]),
            'Description' => fake()->optional()->paragraph(),
            'PartnerOrganization' => fake()->optional()->company(),
        ];
    }

    /**
     * Indicate specific capabilities.
     */
    public function withCapabilities(string $capabilities): static
    {
        return $this->state(fn (array $attributes) => [
            'Capabilities' => $capabilities,
        ]);
    }

    /**
     * Indicate specific location.
     */
    public function atLocation(string $location): static
    {
        return $this->state(fn (array $attributes) => [
            'Location' => $location,
        ]);
    }
}
