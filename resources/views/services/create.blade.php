@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white shadow rounded-lg">
        <div class="px-4 py-5 border-b border-gray-200 sm:px-6">
            <h3 class="text-lg font-medium leading-6 text-gray-900">
                Create New Service
            </h3>
        </div>
        
        <form action="{{ route('services.store') }}" method="POST" class="p-6">
            @csrf
            
            <div class="space-y-6">
                <!-- Facility -->
                <div>
                    <label for="FacilityId" class="block text-sm font-medium text-gray-700">Facility</label>
                    <select name="FacilityId" id="FacilityId" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                        <option value="">Select Facility</option>
                        @foreach($facilities as $facility)
                            <option value="{{ $facility->FacilityId }}" {{ old('FacilityId') == $facility->FacilityId ? 'selected' : '' }}>
                                {{ $facility->Name }}
                            </option>
                        @endforeach
                    </select>
                    @error('FacilityId')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

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

                <!-- Category -->
                <div>
                    <label for="Category" class="block text-sm font-medium text-gray-700">Category</label>
                    <select name="Category" id="Category" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                        <option value="Machining" {{ old('Category') == 'Machining' ? 'selected' : '' }}>Machining</option>
                        <option value="Testing" {{ old('Category') == 'Testing' ? 'selected' : '' }}>Testing</option>
                        <option value="Training" {{ old('Category') == 'Training' ? 'selected' : '' }}>Training</option>
                    </select>
                    @error('Category')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Skill Type -->
                <div>
                    <label for="SkillType" class="block text-sm font-medium text-gray-700">Skill Type</label>
                    <select name="SkillType" id="SkillType" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                        <option value="Hardware" {{ old('SkillType') == 'Hardware' ? 'selected' : '' }}>Hardware</option>
                        <option value="Software" {{ old('SkillType') == 'Software' ? 'selected' : '' }}>Software</option>
                        <option value="Integration" {{ old('SkillType') == 'Integration' ? 'selected' : '' }}>Integration</option>
                    </select>
                    @error('SkillType')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Form Actions -->
            <div class="mt-6 flex items-center justify-end space-x-3">
                <a href="{{ route('services.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Cancel
                </a>
                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Create Service
                </button>
            </div>
        </form>
    </div>
</div>
@endsection