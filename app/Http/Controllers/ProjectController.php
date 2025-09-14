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
        $selectedFacilityId = request('facility_id');
        return view('projects.create', compact('facilities', 'selectedFacilityId'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'Title' => 'required|string|max:255',
            'Description' => 'required|string',
            'Status' => 'required|in:Planning,Active,Completed,On Hold',
            'NatureOfProject' => 'required|in:Research,Prototype,Applied work',
            'InnovationFocus' => 'nullable|string|max:255',
            'PrototypeStage' => 'required|in:Concept,Prototype,MVP,Market Launch',
            'StartDate' => 'required|date',
            'EndDate' => 'nullable|date|after:StartDate',
            'FacilityId' => 'required|exists:facilities,FacilityId'
        ]);

        Project::create($validated);
        return redirect()->route('projects.index')->with('success', 'Project created successfully');
    }

    public function show(Project $project)
    {
        $project->load(['facility', 'equipment', 'participants']);
        return view('projects.show', compact('project'));
    }

    public function edit(Project $project)
    {
        $facilities = Facility::all();
        return view('projects.edit', compact('project', 'facilities'));
    }

    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'Title' => 'required|string|max:255',
            'Description' => 'required|string',
            'Status' => 'required|in:Planning,Active,Completed,On Hold',
            'NatureOfProject' => 'required|in:Research,Prototype,Applied work',
            'InnovationFocus' => 'nullable|string|max:255',
            'PrototypeStage' => 'required|in:Concept,Prototype,MVP,Market Launch',
            'StartDate' => 'required|date',
            'EndDate' => 'nullable|date|after:StartDate',
            'FacilityId' => 'required|exists:facilities,FacilityId'
        ]);

        $project->update($validated);
        return redirect()->route('projects.show', $project)->with('success', 'Project updated successfully');
    }

    public function destroy(Project $project)
    {
        $project->delete();
        return redirect()->route('projects.index')->with('success', 'Project deleted successfully');
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
