@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white shadow rounded-lg">
        <div class="px-4 py-5 border-b border-gray-200 sm:px-6">
            <h3 class="text-lg font-medium leading-6 text-gray-900">
                Create New Facility
            </h3>
        </div>
        
        <form action="{{ route('facilities.store') }}" method="POST" class="p-6">
            @csrf
            
            <div class="space-y-6">
                <!-- Name -->
                <div>
                    <label for="Name" class="block text-sm font-medium text-gray-700">Name</label>
                    <input type="text" name="Name" id="Name" required
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                           value="{{ old('Name') }}">
                    @error('Name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label for="Description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="Description" id="Description" rows="3"
                              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">{{ old('Description') }}</textarea>
                    @error('Description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Location -->
                <div>
                    <label for="Location" class="block text-sm font-medium text-gray-700">Location</label>
                    <input type="text" name="Location" id="Location" required
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                           value="{{ old('Location') }}">
                    @error('Location')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Facility Type -->
                <div>
                    <label for="FacilityType" class="block text-sm font-medium text-gray-700">Facility Type</label>
                    <select name="FacilityType" id="FacilityType" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                        <option value="Lab" {{ old('FacilityType') == 'Lab' ? 'selected' : '' }}>Lab</option>
                        <option value="Workshop" {{ old('FacilityType') == 'Workshop' ? 'selected' : '' }}>Workshop</option>
                        <option value="Testing Center" {{ old('FacilityType') == 'Testing Center' ? 'selected' : '' }}>Testing Center</option>
                    </select>
                    @error('FacilityType')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Partner Organization (Optional) -->
                <div>
                    <label for="PartnerOrganization" class="block text-sm font-medium text-gray-700">Partner Organization (Optional)</label>
                    <input type="text" name="PartnerOrganization" id="PartnerOrganization"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                           value="{{ old('PartnerOrganization') }}">
                    @error('PartnerOrganization')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Capabilities (Optional) -->
                <div>
                    <label for="Capabilities" class="block text-sm font-medium text-gray-700">Capabilities (Optional)</label>
                    <textarea name="Capabilities" id="Capabilities" rows="2"
                              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">{{ old('Capabilities') }}</textarea>
                    @error('Capabilities')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Form Actions -->
            <div class="mt-6 flex items-center justify-end space-x-3">
                <a href="{{ route('facilities.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Cancel
                </a>
                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Create Facility
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
