<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Facility;
use App\Models\Equipment;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $query = Project::with(['facility', 'participants']);

        // Search functionality
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('Title', 'like', "%{$search}%")
                  ->orWhere('Description', 'like', "%{$search}%")
                  ->orWhere('InnovationFocus', 'like', "%{$search}%");
            });
        }

        // Filter by facility
        if ($request->has('facility') && $request->facility !== 'all') {
            $query->where('FacilityId', $request->facility);
        }

        // Filter by status
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('Status', $request->status);
        }

        // Filter by project nature
        if ($request->has('nature') && $request->nature !== 'all') {
            $query->where('NatureOfProject', $request->nature);
        }

        // Filter by prototype stage
        if ($request->has('stage') && $request->stage !== 'all') {
            $query->where('PrototypeStage', $request->stage);
        }

        // Get all facilities for filter dropdown
        $facilities = Facility::orderBy('Name')->pluck('Name', 'FacilityId');
        
        // Define status options
        $statuses = [
            'Planning' => 'Planning',
            'Active' => 'Active',
            'On Hold' => 'On Hold',
            'Completed' => 'Completed'
        ];

        // Define project natures
        $natures = [
            'Research' => 'Research',
            'Prototype' => 'Prototype',
            'Applied work' => 'Applied Work'
        ];

        // Define prototype stages
        $stages = [
            'Concept' => 'Concept',
            'Prototype' => 'Prototype',
            'MVP' => 'Minimum Viable Product',
            'Market Launch' => 'Market Launch'
        ];

        // Get filtered and paginated results
        $projects = $query->orderBy('StartDate', 'desc')
                         ->paginate(10)
                         ->withQueryString();

        return view('projects.index', compact(
            'projects', 
            'facilities',
            'statuses',
            'natures',
            'stages'
        ));
    }
    
    // Show projects by facility
    public function byFacility($facilityId)
    {
        $facility = Facility::findOrFail($facilityId);
        
        $query = Project::where('FacilityId', $facilityId)
                      ->with(['facility', 'participants']);
        
        // Search functionality
        if (request()->has('search')) {
            $search = request('search');
            $query->where(function($q) use ($search) {
                $q->where('Title', 'like', "%{$search}%")
                  ->orWhere('Description', 'like', "%{$search}%")
                  ->orWhere('InnovationFocus', 'like', "%{$search}%");
            });
        }
        
        // Filter by status
        if (request()->has('status') && request('status') !== 'all') {
            $query->where('Status', request('status'));
        }
        
        // Filter by project nature
        if (request()->has('nature') && request('nature') !== 'all') {
            $query->where('NatureOfProject', request('nature'));
        }
        
        // Filter by prototype stage
        if (request()->has('stage') && request('stage') !== 'all') {
            $query->where('PrototypeStage', request('stage'));
        }
        
        // Date range filter
        if (request()->has('start_date') && request('start_date')) {
            $query->whereDate('StartDate', '>=', request('start_date'));
        }
        if (request()->has('end_date') && request('end_date')) {
            $query->whereDate('EndDate', '<=', request('end_date'));
        }
        
        $projects = $query->orderBy('StartDate', 'desc')
                         ->paginate(10)
                         ->withQueryString();
        
        // Define status options
        $statuses = [
            'Planning' => 'Planning',
            'Active' => 'Active',
            'On Hold' => 'On Hold',
            'Completed' => 'Completed'
        ];
        
        // Define project natures
        $natures = [
            'Research' => 'Research',
            'Prototype' => 'Prototype',
            'Applied work' => 'Applied Work'
        ];
        
        // Define prototype stages
        $stages = [
            'Concept' => 'Concept',
            'Prototype' => 'Prototype',
            'MVP' => 'Minimum Viable Product',
            'Market Launch' => 'Market Launch'
        ];
        
        return view('projects.index', [
            'projects' => $projects,
            'facility' => $facility,
            'facilities' => Facility::orderBy('Name')->pluck('Name', 'FacilityId'),
            'statuses' => $statuses,
            'natures' => $natures,
            'stages' => $stages,
            'currentFilters' => request()->all()
        ]);
    }

    public function create()
    {
        $facilities = Facility::orderBy('Name')->get();
        $programs = \App\Models\Program::orderBy('Name')->get();
        $selectedFacilityId = request('facility_id');
        return view('projects.create', compact('facilities', 'programs', 'selectedFacilityId'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'ProgramId' => [
                'required',
                'exists:programs,ProgramId',
            ],
            'Title' => [
                'required',
                'string',
                'max:255',
                function ($attribute, $value, $fail) use ($request) {
                    // BR12: Title must be unique within Program
                    if ($request->has('ProgramId')) {
                        $exists = Project::where('ProgramId', $request->input('ProgramId'))
                            ->where('Title', $value)
                            ->exists();
                        if ($exists) {
                            $fail('A project with this title already exists in the selected program.');
                        }
                    }
                },
            ],
            'Description' => 'required|string',
            'NatureOfProject' => 'required|in:Research,Prototype,Applied work',
            'Status' => [
                'required',
                'in:Planning,Active,Completed,On Hold',
                function ($attribute, $value, $fail) {
                    // BR20: Cannot create project with Completed status (no outcomes exist yet)
                    if ($value === 'Completed') {
                        $fail('Cannot create a project with Completed status. Please add outcomes after creating the project.');
                    }
                },
            ],
            'InnovationFocus' => 'nullable|string|max:255',
            'PrototypeStage' => 'required|in:Concept,Prototype,MVP,Market Launch',
            'StartDate' => 'required|date',
            'EndDate' => 'nullable|date|after_or_equal:StartDate',
            'TestingRequirements' => 'nullable|string',
            'CommercializationPlan' => 'nullable|string',
            'FacilityId' => [
                'required',
                'exists:facilities,FacilityId',
                function ($attribute, $value, $fail) use ($request) {
                    // BR: Facility must have compatible ServiceType
                    $facility = Facility::find($value);
                    if ($facility && $request->has('ProgramId')) {
                        $program = \App\Models\Program::find($request->input('ProgramId'));
                        if ($program) {
                            $service = $program->service;
                            if ($service && $facility->ServiceType !== $service->ServiceType) {
                                $fail('The selected Facility ServiceType must match the Program Service ServiceType.');
                            }
                        }
                    }
                },
            ],
            'ProgramId' => 'required|exists:programs,ProgramId',
        ]);

        $project = Project::create($validated);
        return redirect()->route('projects.show', $project);
    }

    public function show(Project $project)
    {
        $project->load(['facility', 'equipment', 'participants']);
        return view('projects.show', compact('project'));
    }

    public function edit(Project $project)
    {
        $facilities = Facility::orderBy('Name')->get();
        $programs = \App\Models\Program::orderBy('Name')->get();
        return view('projects.edit', compact('project', 'facilities', 'programs'));
    }

    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'ProgramId' => [
                'required',
                'exists:programs,ProgramId',
            ],
            'Title' => [
                'required',
                'string',
                'max:255',
                function ($attribute, $value, $fail) use ($request, $project) {
                    // BR12: Title must be unique within Program
                    if ($request->has('ProgramId')) {
                        $exists = Project::where('ProgramId', $request->input('ProgramId'))
                            ->where('Title', $value)
                            ->where('ProjectId', '!=', $project->ProjectId)
                            ->exists();
                        if ($exists) {
                            $fail('A project with this title already exists in the selected program.');
                        }
                    }
                },
            ],
            'Description' => 'required|string',
            'NatureOfProject' => 'required|in:Research,Prototype,Applied work',
            'Status' => [
                'required',
                'in:Planning,Active,Completed,On Hold',
                function ($attribute, $value, $fail) use ($project) {
                    // BR20: If Status is Completed, must have at least one Outcome
                    if ($value === 'Completed' && $project->outcomes()->count() === 0) {
                        $fail('Cannot mark project as Completed without at least one documented outcome. Please add an outcome first.');
                    }
                },
            ],
            'InnovationFocus' => 'nullable|string|max:255',
            'PrototypeStage' => 'required|in:Concept,Prototype,MVP,Market Launch',
            'StartDate' => 'required|date',
            'EndDate' => 'nullable|date|after_or_equal:StartDate',
            'TestingRequirements' => 'nullable|string',
            'CommercializationPlan' => 'nullable|string',
            'FacilityId' => [
                'required',
                'exists:facilities,FacilityId',
                function ($attribute, $value, $fail) use ($request) {
                    // BR: Facility must have compatible ServiceType
                    $facility = Facility::find($value);
                    if ($facility && $request->has('ProgramId')) {
                        $program = \App\Models\Program::find($request->input('ProgramId'));
                        if ($program) {
                            $service = $program->service;
                            if ($service && $facility->ServiceType !== $service->ServiceType) {
                                $fail('The selected Facility ServiceType must match the Program Service ServiceType.');
                            }
                        }
                    }
                },
            ],
            'ProgramId' => 'required|exists:programs,ProgramId',
        ]);

        $project->update($validated);
        return redirect()->route('projects.show', $project);
    }

    public function getDependencies(Project $project)
    {
        $dependencies = [];
        
        // Check for participants
        $participantsCount = $project->participants()->count();
        if ($participantsCount > 0) {
            $participantNames = $project->participants()->take(3)->pluck('FullName')->toArray();
            $participantText = $participantsCount === 1 ? 'participant assignment' : 'participant assignments';
            
            if ($participantsCount <= 3) {
                $dependencies[] = "{$participantsCount} {$participantText} (" . implode(', ', $participantNames) . ") will be removed";
            } else {
                $dependencies[] = "{$participantsCount} {$participantText} (" . implode(', ', $participantNames) . " and " . ($participantsCount - 3) . " more) will be removed";
            }
        }
        
        // Check for equipment
        $equipmentCount = $project->equipment()->count();
        if ($equipmentCount > 0) {
            $equipmentNames = $project->equipment()->take(2)->pluck('Name')->toArray();
            $equipmentText = $equipmentCount === 1 ? 'equipment assignment' : 'equipment assignments';
            
            if ($equipmentCount <= 2) {
                $dependencies[] = "{$equipmentCount} {$equipmentText} (" . implode(', ', $equipmentNames) . ") will be removed";
            } else {
                $dependencies[] = "{$equipmentCount} {$equipmentText} (" . implode(', ', $equipmentNames) . " and " . ($equipmentCount - 2) . " more) will be removed";
            }
        }
        
        return response()->json([
            'dependencies' => $dependencies,
            'reassignOptions' => []
        ]);
    }

    public function destroy(Project $project)
    {
        // Get project title for success message
        $projectTitle = $project->Title;
        $participantsCount = $project->participants()->count();
        
        // Delete project (cascade will remove participant assignments via database)
        $project->delete();
        
        // Build success message
        $message = "Project '{$projectTitle}' deleted successfully.";
        
        if ($participantsCount > 0) {
            $message .= " {$participantsCount} participant assignment(s) were removed.";
        }
        
        return redirect()->route('projects.index')
            ->with('success', $message);
    }

    public function attachEquipment(Request $request, Project $project, Equipment $equipment)
    {
        if (!$project->equipment->contains($equipment->EquipmentId)) {
            $project->equipment()->attach($equipment->EquipmentId);
            return redirect()->route('project.equipment.manage', $project->ProjectId)
                ->with('success', "Equipment '{$equipment->Name}' assigned successfully");
        }
        
        return redirect()->route('project.equipment.manage', $project->ProjectId)
            ->with('error', 'Equipment is already attached to this project');
    }

    public function detachEquipment(Project $project, Equipment $equipment)
    {
        $project->equipment()->detach($equipment->EquipmentId);
        return redirect()->route('project.equipment.manage', $project->ProjectId)
            ->with('success', "Equipment '{$equipment->Name}' removed successfully");
    }

    public function manageEquipment(Project $project)
    {
        // Load project with equipment
        $project->load('equipment', 'facility');
        
        // Get equipment from the same facility that aren't already assigned to this project
        $assignedEquipmentIds = $project->equipment->pluck('EquipmentId')->toArray();
        
        $availableEquipment = Equipment::where('FacilityId', $project->FacilityId)
            ->whereNotIn('EquipmentId', $assignedEquipmentIds)
            ->get();

        return view('project-equipment.manage', compact('project', 'availableEquipment'));
    }
}
