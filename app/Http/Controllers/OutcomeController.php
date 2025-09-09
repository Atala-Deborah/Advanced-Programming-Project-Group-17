<?php

namespace App\Http\Controllers;

use App\Models\Outcome;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OutcomeController extends Controller
{
    public function index()
    {
        $outcomes = Outcome::with('project')->paginate(10);
        return view('outcomes.index', compact('outcomes'));
    }

    public function create()
    {
        $projects = Project::all();
        return view('outcomes.create', compact('projects'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'ProjectId' => 'required|exists:projects,ProjectId',
            'Title' => 'required|string|max:255',
            'Description' => 'required|string',
            'ArtifactLink' => 'nullable|url',
            'OutcomeType' => 'required|in:CAD,PCB,Prototype,Report,Business Plan',
            'QualityCertification' => 'nullable|string|max:255',
            'CommercializationStatus' => 'required|in:Demoed,Market Linked,Launched',
            'artifact' => 'nullable|file|max:10240' // 10MB max
        ]);

        if ($request->hasFile('artifact')) {
            // Store the file in the public disk under the artifacts directory
            $file = $request->file('artifact');
            $filename = $file->hashName(); // Generate a unique filename
            $path = $file->storeAs('artifacts', $filename, 'public');
            $validated['ArtifactLink'] = $path; // Store the relative path
        }

        Outcome::create($validated);

        return redirect()->route('outcomes.index')
            ->with('success', 'Outcome created successfully.');
    }

    public function show(Outcome $outcome)
    {
        return view('outcomes.show', compact('outcome'));
    }

    public function edit(Outcome $outcome)
    {
        $projects = Project::all();
        return view('outcomes.edit', compact('outcome', 'projects'));
    }

    public function update(Request $request, Outcome $outcome)
    {
        $validated = $request->validate([
            'ProjectId' => 'required|exists:projects,ProjectId',
            'Title' => 'required|string|max:255',
            'Description' => 'required|string',
            'OutcomeType' => 'required|in:CAD,PCB,Prototype,Report,Business Plan',
            'QualityCertification' => 'nullable|string|max:255',
            'CommercializationStatus' => 'required|in:Demoed,Market Linked,Launched',
            'artifact' => 'nullable|file|max:10240' // 10MB max
        ]);

        if ($request->hasFile('artifact')) {
            // Delete old file if exists
            if ($outcome->ArtifactLink && Storage::disk('public')->exists($outcome->ArtifactLink)) {
                Storage::disk('public')->delete($outcome->ArtifactLink);
            }
            // Store the new file
            $file = $request->file('artifact');
            $filename = $file->hashName(); // Generate a unique filename
            $path = $file->storeAs('artifacts', $filename, 'public');
            $validated['ArtifactLink'] = $path; // Store the relative path
        }

        $outcome->update($validated);

        return redirect()->route('outcomes.index')
            ->with('success', 'Outcome updated successfully');
    }

    public function destroy(Outcome $outcome)
    {
        if ($outcome->ArtifactLink && Storage::disk('public')->exists($outcome->ArtifactLink)) {
            Storage::disk('public')->delete($outcome->ArtifactLink);
        }
        
        $outcome->delete();

        return redirect()->route('outcomes.index')
            ->with('success', 'Outcome deleted successfully');
    }

    /**
     * Display a listing of outcomes for a specific project.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\View\View
     */
    public function projectOutcomes(Project $project)
    {
        $outcomes = $project->outcomes()->paginate(10);
        return view('outcomes.index', [
            'outcomes' => $outcomes,
            'project' => $project
        ]);
    }
}