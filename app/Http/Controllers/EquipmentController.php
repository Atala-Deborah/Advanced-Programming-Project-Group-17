<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Models\Facility;
use Illuminate\Http\Request;

class EquipmentController extends Controller
{
    // List all equipment with search and filters
    public function index(Request $request)
    {
        $query = Equipment::with('facility');

        // Search functionality
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('Name', 'like', "%{$search}%")
                  ->orWhere('Capabilities', 'like', "%{$search}%")
                  ->orWhere('Description', 'like', "%{$search}%")
                  ->orWhere('InventoryCode', 'like', "%{$search}%");
            });
        }

        // Filter by facility
        if ($request->has('facility') && $request->facility !== 'all') {
            $query->where('FacilityId', $request->facility);
        }

        // Filter by usage domain
        if ($request->has('usage_domain') && $request->usage_domain !== 'all') {
            $query->where('UsageDomain', $request->usage_domain);
        }

        // Filter by support phase
        if ($request->has('support_phase') && $request->support_phase !== 'all') {
            $query->where('SupportPhase', $request->support_phase);
        }

        // Get all facilities for filter dropdown
        $facilities = Facility::orderBy('Name')->pluck('Name', 'FacilityId');
        
        // Define available usage domains for filter dropdown
        $usageDomains = [
            'Electronics' => 'Electronics',
            'Mechanical' => 'Mechanical',
            'IoT' => 'Internet of Things (IoT)'
        ];

        // Define support phases for filter dropdown
        $supportPhases = [
            'Planning' => 'Planning',
            'Development' => 'Development',
            'Testing' => 'Testing',
            'Production' => 'Production',
            'Maintenance' => 'Maintenance',
            'Retired' => 'Retired'
        ];

        // Get filtered and paginated results
        $equipment = $query->orderBy('Name')->paginate(10)->withQueryString();

        return view('equipment.index', compact(
            'equipment', 
            'facilities', 
            'usageDomains',
            'supportPhases'
        ));
    }

    //  Show equipment at a specific facility
    public function facilityEquipment($facilityId)
    {
        $equipment = Equipment::where('FacilityId', $facilityId)->get();
        return view('equipment.facility', compact('equipment'));
    }

    // Show individual equipment
    public function show(Equipment $equipment)
    {
        $equipment->load('facility');
        return view('equipment.show', compact('equipment'));
    }

    // Show create form
    public function create()
    {
        $facilities = Facility::all();
        return view('equipment.create', compact('facilities'));
    }

    // Store new equipment
    public function store(Request $request)
    {
        $validated = $request->validate([
            'FacilityId' => 'required|exists:facilities,FacilityId',
            'Name' => 'required|string|max:255',
            'Capabilities' => 'required|string',
            'Description' => 'nullable|string',
            'InventoryCode' => 'required|string|unique:equipment,InventoryCode',
            'UsageDomain' => 'required|string|in:Electronics,Mechanical,IoT',
            'SupportPhase' => 'required|string|in:Training,Prototyping'
        ]);

        Equipment::create($validated);
        return redirect()->route('equipment.index')->with('success', 'Equipment created successfully');
    }

    // Show edit form
    public function edit(Equipment $equipment)
    {
        $facilities = Facility::all();
        return view('equipment.edit', compact('equipment', 'facilities'));
    }

    // Update equipment
    public function update(Request $request, Equipment $equipment)
    {
        $validated = $request->validate([
            'FacilityId' => 'required|exists:facilities,FacilityId',
            'Name' => 'required|string|max:255',
            'Capabilities' => 'required|string',
            'Description' => 'nullable|string',
            'InventoryCode' => 'required|unique:equipment,InventoryCode,' . $equipment->EquipmentId . ',EquipmentId',
            'UsageDomain' => 'required|string|in:Electronics,Mechanical,IoT',
            'SupportPhase' => 'required|string|in:Training,Prototyping'
        ]);

        $equipment->update($validated);
        return redirect()->route('equipment.index')->with('success', 'Equipment updated successfully');
    }

    // Delete equipment
    public function destroy(Equipment $equipment)
    {
        // Optional: Check if tied to active projects before deleting
        $equipment->delete();
        return redirect()->route('equipment.index')->with('success', 'Equipment deleted successfully');
    }
}
