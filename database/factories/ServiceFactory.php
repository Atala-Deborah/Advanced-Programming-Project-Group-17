<?php

namespace Database\Factories;

use App\Models\Service;
use App\Models\Facility;
use Illuminate\Database\Eloquent\Factories\Factory;

class ServiceFactory extends Factory
{
    protected $model = Service::class;

    public function definition(): array
    {
        return [
            'FacilityId' => Facility::factory(),
            'Name' => $this->faker->unique()->word(),
            'Category' => $this->faker->randomElement(['Machining', 'Testing', 'Training']),
            'SkillType' => $this->faker->randomElement(['Hardware', 'Software', 'Integration']),
        ];
    }
}
