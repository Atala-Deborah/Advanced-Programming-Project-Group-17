<?php

namespace App\Http\Controllers;

use App\Models\Participant;
use Illuminate\Http\Request;

class ParticipantController extends Controller
{
    public function index(Request $request)
    {
        $query = Participant::query();

        // Search functionality
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('FullName', 'like', '%' . $searchTerm . '%')
                  ->orWhere('Email', 'like', '%' . $searchTerm . '%');
            });
        }

        // Filter by Institution
        if ($request->filled('institution')) {
            $query->where('Institution', $request->institution);
        }

        // Filter by Specialization
        if ($request->filled('specialization')) {
            $query->where('Specialization', $request->specialization);
        }

        // Filter by Affiliation
        if ($request->filled('affiliation')) {
            $query->where('Affiliation', $request->affiliation);
        }

        // Filter by Cross-Skill Trained status
        if ($request->filled('cross_skill')) {
            $query->where('CrossSkillTrained', $request->cross_skill === '1');
        }

        $participants = $query->with('projects')->paginate(10)->appends($request->query());

        // Get filter options for dropdowns
        $institutions = ['SCIT', 'CEDAT', 'UniPod', 'UIRI', 'Lwera', 'Other'];
        $specializations = ['Software', 'Hardware', 'Business'];
        $affiliations = ['CS', 'SE', 'Engineering', 'Other'];

        return view('participants.index', compact('participants', 'institutions', 'specializations', 'affiliations'));
    }

    public function create()
    {
        return view('participants.create');
    }

    public function store(Request $request)
    {
        // Convert checkbox value to boolean
        $request->merge([
            'CrossSkillTrained' => $request->has('CrossSkillTrained')
        ]);

        $validated = $request->validate([
            'FullName' => 'required|string|max:255',
            'Email' => 'required|email|unique:participants,Email',
            'Affiliation' => 'required|in:CS,SE,Engineering,Other',
            'Specialization' => 'required|in:Software,Hardware,Business',
            'Institution' => 'required|in:SCIT,CEDAT,UniPod,UIRI,Lwera,Other',
            'CrossSkillTrained' => 'boolean'
        ]);

        try {
            $participant = Participant::create($validated);
            return redirect()->route('participants.index')
                ->with('success', 'Participant created successfully.');
        } catch (\Exception $e) {
            \Log::error('Error creating participant: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Failed to create participant. Please try again.');
        }
    }

    public function show(Participant $participant)
    {
        return view('participants.show', compact('participant'));
    }

    public function edit(Participant $participant)
    {
        return view('participants.edit', compact('participant'));
    }

    public function update(Request $request, Participant $participant)
    {
        // Convert checkbox value to boolean
        $request->merge([
            'CrossSkillTrained' => $request->has('CrossSkillTrained')
        ]);

        $validated = $request->validate([
            'FullName' => 'required|string|max:255',
            'Email' => 'required|email|unique:participants,Email,' . $participant->ParticipantId . ',ParticipantId',
            'Affiliation' => 'required|in:CS,SE,Engineering,Other',
            'Specialization' => 'required|in:Software,Hardware,Business',
            'Institution' => 'required|in:SCIT,CEDAT,UniPod,UIRI,Lwera,Other',
            'CrossSkillTrained' => 'boolean'
        ]);

        $participant->update($validated);

        return redirect()->route('participants.index')
            ->with('success', 'Participant updated successfully');
    }

    public function destroy(Participant $participant)
    {
        $participant->delete();

        return redirect()->route('participants.index')
            ->with('success', 'Participant deleted successfully');
    }
}
