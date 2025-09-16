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

    /**
     * Get dependency information for a facility
     */
    public function getDependencies(Facility $facility)
    {
        $dependencies = [];
        
        // Check for projects
        $projectCount = $facility->projects()->count();
        if ($projectCount > 0) {
            $dependencies[] = "{$projectCount} project(s)";
        }
        
        // Check for equipment
        $equipmentCount = $facility->equipment()->count();
        if ($equipmentCount > 0) {
            $dependencies[] = "{$equipmentCount} equipment item(s)";
        }
        
        // Check for services
        $serviceCount = $facility->services()->count();
        if ($serviceCount > 0) {
            $dependencies[] = "{$serviceCount} service(s)";
        }
        
        // Get alternative facilities for reassignment
        $alternatives = Facility::where('FacilityId', '!=', $facility->FacilityId)
            ->select('FacilityId', 'Name', 'Location')
            ->get()
            ->map(function($f) {
                return [
                    'id' => $f->FacilityId,
                    'name' => $f->Name . ' (' . $f->Location . ')'
                ];
            });
        
        return response()->json([
            'dependencies' => $dependencies,
            'alternatives' => $alternatives
        ]);
    }

    public function destroy(Request $request, Facility $facility)
    {
        $deleteAction = $request->input('delete_action', 'cascade');
        
        // Handle dependencies
        if ($facility->projects()->exists() || $facility->equipment()->exists() || $facility->services()->exists()) {
            if ($deleteAction === 'reassign') {
                $reassignTo = $request->input('reassign_to');
                $newFacility = Facility::find($reassignTo);

                if (!$newFacility) {
                    return redirect()->route('facilities.index')
                        ->with('error', 'Selected facility for reassignment not found.');
                }

                // Reassign all dependencies to the new facility
                $facility->projects()->update(['FacilityId' => $reassignTo]);
                $facility->equipment()->update(['FacilityId' => $reassignTo]);
                $facility->services()->update(['FacilityId' => $reassignTo]);
                
                $message = "Facility deleted successfully. Dependencies reassigned to {$newFacility->Name}.";
            } else {
                // Cascade delete - delete all dependencies
                $facility->projects()->delete();
                $facility->equipment()->delete();
                $facility->services()->delete();
                
                $message = "Facility and all associated items deleted successfully.";
            }
        } else {
            $message = "Facility deleted successfully.";
        }

        $facility->delete();

        return redirect()->route('facilities.index')
            ->with('success', $message);
    }
}
