<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use App\Models\ProjectParticipant;
use Illuminate\Http\Request;

class ProjectParticipantController extends Controller
{
    public function store(Request $request, Project $project)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'role' => 'required|string|max:255'
        ]);

        $project->participants()->attach($validated['user_id'], ['role' => $validated['role']]);

        return redirect()->route('projects.show', $project)
            ->with('success', 'Participant added successfully');
    }

    public function destroy(Project $project, User $participant)
    {
        $project->participants()->detach($participant->id);

        return redirect()->route('projects.show', $project)
            ->with('success', 'Participant removed successfully');
    }
}
