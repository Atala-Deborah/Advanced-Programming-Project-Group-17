<?php

namespace App\Http\Controllers;

use App\Models\Facility;
use Illuminate\Http\Request;

class FacilityController extends Controller
{
    public function index(Request $request)
    {
        $query = Facility::query();

        // Search by name or description
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('Name', 'like', "%{$search}%")
                  ->orWhere('Description', 'like', "%{$search}%")
                  ->orWhere('Location', 'like', "%{$search}%")
                  ->orWhere('PartnerOrganization', 'like', "%{$search}%")
                  ->orWhere('Capabilities', 'like', "%{$search}%");
            });
        }

        // Filter by facility type
        if ($request->has('type') && $request->type !== 'all') {
            $query->where('FacilityType', $request->type);
        }

        // Filter by partner organization
        if ($request->has('partner') && $request->partner !== 'all') {
            $query->where('PartnerOrganization', $request->partner);
        }

        // Get unique partner organizations for filter dropdown
        $partners = Facility::select('PartnerOrganization')
            ->distinct()
            ->whereNotNull('PartnerOrganization')
            ->orderBy('PartnerOrganization')
            ->pluck('PartnerOrganization');

        // Get all facility types for filter dropdown
        $facilityTypes = ['Lab', 'Workshop', 'Testing Center'];

        // Get filtered and paginated results
        $facilities = $query->orderBy('Name')->paginate(10)->withQueryString();

        return view('facilities.index', compact('facilities', 'partners', 'facilityTypes'));
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
