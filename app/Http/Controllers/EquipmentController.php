<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Models\Facility;
use Illuminate\Http\Request;

class EquipmentController extends Controller
{
    //  List all equipment
    public function index(Request $request)
    {
        $query = Equipment::with('facility');

        //  Search by capability or usage domain
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('Capabilities', 'LIKE', "%$search%")
                  ->orWhere('UsageDomain', 'LIKE', "%$search%");
        }

        $equipment = $query->paginate(10);
        return view('equipment.index', compact('equipment'));
    }

    //  Show equipment at a specific facility
    public function facilityEquipment($facilityId)
    {
        $equipment = Equipment::where('FacilityId', $facilityId)->get();
        return view('equipment.facility', compact('equipment'));
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
            'FacilityId' => 'required|exists:facilities,id',
            'Name' => 'required|string|max:255',
            'Capabilities' => 'required|string',
            'Description' => 'nullable|string',
            'InventoryCode' => 'required|unique:equipment,InventoryCode,' . $equipment->EquipmentId . ',EquipmentId',
            'UsageDomain' => 'required|string',
            'SupportPhase' => 'required|string'
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
