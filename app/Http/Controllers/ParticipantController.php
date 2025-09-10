<?php

namespace App\Http\Controllers;

use App\Models\Participant;
use Illuminate\Http\Request;

class ParticipantController extends Controller
{
    public function index()
    {
        $participants = Participant::paginate(10);
        return view('participants.index', compact('participants'));
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
            'Affiliation' => 'required|string|max:255',
            'Specialization' => 'required|string|max:255',
            'Institution' => 'required|string|max:255',
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
        $validated = $request->validate([
            'FullName' => 'required|string|max:255',
            'Email' => 'required|email|unique:participants,Email,' . $participant->ParticipantId . ',ParticipantId',
            'Affiliation' => 'required|string|max:255',
            'Specialization' => 'required|string|max:255',
            'Institution' => 'required|string|max:255',
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
