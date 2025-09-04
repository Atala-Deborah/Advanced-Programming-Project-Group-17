<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        $projects = [
            [
                'Name' => 'Research Project Alpha',
                'Description' => 'Innovative research project',
                'Status' => 'Active',
                'StartDate' => now(),
                'EndDate' => now()->addMonths(6),
                'FacilityId' => 1
            ],
            [
                'Name' => 'Development Project Beta',
                'Description' => 'Software development project',
                'Status' => 'Planning',
                'StartDate' => now()->addMonth(),
                'EndDate' => now()->addMonths(8),
                'FacilityId' => 2
            ],
            [
                'Name' => 'Testing Project Gamma',
                'Description' => 'Quality assurance project',
                'Status' => 'Active',
                'StartDate' => now()->subMonth(),
                'EndDate' => now()->addMonths(3),
                'FacilityId' => 3
            ]
        ];

        foreach ($projects as $project) {
            Project::create($project);
        }
    }
}
