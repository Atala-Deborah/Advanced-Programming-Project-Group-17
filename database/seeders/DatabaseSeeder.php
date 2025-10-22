<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Service;
use App\Models\Facility;
use App\Models\Equipment;
use App\Models\Program;
use App\Models\Project;
use App\Models\Participant;
use App\Models\Outcome;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create test user
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Create Facilities first
        $facilities = [
            [
                'Name' => 'Innovation Hub',
                'Location' => 'Kampala',
                'Description' => 'Main innovation and prototyping center',
                'PartnerOrganization' => 'Makerere University',
                'FacilityType' => 'Lab',
                'Capabilities' => 'Electronics, IoT, 3D Printing, PCB Design',
            ],
            [
                'Name' => 'Fabrication Lab',
                'Location' => 'Entebbe',
                'Description' => 'Advanced manufacturing and testing facility',
                'PartnerOrganization' => 'Uganda Industrial Research Institute',
                'FacilityType' => 'Workshop',
                'Capabilities' => 'Mechanical Fabrication, CNC Machining, Welding',
            ],
            [
                'Name' => 'Testing Center',
                'Location' => 'Jinja',
                'Description' => 'Quality assurance and product testing',
                'PartnerOrganization' => 'Uganda National Bureau of Standards',
                'FacilityType' => 'Testing Center',
                'Capabilities' => 'Product Testing, Certification, Quality Control',
            ],
        ];

        foreach ($facilities as $facilityData) {
            Facility::create($facilityData);
        }

        // Create Services
        $services = [
            [
                'FacilityId' => 1,
                'Name' => 'IoT Training Program',
                'Description' => 'Comprehensive IoT development training',
                'Category' => 'Training',
                'SkillType' => 'Integration',
            ],
            [
                'FacilityId' => 2,
                'Name' => 'CNC Machining Service',
                'Description' => 'Precision CNC machining for prototypes',
                'Category' => 'Machining',
                'SkillType' => 'Hardware',
            ],
            [
                'FacilityId' => 3,
                'Name' => 'Product Testing Service',
                'Description' => 'Comprehensive product quality testing',
                'Category' => 'Testing',
                'SkillType' => 'Hardware',
            ],
        ];

        foreach ($services as $serviceData) {
            Service::create($serviceData);
        }

        // Create Programs (with proper business rule compliance)
        $programs = [
            [
                'Name' => 'Digital Innovation Program',
                'Description' => 'Advancing digital innovation and 4IR technologies',
                'FocusAreas' => 'IoT',
                'NationalAlignment' => 'NDPIII, DigitalRoadmap2023_2028, 4IR',
                'Phases' => 'Prototyping',
            ],
            [
                'Name' => 'Manufacturing Excellence Initiative',
                'Description' => 'Enhancing local manufacturing capabilities',
                'FocusAreas' => 'Automation',
                'NationalAlignment' => 'NDPIII, 4IR',
                'Phases' => 'Technical Skills',
            ],
            [
                'Name' => 'Renewable Energy Program',
                'Description' => 'Developing renewable energy solutions',
                'FocusAreas' => 'Renewable Energy',
                'NationalAlignment' => 'NDPIII',
                'Phases' => 'Collaboration',
            ],
        ];

        foreach ($programs as $programData) {
            Program::create($programData);
        }

        // Create Equipment (with proper business rule compliance)
        $equipment = [
            [
                'FacilityId' => 1,
                'Name' => 'Arduino Starter Kit',
                'Capabilities' => 'IoT Prototyping, Sensor Integration',
                'Description' => 'Complete IoT development kit',
                'InventoryCode' => 'IOT-ARD-001',
                'UsageDomain' => 'Electronics',
                'SupportPhase' => 'Prototyping', // Electronics must be Prototyping
            ],
            [
                'FacilityId' => 1,
                'Name' => 'Raspberry Pi 4',
                'Capabilities' => 'Computing, IoT Gateway',
                'Description' => 'Single board computer for IoT projects',
                'InventoryCode' => 'IOT-RPI-001',
                'UsageDomain' => 'IoT',
                'SupportPhase' => 'Training',
            ],
            [
                'FacilityId' => 2,
                'Name' => 'CNC Milling Machine',
                'Capabilities' => 'Precision Machining, Prototyping',
                'Description' => '3-axis CNC mill for metal and plastic',
                'InventoryCode' => 'MECH-CNC-001',
                'UsageDomain' => 'Mechanical',
                'SupportPhase' => 'Prototyping',
            ],
        ];

        foreach ($equipment as $equipmentData) {
            Equipment::create($equipmentData);
        }

        // Create Participants
        $participants = [
            [
                'FullName' => 'John Doe',
                'Email' => 'john.doe@example.com',
                'Affiliation' => 'CS',
                'Specialization' => 'Software',
                'CrossSkillTrained' => true,
                'Institution' => 'SCIT',
            ],
            [
                'FullName' => 'Jane Smith',
                'Email' => 'jane.smith@example.com',
                'Affiliation' => 'Engineering',
                'Specialization' => 'Hardware',
                'CrossSkillTrained' => true,
                'Institution' => 'UIRI',
            ],
            [
                'FullName' => 'Peter Owino',
                'Email' => 'peter.owino@example.com',
                'Affiliation' => 'SE',
                'Specialization' => 'Software',
                'CrossSkillTrained' => false,
                'Institution' => 'UniPod',
            ],
            [
                'FullName' => 'Sarah Nakato',
                'Email' => 'sarah.nakato@example.com',
                'Affiliation' => 'Engineering',
                'Specialization' => 'Business',
                'CrossSkillTrained' => true,
                'Institution' => 'CEDAT',
            ],
        ];

        foreach ($participants as $participantData) {
            Participant::create($participantData);
        }

        // Create Projects (with proper business rule compliance)
        $projects = [
            [
                'ProgramId' => 1,
                'FacilityId' => 1,
                'Title' => 'Smart Agriculture System',
                'Description' => 'IoT-based smart agriculture monitoring system',
                'NatureOfProject' => 'Research',
                'Status' => 'Active',
                'InnovationFocus' => 'Agricultural IoT',
                'PrototypeStage' => 'Prototype',
                'StartDate' => now()->subMonths(2),
                'EndDate' => now()->addMonths(4),
            ],
            [
                'ProgramId' => 1,
                'FacilityId' => 1,
                'Title' => 'IoT Weather Station',
                'Description' => 'Real-time weather monitoring using IoT sensors',
                'NatureOfProject' => 'Prototype',
                'Status' => 'Planning',
                'InnovationFocus' => 'Environmental Monitoring',
                'PrototypeStage' => 'Concept',
                'StartDate' => now()->addMonth(),
                'EndDate' => now()->addMonths(5),
            ],
            [
                'ProgramId' => 2,
                'FacilityId' => 2,
                'Title' => 'Automated Production Line',
                'Description' => 'Automated manufacturing system for local production',
                'NatureOfProject' => 'Applied work',
                'Status' => 'Active',
                'InnovationFocus' => 'Manufacturing Automation',
                'PrototypeStage' => 'MVP',
                'StartDate' => now()->subMonths(6),
                'EndDate' => now()->addMonths(6),
            ],
            [
                'ProgramId' => 3,
                'FacilityId' => 3,
                'Title' => 'Solar Water Pump',
                'Description' => 'Solar-powered water pumping system for rural communities',
                'NatureOfProject' => 'Prototype',
                'Status' => 'Completed',
                'InnovationFocus' => 'Renewable Energy',
                'PrototypeStage' => 'Market Launch',
                'StartDate' => now()->subMonths(8),
                'EndDate' => now()->subMonth(),
            ],
        ];

        foreach ($projects as $projectData) {
            Project::create($projectData);
        }

        // Attach participants to projects (team tracking - at least 1 per project)
        Project::find(1)->participants()->attach(1, ['RoleOnProject' => 'Student', 'SkillRole' => 'Developer']);
        Project::find(1)->participants()->attach(2, ['RoleOnProject' => 'Contributor', 'SkillRole' => 'Engineer']);
        Project::find(2)->participants()->attach(1, ['RoleOnProject' => 'Lecturer', 'SkillRole' => 'Developer']);
        Project::find(3)->participants()->attach(2, ['RoleOnProject' => 'Lecturer', 'SkillRole' => 'Engineer']);
        Project::find(3)->participants()->attach(3, ['RoleOnProject' => 'Student', 'SkillRole' => 'Developer']);
        Project::find(4)->participants()->attach(2, ['RoleOnProject' => 'Lecturer', 'SkillRole' => 'Engineer']);
        Project::find(4)->participants()->attach(4, ['RoleOnProject' => 'Student', 'SkillRole' => 'Business Lead']);

        // Create Outcomes for some projects (ProjectId 1 and 4)
        Outcome::create([
            'ProjectId' => 1,
            'Title' => 'IoT Sensor Prototype',
            'Description' => 'Functional prototype of IoT sensor network',
            'OutcomeType' => 'Prototype',
            'CommercializationStatus' => 'Demoed',
            'ArtifactLink' => 'https://github.com/iot-sensor',
            'QualityCertification' => 'ISO 9001',
        ]);

        Outcome::create([
            'ProjectId' => 4,
            'Title' => 'Solar Water Pump Prototype',
            'Description' => 'Successfully developed and tested solar-powered water pump',
            'OutcomeType' => 'Prototype',
            'CommercializationStatus' => 'Market Linked',
            'ArtifactLink' => 'https://github.com/solar-pump',
        ]);
    }
}

