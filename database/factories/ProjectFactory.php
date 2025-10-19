<?php

namespace Database\Factories;

use App\Models\Facility;
use App\Models\Program;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'Title' => fake()->unique()->sentence(4),
            'Description' => fake()->paragraph(),
            'Status' => fake()->randomElement(['Planning', 'Active', 'Completed', 'On Hold']),
            'NatureOfProject' => fake()->randomElement(['Research', 'Prototype', 'Applied work']),
            'InnovationFocus' => fake()->randomElement(['AI', 'IoT', 'Robotics', 'Green Tech']),
            'PrototypeStage' => fake()->randomElement(['Concept', 'Prototype', 'MVP', 'Market Launch']),
            'StartDate' => fake()->dateTimeBetween('-1 year', 'now'),
            'EndDate' => fake()->dateTimeBetween('now', '+1 year'),
            'FacilityId' => Facility::factory(),
            'ProgramId' => Program::factory(),
            'TestingRequirements' => fake()->randomElement(['Performance Testing', 'Security Testing', 'User Testing', null]),
            'CommercializationPlan' => fake()->optional()->paragraph(),
        ];
    }

    /**
     * Indicate that the project is completed.
     */
    public function completed(): static
    {
        return $this->state(fn (array $attributes) => [
            'Status' => 'Completed',
            'EndDate' => fake()->dateTimeBetween('-6 months', 'now'),
        ]);
    }

    /**
     * Indicate that the project is in progress.
     */
    public function inProgress(): static
    {
        return $this->state(fn (array $attributes) => [
            'Status' => 'Active',
        ]);
    }

    /**
     * Indicate that the project is in planning stage.
     */
    public function planning(): static
    {
        return $this->state(fn (array $attributes) => [
            'Status' => 'Planning',
            'StartDate' => fake()->dateTimeBetween('now', '+1 month'),
        ]);
    }

    /**
     * Set specific program.
     */
    public function forProgram(int $programId): static
    {
        return $this->state(fn (array $attributes) => [
            'ProgramId' => $programId,
        ]);
    }

    /**
     * Set specific facility.
     */
    public function forFacility(int $facilityId): static
    {
        return $this->state(fn (array $attributes) => [
            'FacilityId' => $facilityId,
        ]);
    }
}
