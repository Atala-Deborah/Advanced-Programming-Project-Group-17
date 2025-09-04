<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Facility;
use App\Models\Equipment;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::with('facility')->paginate(10);
        return view('projects.index', compact('projects'));
    }

    public function create()
    {
        $facilities = Facility::all();
        return view('projects.create', compact('facilities'));
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
