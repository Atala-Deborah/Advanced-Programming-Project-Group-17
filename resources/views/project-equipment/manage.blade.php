@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold">Manage Project Equipment</h1>
            <p class="text-gray-600">{{ $project->Title }}</p>
            <p class="text-sm text-gray-500 mt-1">Facility: {{ $project->facility->Name }}</p>
        </div>
        <div class="space-x-2">
            <a href="{{ route('projects.show', $project->ProjectId) }}"
               class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded">
                Back to Project
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Currently Assigned Equipment -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-medium text-gray-900">Assigned Equipment ({{ $project->equipment->count() }})</h2>
            </div>
            <div class="divide-y divide-gray-200">
                @forelse($project->equipment as $equipment)
                    <div class="px-6 py-4">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <div class="flex items-start space-x-3">
                                    <div class="flex-shrink-0">
                                        <div class="h-12 w-12 rounded-lg bg-blue-100 flex items-center justify-center">
                                            <svg class="h-6 w-6 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z" />
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm font-medium text-gray-900">{{ $equipment->Name }}</p>
                                        <p class="text-xs text-gray-500 mt-1">{{ $equipment->Description }}</p>
                                        <div class="flex flex-wrap gap-1 mt-2">
                                            <span class="px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full">
                                                {{ $equipment->Type }}
                                            </span>
                                            <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">
                                                {{ $equipment->Status }}
                                            </span>
                                            @if($equipment->SupportPhase)
                                                <span class="px-2 py-1 text-xs font-medium bg-purple-100 text-purple-800 rounded-full">
                                                    {{ $equipment->SupportPhase }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex-shrink-0 flex items-center space-x-2 ml-4">
                                <a href="{{ route('equipment.show', $equipment->EquipmentId) }}" 
                                   class="text-indigo-600 hover:text-indigo-900 text-sm">View</a>
                                <form id="remove-equipment-{{ $equipment->EquipmentId }}" 
                                      action="{{ route('projects.equipment.detach', [$project->ProjectId, $equipment->EquipmentId]) }}" 
                                      method="POST" class="hidden">
                                    @csrf
                                    @method('DELETE')
                                </form>
                                <button onclick="removeEquipment({{ $equipment->EquipmentId }}, {{ json_encode($equipment->Name) }})" 
                                        class="text-red-600 hover:text-red-900 text-sm">
                                    Remove
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="px-6 py-8 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No equipment assigned</h3>
                        <p class="mt-1 text-sm text-gray-500">Start by assigning equipment from this project's facility.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Add Equipment from Facility -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-medium text-gray-900">Available Equipment</h2>
                <p class="text-sm text-gray-500 mt-1">Equipment from {{ $project->facility->Name }}</p>
            </div>
            <div class="p-6">
                @if($availableEquipment->count() > 0)
                    <div class="space-y-4">
                        @foreach($availableEquipment as $equipment)
                            <div class="border rounded-lg p-4 hover:border-indigo-500 transition-colors">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <div class="flex items-start space-x-3">
                                            <div class="flex-shrink-0">
                                                <div class="h-10 w-10 rounded-lg bg-gray-100 flex items-center justify-center">
                                                    <svg class="h-5 w-5 text-gray-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z" />
                                                    </svg>
                                                </div>
                                            </div>
                                            <div class="flex-1">
                                                <p class="text-sm font-medium text-gray-900">{{ $equipment->Name }}</p>
                                                <p class="text-xs text-gray-500 mt-1">{{ $equipment->Description }}</p>
                                                <div class="flex flex-wrap gap-1 mt-2">
                                                    <span class="px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full">
                                                        {{ $equipment->Type }}
                                                    </span>
                                                    <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">
                                                        {{ $equipment->Status }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-shrink-0 ml-4">
                                        <form action="{{ route('projects.equipment.attach', [$project->ProjectId, $equipment->EquipmentId]) }}" 
                                              method="POST">
                                            @csrf
                                            <button type="submit"
                                                    class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                <svg class="-ml-0.5 mr-1 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                                </svg>
                                                Assign
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <svg class="mx-auto h-12 w-12 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">All facility equipment assigned</h3>
                        <p class="mt-1 text-sm text-gray-500">All available equipment from this facility is already assigned to the project.</p>
                        <div class="mt-4">
                            <a href="{{ route('equipment.create') }}" 
                               class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                                <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                Add New Equipment
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Project & Facility Summary -->
    <div class="mt-8 bg-gray-50 rounded-lg p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Equipment Summary</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="text-center">
                <div class="text-2xl font-bold text-indigo-600">{{ $project->equipment->count() }}</div>
                <div class="text-sm text-gray-500">Assigned to Project</div>
            </div>
            <div class="text-center">
                <div class="text-2xl font-bold text-green-600">{{ $availableEquipment->count() }}</div>
                <div class="text-sm text-gray-500">Available to Assign</div>
            </div>
            <div class="text-center">
                <div class="text-2xl font-bold text-purple-600">{{ $project->facility->equipment->count() }}</div>
                <div class="text-sm text-gray-500">Total in Facility</div>
            </div>
            <div class="text-center">
                <div class="text-2xl font-bold text-orange-600">
                    {{ $project->equipment->where('Status', 'Available')->count() }}
                </div>
                <div class="text-sm text-gray-500">Available Status</div>
            </div>
        </div>
        
        <div class="mt-4 p-4 bg-blue-50 rounded-lg">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-blue-700">
                        <strong>How it works:</strong> Projects can only use equipment from their own facility. 
                        This project is at <strong>{{ $project->facility->Name }}</strong>, so only equipment registered at that facility appears here. 
                        To assign equipment from another facility, you must first transfer the equipment to {{ $project->facility->Name }}.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
