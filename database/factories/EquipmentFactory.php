<?php

namespace Database\Factories;

use App\Models\Equipment;
use App\Models\Facility;
use Illuminate\Database\Eloquent\Factories\Factory;

class EquipmentFactory extends Factory
{
    protected $model = Equipment::class;

    public function definition()
    {
        return [
            'FacilityId' => Facility::factory(), // Automatically creates a related Facility
            'Name' => $this->faker->word,
            'InventoryCode' => $this->faker->unique()->bothify('EQ###'),
            'UsageDomain' => $this->faker->randomElement(['Electronics', 'Mechanical']),
            'SupportPhase' => ['Prototyping', 'Testing'], // Adjust if stored as JSON or array
        ];
    }
}