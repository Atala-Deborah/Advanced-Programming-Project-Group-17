@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white shadow rounded-lg">
        <div class="px-4 py-5 border-b border-gray-200 sm:px-6">
            <h3 class="text-lg font-medium leading-6 text-gray-900">
                Add New Equipment
            </h3>
        </div>
        
        <form action="{{ route('equipment.store') }}" method="POST" class="p-6">
            @csrf
            
            <div class="space-y-6">
                <!-- Facility -->
                <div>
                    <label for="FacilityId" class="block text-sm font-medium text-gray-700">Facility</label>
                    <select name="FacilityId" id="FacilityId" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
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

                <!-- Inventory Code -->
                <div>
                    <label for="InventoryCode" class="block text-sm font-medium text-gray-700">Inventory Code</label>
                    <input type="text" name="InventoryCode" id="InventoryCode" required
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                           value="{{ old('InventoryCode') }}">
                    @error('InventoryCode')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Capabilities -->
                <div>
                    <label for="Capabilities" class="block text-sm font-medium text-gray-700">Capabilities</label>
                    <textarea name="Capabilities" id="Capabilities" rows="2"
                              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">{{ old('Capabilities') }}</textarea>
                    <p class="mt-1 text-xs text-gray-500">Optional: Describe equipment capabilities</p>
                    @error('Capabilities')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Usage Domain -->
                <div>
                    <label for="UsageDomain" class="block text-sm font-medium text-gray-700">Usage Domain</label>
                    <select name="UsageDomain" id="UsageDomain" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                        <option value="Electronics" {{ old('UsageDomain') == 'Electronics' ? 'selected' : '' }}>Electronics</option>
                        <option value="Mechanical" {{ old('UsageDomain') == 'Mechanical' ? 'selected' : '' }}>Mechanical</option>
                        <option value="IoT" {{ old('UsageDomain') == 'IoT' ? 'selected' : '' }}>IoT</option>
                    </select>
                    @error('UsageDomain')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Support Phase -->
                <div>
                    <label for="SupportPhase" class="block text-sm font-medium text-gray-700">Support Phase</label>
                    <select name="SupportPhase" id="SupportPhase" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                        <option value="Training" {{ old('SupportPhase') == 'Training' ? 'selected' : '' }}>Training</option>
                        <option value="Prototyping" {{ old('SupportPhase') == 'Prototyping' ? 'selected' : '' }}>Prototyping</option>
                        <option value="Testing" {{ old('SupportPhase') == 'Testing' ? 'selected' : '' }}>Testing</option>
                    </select>
                    <p class="mt-1 text-xs text-yellow-600" id="electronics-warning" style="display: none;">
                        ⚠️ Electronics equipment must support Prototyping or Testing phase (not Training only)
                    </p>
                    @error('SupportPhase')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Form Actions -->
            <div class="mt-6 flex items-center justify-end space-x-3">
                <a href="{{ route('equipment.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Cancel
                </a>
                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Add Equipment
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const usageDomain = document.getElementById('UsageDomain');
    const supportPhase = document.getElementById('SupportPhase');
    const warning = document.getElementById('electronics-warning');
    
    function checkElectronicsRule() {
        if (usageDomain.value === 'Electronics') {
            warning.style.display = 'block';
            // Electronics cannot be Training only - must be Prototyping or Testing
            if (supportPhase.value === 'Training') {
                supportPhase.value = 'Prototyping';
            }
        } else {
            warning.style.display = 'none';
        }
    }
    
    usageDomain.addEventListener('change', checkElectronicsRule);
    supportPhase.addEventListener('change', checkElectronicsRule);
    checkElectronicsRule(); // Initial check
});
</script>
@endsection
