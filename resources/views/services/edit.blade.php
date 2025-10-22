@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white shadow rounded-lg">
        <div class="px-4 py-5 border-b border-gray-200 sm:px-6">
            <h3 class="text-lg font-medium leading-6 text-gray-900">
                Edit Service
            </h3>
        </div>

        <form action="{{ route('services.update', $service) }}" method="POST" class="p-6">
            @csrf
            @method('PUT')

            <div class="space-y-6">
                <!-- Facility -->
                <div>
                    <label for="FacilityId" class="block text-sm font-medium text-gray-700">
                        Facility <span class="text-red-500">*</span>
                    </label>
                    <select name="FacilityId" id="FacilityId" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm @error('FacilityId') border-red-500 @enderror">
                        <option value="">Select Facility</option>
                        @foreach($facilities as $facility)
                            <option value="{{ $facility->FacilityId }}" {{ old('FacilityId', $service->FacilityId) == $facility->FacilityId ? 'selected' : '' }}>
                                {{ $facility->Name }} - {{ $facility->Location }}
                            </option>
                        @endforeach
                    </select>
                    @error('FacilityId')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Service Name -->
                <div>
                    <label for="Name" class="block text-sm font-medium text-gray-700">
                        Service Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="Name" id="Name" required
                           value="{{ old('Name', $service->Name) }}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm @error('Name') border-red-500 @enderror">
                    @error('Name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Must be unique across all services</p>
                </div>

                <!-- Category -->
                <div>
                    <label for="Category" class="block text-sm font-medium text-gray-700">
                        Category <span class="text-red-500">*</span>
                    </label>
                    <select name="Category" id="Category" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm @error('Category') border-red-500 @enderror">
                        <option value="">Select Category</option>
                        <option value="Machining" {{ old('Category', $service->Category) == 'Machining' ? 'selected' : '' }}>Machining</option>
                        <option value="Testing" {{ old('Category', $service->Category) == 'Testing' ? 'selected' : '' }}>Testing</option>
                        <option value="Training" {{ old('Category', $service->Category) == 'Training' ? 'selected' : '' }}>Training</option>
                    </select>
                    @error('Category')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Skill Type -->
                <div>
                    <label for="SkillType" class="block text-sm font-medium text-gray-700">
                        Skill Type <span class="text-red-500">*</span>
                    </label>
                    <select name="SkillType" id="SkillType" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm @error('SkillType') border-red-500 @enderror">
                        <option value="">Select Skill Type</option>
                        <option value="Hardware" {{ old('SkillType', $service->SkillType) == 'Hardware' ? 'selected' : '' }}>Hardware</option>
                        <option value="Software" {{ old('SkillType', $service->SkillType) == 'Software' ? 'selected' : '' }}>Software</option>
                        <option value="Integration" {{ old('SkillType', $service->SkillType) == 'Integration' ? 'selected' : '' }}>Integration</option>
                    </select>
                    @error('SkillType')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label for="Description" class="block text-sm font-medium text-gray-700">
                        Description
                    </label>
                    <textarea name="Description" id="Description" rows="4"
                              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm @error('Description') border-red-500 @enderror">{{ old('Description', $service->Description) }}</textarea>
                    @error('Description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Detailed description of the service offered</p>
                </div>
            </div>

            <div class="mt-6 flex items-center justify-end gap-x-3">
                <a href="{{ route('services.show', $service) }}" 
                   class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Cancel
                </a>
                <button type="submit" 
                        class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Update Service
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
