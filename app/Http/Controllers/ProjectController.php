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
            'Title' => [
                'required',
                'string',
                'max:100',
                function ($attribute, $value, $fail) use ($request) {
                    // BR: Title must be unique within Program
                    if ($request->has('ProgramId')) {
                        $exists = Project::where('ProgramId', $request->input('ProgramId'))
                            ->where('Title', $value)
                            ->exists();
                        if ($exists) {
                            $fail('The Title must be unique within the Program.');
                        }
                    }
                },
            ],
            'NatureOfProject' => 'required|in:Small,Large,Other',
            'Status' => 'required|in:Draft,Active,Completed,Archived',
            'Phases' => 'required|in:Planning,Execution,Monitoring,Closure',
            'Budget' => 'nullable|numeric|min:0',
            'ActualCost' => 'nullable|numeric|min:0',
            'StartDate' => 'nullable|date',
            'EndDate' => 'nullable|date|after_or_equal:StartDate',
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
            'Title' => [
                'required',
                'string',
                'max:100',
                function ($attribute, $value, $fail) use ($request, $project) {
                    // BR: Title must be unique within Program
                    if ($request->has('ProgramId')) {
                        $exists = Project::where('ProgramId', $request->input('ProgramId'))
                            ->where('Title', $value)
                            ->where('ProjectId', '!=', $project->ProjectId)
                            ->exists();
                        if ($exists) {
                            $fail('The Title must be unique within the Program.');
                        }
                    }
                },
            ],
            'NatureOfProject' => 'required|in:Small,Large,Other',
            'Status' => [
                'required',
                'in:Draft,Active,Completed,Archived',
                function ($attribute, $value, $fail) use ($project) {
                    // BR: If Status is Completed, must have at least one Outcome
                    if ($value === 'Completed' && $project->outcomes()->count() === 0) {
                        $fail('Cannot set Status to Completed without at least one Outcome.');
                    }
                },
            ],
            'Phases' => 'required|in:Planning,Execution,Monitoring,Closure',
            'Budget' => 'nullable|numeric|min:0',
            'ActualCost' => 'nullable|numeric|min:0',
            'StartDate' => 'nullable|date',
            'EndDate' => 'nullable|date|after_or_equal:StartDate',
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
            'reassignOptions' => [] // Projects don't typically get reassigned
        ]);
    }

    public function destroy(Project $project)
    {
        // BR: Project must have at least 1 Participant (team tracking)
        if ($project->participants()->count() === 0) {
            return redirect()->route('projects.index')
                ->with('error', 'Cannot delete Project without Participants; add team members first.');
        }

        $project->delete();
        return redirect()->route('projects.index');
    }

    public function attachEquipment(Request $request, Project $project, Equipment $equipment)
    {
        if (!$project->equipment->contains($equipment->EquipmentId)) {
            $project->equipment()->attach($equipment->EquipmentId);
            return redirect()->route('projects.show', $project)
                ->with('success', 'Equipment attached successfully');
        }
        
        return redirect()->route('projects.show', $project)
            ->with('error', 'Equipment is already attached to this project');
    }

    public function detachEquipment(Project $project, Equipment $equipment)
    {
        $project->equipment()->detach($equipment->EquipmentId);
        return redirect()->route('projects.show', $project)
            ->with('success', 'Equipment removed successfully');
    }
}
