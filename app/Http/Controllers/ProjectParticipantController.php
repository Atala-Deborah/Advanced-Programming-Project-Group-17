<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Participant;
use App\Models\ProjectParticipant;
use Illuminate\Http\Request;

class ProjectParticipantController extends Controller
{
    public function store(Request $request, Project $project)
    {
        $validated = $request->validate([
            'ParticipantId' => 'required|exists:participants,ParticipantId',
            'RoleOnProject' => 'required|in:Student,Lecturer,Contributor',
            'SkillRole' => 'required|in:Developer,Engineer,Designer,Business Lead'
        ]);

        // Check if participant is already assigned to this project
        if ($project->participants()->where('project_participants.ParticipantId', $validated['ParticipantId'])->exists()) {
            return redirect()->back()->with('error', 'Participant is already assigned to this project.');
        }

        $project->participants()->attach($validated['ParticipantId'], [
            'RoleOnProject' => $validated['RoleOnProject'],
            'SkillRole' => $validated['SkillRole']
        ]);

        return redirect()->route('projects.show', $project->ProjectId)
            ->with('success', 'Participant added successfully');
    }

    public function destroy(Project $project, Participant $participant)
    {
        $project->participants()->detach($participant->ParticipantId);

        return redirect()->route('projects.show', $project->ProjectId)
            ->with('success', 'Participant removed successfully');
    }

    public function show(Project $project)
    {
        // Load project with participants
        $project->load('participants');
        
        // Get all participants not already assigned to this project
        $assignedParticipantIds = $project->participants->pluck('ParticipantId')->toArray();
        
        $participants = Participant::whereNotIn('ParticipantId', $assignedParticipantIds)->get();

        return view('project-participants.manage', compact('project', 'participants'));
    }
}
