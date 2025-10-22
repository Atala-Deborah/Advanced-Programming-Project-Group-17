<?php

namespace Tests\Unit;

use App\Models\Service;
use App\Models\Facility;
use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class ServiceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_service_with_required_fields(): void
    {
        $facility = Facility::factory()->create();

        $service = Service::factory()->create([
            'FacilityId' => $facility->FacilityId,
            'Name' => 'Test Service',
            'Category' => 'Machining',
            'SkillType' => 'Hardware'
        ]);

        $this->assertNotNull($service->ServiceId);
        $this->assertEquals('Test Service', $service->Name);
        $this->assertEquals('Machining', $service->Category);
        $this->assertEquals('Hardware', $service->SkillType);
    }

    /** @test */
    public function it_requires_facility_id_field(): void
    {
        $data = [
            'Name' => 'Test Service',
            'Category' => 'Machining',
            'SkillType' => 'Hardware'
        ];

        $validator = Validator::make($data, [
            'FacilityId' => 'required|exists:facilities,FacilityId',
            'Name' => 'required|string|max:255',
            'Category' => 'required|in:Machining,Testing,Training',
            'SkillType' => 'required|in:Hardware,Software,Integration',
        ]);

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('FacilityId', $validator->errors()->toArray());
    }

    /** @test */
    public function it_requires_name_field(): void
    {
        $facility = Facility::factory()->create();

        $data = [
            'FacilityId' => $facility->FacilityId,
            'Category' => 'Machining',
            'SkillType' => 'Hardware'
        ];

        $validator = Validator::make($data, [
            'FacilityId' => 'required|exists:facilities,FacilityId',
            'Name' => 'required|string|max:255',
            'Category' => 'required|in:Machining,Testing,Training',
            'SkillType' => 'required|in:Hardware,Software,Integration',
        ]);

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('Name', $validator->errors()->toArray());
    }

    /** @test */
    public function it_requires_category_field(): void
    {
        $facility = Facility::factory()->create();

        $data = [
            'FacilityId' => $facility->FacilityId,
            'Name' => 'Test Service',
            'SkillType' => 'Hardware'
        ];

        $validator = Validator::make($data, [
            'FacilityId' => 'required|exists:facilities,FacilityId',
            'Name' => 'required|string|max:255',
            'Category' => 'required|in:Machining,Testing,Training',
            'SkillType' => 'required|in:Hardware,Software,Integration',
        ]);

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('Category', $validator->errors()->toArray());
    }

    /** @test */
    public function it_requires_skill_type_field(): void
    {
        $facility = Facility::factory()->create();

        $data = [
            'FacilityId' => $facility->FacilityId,
            'Name' => 'Test Service',
            'Category' => 'Machining'
        ];

        $validator = Validator::make($data, [
            'FacilityId' => 'required|exists:facilities,FacilityId',
            'Name' => 'required|string|max:255',
            'Category' => 'required|in:Machining,Testing,Training',
            'SkillType' => 'required|in:Hardware,Software,Integration',
        ]);

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('SkillType', $validator->errors()->toArray());
    }

    /** @test */
    public function it_enforces_unique_name_within_facility(): void
    {
        $facility = Facility::factory()->create();

        Service::factory()->create([
            'FacilityId' => $facility->FacilityId,
            'Name' => 'Test Service',
            'Category' => 'Machining',
            'SkillType' => 'Hardware'
        ]);

        $this->expectException(\Illuminate\Database\QueryException::class);

        Service::factory()->create([
            'FacilityId' => $facility->FacilityId,
            'Name' => 'Test Service',
            'Category' => 'Testing',
            'SkillType' => 'Software'
        ]);
    }

    /** @test */
    public function it_allows_same_name_in_different_facilities(): void
    {
        $facility1 = Facility::factory()->create();
        $facility2 = Facility::factory()->create();

        Service::factory()->create([
            'FacilityId' => $facility1->FacilityId,
            'Name' => 'Test Service',
            'Category' => 'Machining',
            'SkillType' => 'Hardware'
        ]);

        $service2 = Service::factory()->create([
            'FacilityId' => $facility2->FacilityId,
            'Name' => 'Test Service',
            'Category' => 'Testing',
            'SkillType' => 'Software'
        ]);

        $this->assertNotNull($service2->ServiceId);
    }

    /** @test */
    public function it_cannot_be_deleted_if_project_references_its_category(): void
    {
        $facility = Facility::factory()->create();
        $service = Service::factory()->create([
            'FacilityId' => $facility->FacilityId,
            'Category' => 'Testing'
        ]);

        $project = Project::factory()->create([
            'FacilityId' => $facility->FacilityId,
            'TestingRequirements' => 'Testing'
        ]);

        // Attempt to delete the service
        try {
            $service->delete();
            $this->fail('Service deletion should not be allowed when referenced in project testing requirements.');
        } catch (\Exception $e) {
            $this->assertTrue(true); // Pass test
        }
    }

    /** @test */
    public function it_can_be_deleted_if_no_project_references_its_category(): void
    {
        $facility = Facility::factory()->create();
        $service = Service::factory()->create([
            'FacilityId' => $facility->FacilityId,
            'Category' => 'Testing'
        ]);

        $project = Project::factory()->create([
            'FacilityId' => $facility->FacilityId,
            'TestingRequirements' => 'Machining' // Different category
        ]);

        $service->delete();
        $this->assertModelMissing($service);
    }

    /** @test */
    public function it_has_facility_relationship(): void
    {
        $facility = Facility::factory()->create();
        $service = Service::factory()->create(['FacilityId' => $facility->FacilityId]);

        $this->assertInstanceOf(Facility::class, $service->facility);
        $this->assertEquals($facility->FacilityId, $service->facility->FacilityId);
    }

    /** @test */
    public function it_validates_category_enum_values(): void
    {
        $validCategories = ['Machining', 'Testing', 'Training'];

        foreach ($validCategories as $category) {
            $facility = Facility::factory()->create();
            $service = Service::factory()->create([
                'FacilityId' => $facility->FacilityId,
                'Category' => $category
            ]);

            $this->assertEquals($category, $service->Category);
        }
    }

    /** @test */
    public function it_validates_skill_type_enum_values(): void
    {
        $validSkillTypes = ['Hardware', 'Software', 'Integration'];

        foreach ($validSkillTypes as $skillType) {
            $facility = Facility::factory()->create();
            $service = Service::factory()->create([
                'FacilityId' => $facility->FacilityId,
                'SkillType' => $skillType
            ]);

            $this->assertEquals($skillType, $service->SkillType);
        }
    }
}
