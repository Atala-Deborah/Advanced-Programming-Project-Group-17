<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Facility;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    // List all services
    public function index()
    {
        $services = Service::with('facility')->get(); // eager load facility
        return view('services.index', compact('services'));
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
            'Name' => 'required|string|max:255',
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
            'Name' => 'sometimes|string|max:255',
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