<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Facility;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    // List all services with search and filters
    public function index(Request $request)
    {
        $query = Service::with('facility');

        // Search by name or description
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('Name', 'like', "%{$search}%")
                  ->orWhere('Description', 'like', "%{$search}%");
            });
        }

        // Filter by facility
        if ($request->has('facility') && $request->facility !== 'all') {
            $query->where('FacilityId', $request->facility);
        }

        // Filter by category
        if ($request->has('category') && $request->category !== 'all') {
            $query->where('Category', $request->category);
        }

        // Filter by skill type
        if ($request->has('skill_type') && $request->skill_type !== 'all') {
            $query->where('SkillType', $request->skill_type);
        }

        // Get all facilities for filter dropdown
        $facilities = Facility::orderBy('Name')->pluck('Name', 'FacilityId');
        
        // Define available categories and skill types for dropdowns
        $categories = [
            'Machining' => 'Machining',
            'Testing' => 'Testing',
            'Training' => 'Training'
        ];
        
        $skillTypes = [
            'Hardware' => 'Hardware',
            'Software' => 'Software',
            'Integration' => 'Integration'
        ];

        // Get filtered and paginated results
        $services = $query->orderBy('Name')->paginate(10)->withQueryString();

        return view('services.index', compact(
            'services', 
            'facilities', 
            'categories', 
            'skillTypes'
        ));
    }

    // Show the form to create a new service
    public function create()
    {
        $facilities = Facility::all(); // select facility
        return view('services.create', compact('facilities'));
    }

    // Store a newly created service
    public function store(Request $request)
    {
        $request->validate([
            'FacilityId' => 'required|exists:facilities,FacilityId',
            'Name' => [
                'required',
                'string',
                'max:255',
                'unique:services,Name', // BR: Service.Name must be unique
            ],
            'Description' => 'nullable|string',
            'Category' => 'required|in:Machining,Testing,Training',
            'SkillType' => 'required|in:Hardware,Software,Integration',
        ]);

        Service::create($request->all());

        return redirect()->route('services.index')->with('success', 'Service created successfully!');
    }

    // Show details of a service
    public function show(Service $service)
    {
        return view('services.show', compact('service'));
    }

    // Show the form to edit a service
    public function edit(Service $service)
    {
        $facilities = Facility::all();
        return view('services.edit', compact('service', 'facilities'));
    }

    // Update an existing service
    public function update(Request $request, Service $service)
    {
        $request->validate([
            'FacilityId' => 'sometimes|exists:facilities,FacilityId',
            'Name' => [
                'sometimes',
                'string',
                'max:255',
                'unique:services,Name,' . $service->ServiceId . ',ServiceId', // BR: Service.Name must be unique
            ],
            'Description' => 'nullable|string',
            'Category' => 'sometimes|in:Machining,Testing,Training',
            'SkillType' => 'sometimes|in:Hardware,Software,Integration',
        ]);

        $service->update($request->all());

        return redirect()->route('services.index')->with('success', 'Service updated successfully!');
    }

    // Delete a service
    public function destroy(Service $service)
    {
        // BR: Cannot delete Service if Programs reference it
        if ($service->programs()->exists()) {
            return redirect()->route('services.index')
                ->with('error', 'Cannot delete Service with associated Programs. Reassign or archive Programs first.');
        }

        $service->delete();
        return redirect()->route('services.index')->with('success', 'Service deleted successfully!');
    }

    // Search services by category
    public function searchByCategory($category)
    {
        $services = Service::where('Category', $category)->get();
        return view('services.index', compact('services'));
    }
}