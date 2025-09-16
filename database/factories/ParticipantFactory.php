<?php

namespace Database\Factories;

use App\Models\Participant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Participant>
 */
class ParticipantFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Participant::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'FullName' => fake()->name(),
            'Email' => fake()->unique()->safeEmail(),
            'Affiliation' => fake()->randomElement(['CS', 'SE', 'Engineering', 'Other']),
            'Specialization' => fake()->randomElement(['Software', 'Hardware', 'Business']),
            'CrossSkillTrained' => fake()->boolean(30), // 30% chance of being cross-skill trained
            'Institution' => fake()->randomElement(['SCIT', 'CEDAT', 'UniPod', 'UIRI', 'Lwera', 'Other']),
        ];
    }

    /**
     * Indicate that the participant is cross-skill trained.
     */
    public function crossSkillTrained(): static
    {
        return $this->state(fn (array $attributes) => [
            'CrossSkillTrained' => true,
        ]);
    }

    /**
     * Indicate that the participant is not cross-skill trained.
     */
    public function notCrossSkillTrained(): static
    {
        return $this->state(fn (array $attributes) => [
            'CrossSkillTrained' => false,
        ]);
    }

    /**
     * Indicate that the participant is from SCIT.
     */
    public function fromSCIT(): static
    {
        return $this->state(fn (array $attributes) => [
            'Institution' => 'SCIT',
            'Affiliation' => fake()->randomElement(['CS', 'SE']),
        ]);
    }

    /**
     * Indicate that the participant is from CEDAT.
     */
    public function fromCEDAT(): static
    {
        return $this->state(fn (array $attributes) => [
            'Institution' => 'CEDAT',
            'Affiliation' => 'Engineering',
        ]);
    }

    /**
     * Indicate that the participant specializes in software.
     */
    public function softwareSpecialist(): static
    {
        return $this->state(fn (array $attributes) => [
            'Specialization' => 'Software',
            'Affiliation' => fake()->randomElement(['CS', 'SE']),
        ]);
    }

    /**
     * Indicate that the participant specializes in hardware.
     */
    public function hardwareSpecialist(): static
    {
        return $this->state(fn (array $attributes) => [
            'Specialization' => 'Hardware',
            'Affiliation' => fake()->randomElement(['Engineering', 'Other']),
        ]);
    }

    /**
     * Indicate that the participant specializes in business.
     */
    public function businessSpecialist(): static
    {
        return $this->state(fn (array $attributes) => [
            'Specialization' => 'Business',
            'Affiliation' => 'Other',
        ]);
    }
}