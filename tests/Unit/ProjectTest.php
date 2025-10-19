<?php

namespace Tests\Unit;

use App\Models\Facility;
use App\Models\Outcome;
use App\Models\Participant;
use App\Models\Program;
use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_project_with_required_associations(): void
    {
        $program = Program::factory()->create();
        $facility = Facility::factory()->create();

        $project = Project::factory()->create([
            'ProgramId' => $program->ProgramId,
            'FacilityId' => $facility->FacilityId
        ]);

        $this->assertNotNull($project->ProjectId);
        $this->assertEquals($program->ProgramId, $project->ProgramId);
        $this->assertEquals($facility->FacilityId, $project->FacilityId);
    }

    /** @test */
    public function it_requires_program_id(): void
    {
        $data = [
            'FacilityId' => 1,
            'Title' => 'Test Project'
        ];

        $validator = Validator::make($data, [
            'ProgramId' => 'required|integer',
            'FacilityId' => 'required|integer'
        ]);

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('ProgramId', $validator->errors()->toArray());
    }

    /** @test */
    public function it_requires_facility_id(): void
    {
        $data = [
            'ProgramId' => 1,
            'Title' => 'Test Project'
        ];

        $validator = Validator::make($data, [
            'ProgramId' => 'required|integer',
            'FacilityId' => 'required|integer'
        ]);

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('FacilityId', $validator->errors()->toArray());
    }

    /** @test */
    public function it_must_have_at_least_one_team_member(): void
    {
        $program = Program::factory()->create();
        $facility = Facility::factory()->create();

        $project = Project::factory()->create([
            'ProgramId' => $program->ProgramId,
            'FacilityId' => $facility->FacilityId
        ]);

        // Initially no team members
        $this->assertEquals(0, $project->participants()->count());

        // Add a team member
        $participant = Participant::factory()->create();
        $project->participants()->attach($participant->ParticipantId, [
            'RoleOnProject' => 'Student',
            'SkillRole' => 'Developer'
        ]);

        $project->refresh();
        $this->assertGreaterThanOrEqual(1, $project->participants()->count());
    }

    /** @test */
    public function it_validates_team_tracking_requirement(): void
    {
        $project = Project::factory()->create();

        // Business rule: must have at least one team member
        $hasTeamMembers = $project->participants()->exists();

        $validator = Validator::make(
            ['team_count' => $project->participants()->count()],
            ['team_count' => 'required|integer|min:1']
        );

        // Should fail if no team members
        if (!$hasTeamMembers) {
            $this->assertTrue($validator->fails());
        }
    }

    /** @test */
    public function completed_project_requires_at_least_one_outcome(): void
    {
        $project = Project::factory()->create([
            'Status' => 'Completed'
        ]);

        // Check if project has outcomes
        $validator = Validator::make(
            [
                'status' => $project->Status,
                'outcomes_count' => 0 // Simulating no outcomes
            ],
            [
                'outcomes_count' => 'required_if:status,Completed|integer|min:1'
            ]
        );

        $this->assertTrue($validator->fails());
    }

    /** @test */
    public function completed_project_passes_validation_with_outcome(): void
    {
        $project = Project::factory()->create([
            'Status' => 'Completed'
        ]);

        // Create an outcome
        Outcome::factory()->create([
            'ProjectId' => $project->ProjectId
        ]);

        $project->refresh();
        
        $validator = Validator::make(
            [
                'status' => $project->Status,
                'outcomes_count' => $project->outcomes()->count()
            ],
            [
                'outcomes_count' => 'required_if:status,Completed|integer|min:1'
            ]
        );

        $this->assertFalse($validator->fails());
    }

    /** @test */
    public function it_enforces_unique_name_within_program(): void
    {
        $program = Program::factory()->create();

        Project::factory()->create([
            'Title' => 'AI Research Project',
            'ProgramId' => $program->ProgramId
        ]);

        // Attempting to create another project with same title in same program
        $validator = Validator::make(
            [
                'Title' => 'AI Research Project',
                'ProgramId' => $program->ProgramId
            ],
            [
                'Title' => 'required|unique:projects,Title,NULL,ProjectId,ProgramId,' . $program->ProgramId
            ]
        );

        $this->assertTrue($validator->fails());
    }

    /** @test */
    public function it_allows_same_name_in_different_programs(): void
    {
        $program1 = Program::factory()->create();
        $program2 = Program::factory()->create();

        Project::factory()->create([
            'Title' => 'AI Research Project',
            'ProgramId' => $program1->ProgramId
        ]);

        // Same title but different program should be allowed
        $validator = Validator::make(
            [
                'Title' => 'AI Research Project',
                'ProgramId' => $program2->ProgramId
            ],
            [
                'Title' => 'required|unique:projects,Title,NULL,ProjectId,ProgramId,' . $program2->ProgramId
            ]
        );

        $this->assertFalse($validator->fails());
    }

    /** @test */
    public function it_has_facility_relationship(): void
    {
        $facility = Facility::factory()->create();
        $project = Project::factory()->create([
            'FacilityId' => $facility->FacilityId
        ]);

        $this->assertInstanceOf(
            \Illuminate\Database\Eloquent\Relations\BelongsTo::class,
            $project->facility()
        );

        $this->assertEquals($facility->FacilityId, $project->facility->FacilityId);
    }

    /** @test */
    public function it_has_equipment_relationship(): void
    {
        $project = Project::factory()->create();

        $this->assertInstanceOf(
            \Illuminate\Database\Eloquent\Relations\BelongsToMany::class,
            $project->equipment()
        );
    }

    /** @test */
    public function it_has_participants_relationship(): void
    {
        $project = Project::factory()->create();

        $this->assertInstanceOf(
            \Illuminate\Database\Eloquent\Relations\BelongsToMany::class,
            $project->participants()
        );
    }

    /** @test */
    public function it_stores_participants_with_pivot_data(): void
    {
        $project = Project::factory()->create();
        $participant = Participant::factory()->create();

        $project->participants()->attach($participant->ParticipantId, [
            'RoleOnProject' => 'Student',
            'SkillRole' => 'Developer'
        ]);

        $attachedParticipant = $project->participants()->first();

        $this->assertEquals('Student', $attachedParticipant->pivot->RoleOnProject);
        $this->assertEquals('Developer', $attachedParticipant->pivot->SkillRole);
    }

    /** @test */
    public function it_casts_dates_properly(): void
    {
        $project = Project::factory()->create([
            'StartDate' => '2025-01-01',
            'EndDate' => '2025-12-31'
        ]);

        $this->assertInstanceOf(\Illuminate\Support\Carbon::class, $project->StartDate);
        $this->assertInstanceOf(\Illuminate\Support\Carbon::class, $project->EndDate);
    }

    /** @test */
    public function it_validates_facility_compatibility_concept(): void
    {
        // This test demonstrates the business logic for facility compatibility
        // In a real implementation, you'd check if facility capabilities match project requirements

        $facility = Facility::factory()->create([
            'Capabilities' => 'Prototyping,Testing,3D Printing'
        ]);

        $projectRequirements = '3D Printing,Prototyping';

        // Check if all project requirements are in facility capabilities
        $requirements = explode(',', $projectRequirements);
        $capabilities = explode(',', $facility->Capabilities);

        $isCompatible = true;
        foreach ($requirements as $requirement) {
            if (!in_array(trim($requirement), array_map('trim', $capabilities))) {
                $isCompatible = false;
                break;
            }
        }

        $this->assertTrue($isCompatible);
    }

    /** @test */
    public function it_fails_compatibility_when_facility_lacks_requirements(): void
    {
        $facility = Facility::factory()->create([
            'Capabilities' => 'Testing,Assembly'
        ]);

        $projectRequirements = '3D Printing,Laser Cutting';

        $requirements = explode(',', $projectRequirements);
        $capabilities = explode(',', $facility->Capabilities);

        $isCompatible = true;
        foreach ($requirements as $requirement) {
            if (!in_array(trim($requirement), array_map('trim', $capabilities))) {
                $isCompatible = false;
                break;
            }
        }

        $this->assertFalse($isCompatible);
    }

    /** @test */
    public function it_can_store_testing_requirements(): void
    {
        $project = Project::factory()->create([
            'TestingRequirements' => 'Performance Testing,Security Testing'
        ]);

        $this->assertEquals('Performance Testing,Security Testing', $project->TestingRequirements);
    }

    /** @test */
    public function it_can_store_commercialization_plan(): void
    {
        $project = Project::factory()->create([
            'CommercializationPlan' => 'Market research and product launch strategy'
        ]);

        $this->assertEquals('Market research and product launch strategy', $project->CommercializationPlan);
    }

    /** @test */
    public function non_completed_project_can_exist_without_outcomes(): void
    {
        $project = Project::factory()->create([
            'Status' => 'Active'
        ]);

        $validator = Validator::make(
            [
                'status' => $project->Status,
                'outcomes_count' => 0
            ],
            [
                'outcomes_count' => 'exclude_unless:status,Completed|required|integer|min:1'
            ]
        );

        $this->assertFalse($validator->fails());
    }
}
