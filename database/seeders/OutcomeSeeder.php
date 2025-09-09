<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Outcome;
use Illuminate\Database\Seeder;

class OutcomeSeeder extends Seeder
{
    public function run()
    {
        $project = Project::first();
        
        if ($project) {
            $outcome = new Outcome([
                'ProjectId' => $project->ProjectId,
                'Title' => 'Sample Outcome',
                'Description' => 'This is a test outcome',
                'OutcomeType' => 'Report',
                'CommercializationStatus' => 'Demoed'
            ]);
            
            $outcome->save();
        }
    }
}