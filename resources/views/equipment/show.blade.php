@extends('layouts.app')

@section('content')
<div class="bg-white shadow rounded-lg overflow-hidden">
    <!-- Header Section -->
    <div class="bg-gradient-to-r from-[#070600] to-blue-800 text-white px-4 py-8 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div class="flex-1">
                    <div class="flex items-center">
                        <a href="{{ route('equipment.index') }}" 
                           class="text-green-100 hover:text-white mr-4">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                            </svg>
                        </a>
                        <h1 class="text-2xl font-bold">{{ $equipment->Name }}</h1>
                    </div>
                    <p class="mt-2 text-green-100">Equipment Details</p>
                </div>
                <div class="mt-4 md:mt-0">
                    <div class="flex space-x-3">
                        <a href="{{ route('equipment.edit', $equipment) }}" 
                           class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-green-700 bg-white hover:bg-green-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Edit Equipment
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Equipment Details -->
    <div class="px-4 py-5 sm:p-6">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Information -->
            <div class="lg:col-span-2">
                <div class="bg-white shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Equipment Information</h3>
                        
                        <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Name</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $equipment->Name }}</dd>
                            </div>
                            
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Inventory Code</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $equipment->InventoryCode }}
                                    </span>
                                </dd>
                            </div>
                            
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Usage Domain</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        {{ $equipment->UsageDomain }}
                                    </span>
                                </dd>
                            </div>
                            
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Support Phase</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                        @if($equipment->SupportPhase === 'Training') bg-blue-100 text-blue-800
                                        @elseif($equipment->SupportPhase === 'Prototyping') bg-green-100 text-green-800
                                        @else bg-gray-100 text-gray-800
                                        @endif">
                                        {{ $equipment->SupportPhase }}
                                    </span>
                                </dd>
                            </div>
                        </dl>
                        
                        @if($equipment->Description)
                            <div class="mt-6">
                                <dt class="text-sm font-medium text-gray-500 mb-2">Description</dt>
                                <dd class="text-sm text-gray-900 bg-gray-50 rounded-lg p-4">
                                    {{ $equipment->Description }}
                                </dd>
                            </div>
                        @endif
                        
                        <div class="mt-6">
                            <dt class="text-sm font-medium text-gray-500 mb-2">Capabilities</dt>
                            <dd class="text-sm text-gray-900 bg-gray-50 rounded-lg p-4">
                                {{ $equipment->Capabilities }}
                            </dd>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Facility Information -->
            <div class="lg:col-span-1">
                <div class="bg-white shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Facility</h3>
                        
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="h-10 w-10 rounded-full bg-green-100 flex items-center justify-center">
                                    <svg class="h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">
                                    <a href="{{ route('facilities.show', $equipment->facility) }}" 
                                       class="text-green-600 hover:text-green-800 hover:underline">
                                        {{ $equipment->facility->Name }}
                                    </a>
                                </div>
                                <div class="text-sm text-gray-500">
                                    {{ $equipment->facility->Location }}
                                </div>
                                @if($equipment->facility->FacilityType)
                                    <div class="mt-1">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800">
                                            {{ $equipment->facility->FacilityType }}
                                        </span>
                                    </div>
                                @endif
                            </div>
                        </div>
                        
                        @if($equipment->facility->Description)
                            <div class="mt-4">
                                <p class="text-sm text-gray-600 bg-gray-50 rounded p-3">
                                    {{ $equipment->facility->Description }}
                                </p>
                            </div>
                        @endif
                        
                        <div class="mt-4">
                            <a href="{{ route('equipment.index', ['facility' => $equipment->facility->FacilityId]) }}" 
                               class="text-sm text-green-600 hover:text-green-800 font-medium">
                                View all equipment at this facility →
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Quick Actions -->
                <div class="mt-6 bg-white shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Actions</h3>
                        
                        <div class="space-y-3">
                            <a href="{{ route('equipment.edit', $equipment) }}" 
                               class="w-full inline-flex justify-center items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                <svg class="-ml-1 mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                Edit Equipment
                            </a>
                            
                            <form id="delete-form-equipment-{{ $equipment->EquipmentId }}" 
                                  action="{{ route('equipment.destroy', $equipment) }}" 
                                  method="POST" 
                                  style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                            <button type="button" 
                                    onclick="deleteEquipment({{ $equipment->EquipmentId }}, {{ json_encode($equipment->Name) }})"
                                    class="w-full inline-flex justify-center items-center px-4 py-2 border border-red-300 shadow-sm text-sm font-medium rounded-md text-red-700 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                <svg class="-ml-1 mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 22H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                Delete Equipment
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function deleteEquipment(equipmentId, equipmentName) {
    const form = document.getElementById(`delete-form-equipment-${equipmentId}`);
    
    console.log('Deleting equipment:', equipmentId, equipmentName);
    console.log('Form found:', !!form);
    
    // Check if modal is available
    if (window.deleteModal && typeof window.deleteModal.show === 'function') {
        console.log('Using modal for equipment delete');
        
        window.deleteModal.show({
            title: `Delete Equipment: ${equipmentName}`,
            message: `Are you sure you want to delete "${equipmentName}"? This action cannot be undone.`,
            form: form
        });
    } else {
        console.log('Modal not available, using browser confirm');
        // Fallback to browser confirm
        if (confirm(`Are you sure you want to delete "${equipmentName}"? This action cannot be undone.`)) {
            if (form) {
                form.submit();
            }
        }
    }
}
</script>
@endsection
