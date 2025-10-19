<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Outcome>
 */
class OutcomeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'ProjectId' => Project::factory(),
            'Title' => fake()->sentence(4),
            'Description' => fake()->paragraph(),
            'ArtifactLink' => fake()->optional()->url(),
            'OutcomeType' => fake()->randomElement(['CAD', 'PCB', 'Prototype', 'Report', 'Business Plan']),
            'QualityCertification' => fake()->optional()->randomElement(['ISO 9001', 'CE Mark', 'UL Listed', 'FDA Approved']),
            'CommercializationStatus' => fake()->randomElement(['Demoed', 'Market Linked', 'Launched']),
        ];
    }

    /**
     * Indicate a specific project.
     */
    public function forProject(int $projectId): static
    {
        return $this->state(fn (array $attributes) => [
            'ProjectId' => $projectId,
        ]);
    }

    /**
     * Indicate the outcome is a prototype.
     */
    public function prototype(): static
    {
        return $this->state(fn (array $attributes) => [
            'OutcomeType' => 'Prototype',
        ]);
    }

    /**
     * Indicate the outcome is commercialized.
     */
    public function commercialized(): static
    {
        return $this->state(fn (array $attributes) => [
            'CommercializationStatus' => 'Launched',
        ]);
    }
}
