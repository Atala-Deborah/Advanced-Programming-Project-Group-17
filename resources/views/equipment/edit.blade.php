@extends('layouts.app')

@section('content')
<div class="bg-white shadow rounded-lg overflow-hidden">
    <!-- Header Section -->
    <div class="bg-gradient-to-r from-[#070600] to-blue-800 text-white px-4 py-8 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="flex items-center">
                <a href="{{ route('equipment.show', $equipment) }}" 
                   class="text-green-100 hover:text-white mr-4">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
                <div>
                    <h1 class="text-2xl font-bold">Edit Equipment</h1>
                    <p class="mt-1 text-green-100">{{ $equipment->Name }}</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Form Section -->
    <div class="px-4 py-5 sm:p-6">
        <div class="max-w-3xl mx-auto">
            <form method="POST" action="{{ route('equipment.update', $equipment) }}">
                @csrf
                @method('PUT')
                
                <div class="space-y-6">
                    <!-- Equipment Name -->
                    <div>
                        <label for="Name" class="block text-sm font-medium text-gray-700">Equipment Name <span class="text-red-500">*</span></label>
                        <input type="text" 
                               name="Name" 
                               id="Name" 
                               value="{{ old('Name', $equipment->Name) }}" 
                               required
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm @error('Name') border-red-300 @enderror">
                        @error('Name')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Inventory Code -->
                    <div>
                        <label for="InventoryCode" class="block text-sm font-medium text-gray-700">Inventory Code <span class="text-red-500">*</span></label>
                        <input type="text" 
                               name="InventoryCode" 
                               id="InventoryCode" 
                               value="{{ old('InventoryCode', $equipment->InventoryCode) }}" 
                               required
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm @error('InventoryCode') border-red-300 @enderror">
                        @error('InventoryCode')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-2 text-sm text-gray-500">Unique identifier for this equipment item</p>
                    </div>
                    
                    <!-- Facility -->
                    <div>
                        <label for="FacilityId" class="block text-sm font-medium text-gray-700">Facility <span class="text-red-500">*</span></label>
                        <select name="FacilityId" 
                                id="FacilityId" 
                                required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm @error('FacilityId') border-red-300 @enderror">
                            <option value="">Select a facility</option>
                            @foreach($facilities as $facility)
                                <option value="{{ $facility->FacilityId }}" 
                                        {{ old('FacilityId', $equipment->FacilityId) == $facility->FacilityId ? 'selected' : '' }}>
                                    {{ $facility->Name }} ({{ $facility->Location }})
                                </option>
                            @endforeach
                        </select>
                        @error('FacilityId')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Usage Domain -->
                    <div>
                        <label for="UsageDomain" class="block text-sm font-medium text-gray-700">Usage Domain <span class="text-red-500">*</span></label>
                        <select name="UsageDomain" 
                                id="UsageDomain" 
                                required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm @error('UsageDomain') border-red-300 @enderror">
                            <option value="">Select usage domain</option>
                            <option value="Electronics" {{ old('UsageDomain', $equipment->UsageDomain) === 'Electronics' ? 'selected' : '' }}>Electronics</option>
                            <option value="Mechanical" {{ old('UsageDomain', $equipment->UsageDomain) === 'Mechanical' ? 'selected' : '' }}>Mechanical</option>
                            <option value="IoT" {{ old('UsageDomain', $equipment->UsageDomain) === 'IoT' ? 'selected' : '' }}>Internet of Things (IoT)</option>
                        </select>
                        @error('UsageDomain')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Support Phase -->
                    <div>
                        <label for="SupportPhase" class="block text-sm font-medium text-gray-700">Support Phase <span class="text-red-500">*</span></label>
                        <select name="SupportPhase" 
                                id="SupportPhase" 
                                required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm @error('SupportPhase') border-red-300 @enderror">
                            <option value="">Select support phase</option>
                            <option value="Training" {{ old('SupportPhase', $equipment->SupportPhase) === 'Training' ? 'selected' : '' }}>Training</option>
                            <option value="Prototyping" {{ old('SupportPhase', $equipment->SupportPhase) === 'Prototyping' ? 'selected' : '' }}>Prototyping</option>
                            <option value="Testing" {{ old('SupportPhase', $equipment->SupportPhase) === 'Testing' ? 'selected' : '' }}>Testing</option>
                        </select>
                        <p class="mt-2 text-sm text-gray-500">Electronics equipment must support Prototyping or Testing (not Training only)</p>
                        @error('SupportPhase')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Capabilities -->
                    <div>
                        <label for="Capabilities" class="block text-sm font-medium text-gray-700">Capabilities</label>
                        <textarea name="Capabilities" 
                                  id="Capabilities" 
                                  rows="4"
                                  class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm @error('Capabilities') border-red-300 @enderror"
                                  placeholder="Describe what this equipment can do, its specifications, and key features">{{ old('Capabilities', $equipment->Capabilities) }}</textarea>
                        <p class="mt-2 text-sm text-gray-500">Optional: Describe equipment capabilities and specifications</p>
                        @error('Capabilities')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Description -->
                    <div>
                        <label for="Description" class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea name="Description" 
                                  id="Description" 
                                  rows="3" 
                                  class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm @error('Description') border-red-300 @enderror"
                                  placeholder="Additional details about the equipment">{{ old('Description', $equipment->Description) }}</textarea>
                        @error('Description')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-2 text-sm text-gray-500">Optional: Additional information about the equipment</p>
                    </div>
                </div>
                
                <!-- Form Actions -->
                <div class="mt-8 flex justify-end space-x-3">
                    <a href="{{ route('equipment.show', $equipment) }}" 
                       class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        Update Equipment
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Auto-generate inventory code suggestion based on facility and name
document.addEventListener('DOMContentLoaded', function() {
    const facilitySelect = document.getElementById('FacilityId');
    const nameInput = document.getElementById('Name');
    const inventoryCodeInput = document.getElementById('InventoryCode');
    
    function generateInventoryCode() {
        const facilityOption = facilitySelect.options[facilitySelect.selectedIndex];
        const facilityText = facilityOption.text;
        const equipmentName = nameInput.value;
        
        if (facilityText && equipmentName && !inventoryCodeInput.value) {
            // Extract facility abbreviation (first 3 letters) and equipment abbreviation
            const facilityAbbr = facilityText.split(' ')[0].substring(0, 3).toUpperCase();
            const equipmentAbbr = equipmentName.replace(/[^a-zA-Z]/g, '').substring(0, 3).toUpperCase();
            const randomNum = Math.floor(Math.random() * 1000).toString().padStart(3, '0');
            
            const suggestion = `${facilityAbbr}-${equipmentAbbr}-${randomNum}`;
            inventoryCodeInput.placeholder = `Suggested: ${suggestion}`;
        }
    }
    
    // Only generate for new entries (when current inventory code is empty after initial load)
    if (!inventoryCodeInput.value.trim()) {
        facilitySelect.addEventListener('change', generateInventoryCode);
        nameInput.addEventListener('input', generateInventoryCode);
    }
});
</script>
@endsection
