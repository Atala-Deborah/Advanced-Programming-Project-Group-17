<?php

namespace App\Http\Controllers;

use App\Models\Facility;
use Illuminate\Http\Request;

class FacilityController extends Controller
{
    public function index()
    {
        $facilities = Facility::all();
        return view('facilities.index', compact('facilities'));
    }

    public function create()
    {
        return view('facilities.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'Name' => 'required|string|max:255',
            'Description' => 'nullable|string',
            'Location' => 'required|string|max:255',
            'PartnerOrganization' => 'nullable|string|max:255',
            'FacilityType' => 'required|string|in:Lab,Workshop,Testing Center',
            'Capabilities' => 'nullable|string',
        ]);

        Facility::create($validated);

        return redirect()->route('facilities.index')
            ->with('success', 'Facility created successfully.');
    }

    public function show(Facility $facility)
    {
        return view('facilities.show', compact('facility'));
    }

    public function edit(Facility $facility)
    {
        return view('facilities.edit', compact('facility'));
    }

    public function update(Request $request, Facility $facility)
    {
        $validated = $request->validate([
            'Name' => 'required|string|max:255',
            'Description' => 'nullable|string',
            'Location' => 'required|string|max:255',
            'PartnerOrganization' => 'nullable|string|max:255',
            'FacilityType' => 'required|string|in:Lab,Workshop,Testing Center',
            'Capabilities' => 'nullable|string',
        ]);

        $facility->update($validated);

        return redirect()->route('facilities.index')
            ->with('success', 'Facility updated successfully.');
    }

    public function confirmDelete(Facility $facility)
    {
        $otherFacilities = Facility::where('FacilityId', '!=', $facility->FacilityId)->get();
        return view('facilities.delete-confirm', compact('facility', 'otherFacilities'));
    }

    public function destroy(Request $request, Facility $facility)
    {
        if ($facility->projects()->exists()) {
            $deletionType = $request->input('deletion_type');

            if ($deletionType === 'reassign') {
                $newFacilityId = $request->input('new_facility_id');
                $newFacility = Facility::find($newFacilityId);

                if (!$newFacility) {
                    return redirect()->route('facilities.index')
                        ->with('error', 'Selected facility for reassignment not found.');
                }

                // Reassign all projects to the new facility
                $facility->projects()->update(['FacilityId' => $newFacilityId]);
            }
            elseif ($deletionType === 'delete_all') {
                // Delete all associated projects first
                $facility->projects()->delete();
            }
            else {
                return redirect()->route('facilities.index')
                    ->with('error', 'Invalid deletion type specified.');
            }
        }

        // Now safe to delete the facility (services and equipment will cascade)
        $facility->delete();

        return redirect()->route('facilities.index')
            ->with('success', 'Facility and associated items deleted successfully.');
    }
}
