<?php

namespace App\Http\Controllers;

use App\Models\Program;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    public function index()
    {
        $programs = Program::paginate(10);
        return view('programs.index', compact('programs'));
    }

    public function create()
    {
        return view('programs.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'Name' => 'required|string|max:255',
            'Description' => 'nullable|string',
            'NationalAlignment' => 'nullable|in:NDPIII,Roadmap,4IR',
            'FocusAreas' => 'nullable|in:IoT,Automation,Renewable Energy,Biotechnology,AI/ML,Robotics',
            'Phases' => 'nullable|in:Cross-Skilling,Collaboration,Technical Skills,Prototyping,Commercialization',
        ]);

        Program::create($validated);

        return redirect()->route('programs.index')
            ->with('success', 'Program created successfully.');
    }

    public function show(Program $program)
    {
        return view('programs.show', compact('program'));
    }

    public function edit(Program $program)
    {
        return view('programs.edit', compact('program'));
    }

    public function update(Request $request, Program $program)
    {
        $validated = $request->validate([
            'Name' => 'required|string|max:255',
            'Description' => 'nullable|string',
            'NationalAlignment' => 'nullable|in:NDPIII,Roadmap,4IR',
            'FocusAreas' => 'nullable|in:IoT,Automation,Renewable Energy,Biotechnology,AI/ML,Robotics',
            'Phases' => 'nullable|in:Cross-Skilling,Collaboration,Technical Skills,Prototyping,Commercialization',
        ]);

        $program->update($validated);

        return redirect()->route('programs.index')
            ->with('success', 'Program updated successfully');
    }

    public function destroy(Program $program)
    {
        $program->delete();

        return redirect()->route('programs.index')
            ->with('success', 'Program deleted successfully');
    }
}