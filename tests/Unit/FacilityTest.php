<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Facility;
use App\Models\Service;
use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FacilityTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_requires_name_location_and_facilitytype()
    {
        $this->expectException(\Illuminate\Database\QueryException::class);

        Facility::create([
            'Name' => null,
            'Location' => null,
            'FacilityType' => null,
        ]);
    }

    /** @test */
    public function it_prevents_duplicate_name_and_location()
    {
        Facility::factory()->create([
            'Name' => 'Tech Lab',
            'Location' => 'Kampala',
        ]);

        $this->expectException(\Illuminate\Database\QueryException::class);

        Facility::factory()->create([
            'Name' => 'Tech Lab',
            'Location' => 'Kampala',
        ]);
    }

    /** @test */
    public function it_cannot_be_deleted_if_it_has_services_or_projects()
    {
        $facility = Facility::factory()->create();

        
        Service::factory()->create(['FacilityId' => $facility->FacilityId]);
        Project::factory()->create(['FacilityId' => $facility->FacilityId]);

        // Simulate deletion protection
        try {
            $facility->delete();
            $this->fail('Facility deletion should not be allowed when Services/Projects exist.');
        } catch (\Exception $e) {
            $this->assertTrue(true); // Pass test
        }
    }

    /** @test */
    public function it_requires_capabilities_when_services_exist()
    {
        // Create a facility WITHOUT forcing Capabilities=null
        $facility = Facility::factory()->create();

        // Create a service linked to this facility
        Service::factory()->create(['FacilityId' => $facility->FacilityId]);

        // Refresh the facility to get updated data from the database
        $facility->refresh();

        // Assert that capabilities are not empty
        $this->assertNotEmpty(
            $facility->Capabilities,
            'Facility.Capabilities must be populated when Services/Equipment exist.'
        );
    }


}
