<?php
namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Equipment;
use App\Models\Facility;
use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EquipmentRulesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_requires_facility_name_and_inventory_code()
    {
        $response = $this->post('/equipment', []);
        $response->assertSessionHasErrors(['FacilityId', 'Name', 'InventoryCode']);
    }

    /** @test */
/** @test */
public function inventory_code_must_be_unique()
{
    $facility = Facility::factory()->create();

    Equipment::factory()
        ->for($facility, 'facility') // ✅ This sets the relationship properly
        ->create(['Name' => 'Existing Equipment',
        'InventoryCode' => 'EQ123',
        'Name' => 'Existing Equipment',
        'UsageDomain' => 'Electronics',
        'SupportPhase' => 'Prototyping',
        'Capabilities' => 'Advanced'
    ]);

    $response = $this->post('/equipment', [
        'FacilityId' => $facility->id,
        'Name' => 'New Equipment',
        'InventoryCode' => 'EQ123', // duplicate
        'UsageDomain' => 'Electronics',
        'SupportPhase' => 'Prototyping',
        'Capabilities' => 'Basic'
    ]);

    $response->assertSessionHasErrors(['InventoryCode']);
}

    /** @test */
    /** @test */
public function electronics_must_support_prototyping_or_testing()
{
    $facility = Facility::factory()->create();

    $response = $this->post('/equipment', [
        'FacilityId' => $facility->id,
        'Name' => 'Test Equipment',
        'InventoryCode' => 'EQ123',
        'UsageDomain' => 'Electronics',
        'SupportPhase' => 'Training', // Invalid for Electronics
        'Capabilities' => 'Basic'
    ]);

    $response->assertSessionHasErrors(['SupportPhase']);
}
    /** @test */
    public function equipment_cannot_be_deleted_if_referenced_by_active_project()
{
    $facility = Facility::factory()->create();

    $equipment = Equipment::factory()
        ->for($facility, 'facility') // ✅ ensures FacilityId is set
        ->create([
            'Name' => 'Test Equipment',
            'InventoryCode' => 'EQ234',
            'UsageDomain' => 'Electronics',
            'SupportPhase' => 'Prototyping',
            'Capabilities' => 'Advanced'
        ]);

    $project = Project::factory()->create([
        'EquipmentId' => $equipment->EquipmentId // or whatever foreign key your project uses
    ]);

    $response = $this->delete("/equipment/{$equipment->EquipmentId}");

    $response->assertSessionHasErrors(['delete']); // or assertStatus(403) if you're blocking deletion
}
}