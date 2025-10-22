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
            'Name' => 'required|string|max:255|unique:programs,Name',
            'Description' => 'required|string',
            'NationalAlignment' => [
                'nullable',
                'string',
                function ($attribute, $value, $fail) use ($request) {
                    // Rule: When FocusAreas is non-empty, NationalAlignment must reference at least one valid token
                    if (!empty($request->FocusAreas) && empty($value)) {
                        $fail('Program.NationalAlignment must include at least one recognized alignment when FocusAreas are specified.');
                    }
                    
                    // Validate that at least one recognized token is present
                    if (!empty($value)) {
                        $validTokens = ['NDPIII', 'DigitalRoadmap2023_2028', '4IR', 'Roadmap'];
                        $hasValidToken = false;
                        
                        foreach ($validTokens as $token) {
                            if (stripos($value, $token) !== false) {
                                $hasValidToken = true;
                                break;
                            }
                        }
                        
                        if (!$hasValidToken) {
                            $fail('Program.NationalAlignment must include at least one recognized alignment (NDPIII, DigitalRoadmap2023_2028, 4IR).');
                        }
                    }
                },
            ],
            'FocusAreas' => 'nullable|string',
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
            'Name' => 'required|string|max:255|unique:programs,Name,' . $program->ProgramId . ',ProgramId',
            'Description' => 'required|string',
            'NationalAlignment' => [
                'nullable',
                'string',
                function ($attribute, $value, $fail) use ($request) {
                    // Rule: When FocusAreas is non-empty, NationalAlignment must reference at least one valid token
                    if (!empty($request->FocusAreas) && empty($value)) {
                        $fail('Program.NationalAlignment must include at least one recognized alignment when FocusAreas are specified.');
                    }
                    
                    // Validate that at least one recognized token is present
                    if (!empty($value)) {
                        $validTokens = ['NDPIII', 'DigitalRoadmap2023_2028', '4IR', 'Roadmap'];
                        $hasValidToken = false;
                        
                        foreach ($validTokens as $token) {
                            if (stripos($value, $token) !== false) {
                                $hasValidToken = true;
                                break;
                            }
                        }
                        
                        if (!$hasValidToken) {
                            $fail('Program.NationalAlignment must include at least one recognized alignment (NDPIII, DigitalRoadmap2023_2028, 4IR).');
                        }
                    }
                },
            ],
            'FocusAreas' => 'nullable|string',
            'Phases' => 'nullable|in:Cross-Skilling,Collaboration,Technical Skills,Prototyping,Commercialization',
        ]);

        $program->update($validated);

        return redirect()->route('programs.index')
            ->with('success', 'Program updated successfully');
    }

    public function destroy(Program $program)
    {
        // Business Rule: Lifecycle Protection - Programs cannot be deleted if they have associated Projects
        if ($program->projects()->exists()) {
            return redirect()->route('programs.index')
                ->with('error', 'Program has Projects; Please reassign before delete.');
        }

        $program->delete();

        return redirect()->route('programs.index')
            ->with('success', 'Program deleted successfully');
    }
}