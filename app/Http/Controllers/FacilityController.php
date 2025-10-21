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
            'Name' => [
                'required',
                'string',
                'max:255',
                function ($attribute, $value, $fail) use ($request) {
                    // BR: Facility.Name + Location must be unique composite
                    $exists = Facility::where('Name', $value)
                        ->where('Location', $request->Location)
                        ->exists();
                    if ($exists) {
                        $fail('The combination of Name and Location must be unique.');
                    }
                },
            ],
            'Description' => 'nullable|string',
            'Location' => 'required|string|max:255',
            'PartnerOrganization' => 'nullable|string|max:255',
            'FacilityType' => 'required|string|in:Lab,Workshop,Testing Center',
            'Capabilities' => [
                'nullable',
                'string',
                function ($attribute, $value, $fail) use ($request) {
                    // BR: Capabilities required if Services or Equipment exist
                    // Note: For new facility, this will be checked on subsequent updates
                },
            ],
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
            'Name' => [
                'required',
                'string',
                'max:255',
                function ($attribute, $value, $fail) use ($request, $facility) {
                    // BR: Facility.Name + Location must be unique composite
                    $exists = Facility::where('Name', $value)
                        ->where('Location', $request->Location)
                        ->where('FacilityId', '!=', $facility->FacilityId)
                        ->exists();
                    if ($exists) {
                        $fail('The combination of Name and Location must be unique.');
                    }
                },
            ],
            'Description' => 'nullable|string',
            'Location' => 'required|string|max:255',
            'PartnerOrganization' => 'nullable|string|max:255',
            'FacilityType' => 'required|string|in:Lab,Workshop,Testing Center',
            'Capabilities' => [
                'nullable',
                'string',
                function ($attribute, $value, $fail) use ($facility) {
                    // BR: Capabilities required if Services or Equipment exist
                    if (empty($value)) {
                        if ($facility->services()->exists() || $facility->equipment()->exists()) {
                            $fail('Capabilities are required when Services or Equipment are associated with this Facility.');
                        }
                    }
                },
            ],
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
            $projectNames = $facility->projects()->take(3)->pluck('Title')->toArray();
            if ($projectCount <= 3) {
                $dependencies[] = "{$projectCount} project(s) (" . implode(', ', $projectNames) . ") will be reassigned or deleted";
            } else {
                $dependencies[] = "{$projectCount} project(s) (" . implode(', ', $projectNames) . " and " . ($projectCount - 3) . " more) will be reassigned or deleted";
            }
        }
        
        // Check for equipment  
        $equipmentCount = $facility->equipment()->count();
        if ($equipmentCount > 0) {
            $equipmentNames = $facility->equipment()->take(3)->pluck('Name')->toArray();
            if ($equipmentCount <= 3) {
                $dependencies[] = "{$equipmentCount} equipment item(s) (" . implode(', ', $equipmentNames) . ") will be reassigned or deleted";
            } else {
                $dependencies[] = "{$equipmentCount} equipment item(s) (" . implode(', ', $equipmentNames) . " and " . ($equipmentCount - 3) . " more) will be reassigned or deleted";
            }
        }
        
        // Check for services
        $serviceCount = $facility->services()->count();
        if ($serviceCount > 0) {
            $serviceNames = $facility->services()->take(3)->pluck('Name')->toArray();
            if ($serviceCount <= 3) {
                $dependencies[] = "{$serviceCount} service(s) (" . implode(', ', $serviceNames) . ") will be reassigned or deleted";
            } else {
                $dependencies[] = "{$serviceCount} service(s) (" . implode(', ', $serviceNames) . " and " . ($serviceCount - 3) . " more) will be reassigned or deleted";
            }
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
            'reassignOptions' => $alternatives->toArray()
        ]);
    }

    public function destroy(Request $request, Facility $facility)
    {
        // BR: Cannot delete Facility if Projects, Equipment, or Services exist
        // Must prevent deletion instead of cascade/reassign
        if ($facility->projects()->exists()) {
            return redirect()->route('facilities.index')
                ->with('error', 'Cannot delete Facility with associated Projects. Reassign or archive Projects first.');
        }

        if ($facility->equipment()->exists()) {
            return redirect()->route('facilities.index')
                ->with('error', 'Cannot delete Facility with associated Equipment. Reassign Equipment first.');
        }

        if ($facility->services()->exists()) {
            return redirect()->route('facilities.index')
                ->with('error', 'Cannot delete Facility with associated Services. Reassign Services first.');
        }

        $facility->delete();

        return redirect()->route('facilities.index')
            ->with('success', 'Facility deleted successfully.');
    }
}
