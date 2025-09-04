<?php

namespace Database\Seeders;

use App\Models\Facility;
use Illuminate\Database\Seeder;

class FacilitySeeder extends Seeder
{
    public function run(): void
    {
        $facilities = [
            [
                'Name' => 'Main Research Lab',
                'Location' => 'Building A',
                'Description' => 'Primary research facility',
                'PartnerOrganization' => 'TechCorp',
                'FacilityType' => 'Lab',
                'Capabilities' => 'Research, Testing'
            ],
            [
                'Name' => 'Innovation Hub',
                'Location' => 'Building B',
                'Description' => 'Collaborative workspace',
                'PartnerOrganization' => 'InnovateInc',
                'FacilityType' => 'Workshop',
                'Capabilities' => 'Prototyping, Development'
            ],
            [
                'Name' => 'Development Center',
                'Location' => 'Building C',
                'Description' => 'Software development center',
                'PartnerOrganization' => 'DevCo',
                'FacilityType' => 'Testing Center',
                'Capabilities' => 'Software Testing, QA'
            ]
        ];

        foreach ($facilities as $facility) {
            Facility::create($facility);
        }
    }
}
