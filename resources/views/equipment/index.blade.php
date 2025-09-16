@extends('layouts.app')

@section('content')
<div class="bg-white shadow rounded-lg overflow-hidden">
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-[#070600] to-blue-800 text-white px-4 py-8 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div class="flex-1">
                    <h1 class="text-2xl font-bold">Equipment Inventory</h1>
                    <p class="mt-2 text-blue-100">Browse and manage all equipment across facilities</p>
                </div>
                <div class="mt-4 md:mt-0">
                    <a href="{{ route('equipment.create') }}" 
                       class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-blue-700 bg-white hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                        Add New Equipment
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Search and Filters Section -->
    <div class="border-b border-gray-200 px-4 py-5 sm:px-6">
        <form method="GET" action="{{ route('equipment.index') }}" class="space-y-4">
            <div class="flex flex-col md:flex-row md:items-end md:space-x-4 space-y-4 md:space-y-0">
                <!-- Search Input -->
                <div class="flex-1">
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <input type="text" name="search" id="search" 
                               value="{{ request('search') }}"
                               class="focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 sm:text-sm border-gray-300 rounded-md" 
                               placeholder="Search by name, capabilities, or inventory code">
                    </div>
                </div>
                
                <!-- Facility Filter -->
                <div>
                    <label for="facility" class="block text-sm font-medium text-gray-700 mb-1">Facility</label>
                    <select id="facility" name="facility" 
                            class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                        <option value="all" {{ request('facility') === 'all' ? 'selected' : '' }}>All Facilities</option>
                        @foreach($facilities as $id => $name)
                            <option value="{{ $id }}" {{ request('facility') == $id ? 'selected' : '' }}>{{ $name }}</option>
                        @endforeach
                    </select>
                </div>
                
                <!-- Usage Domain Filter -->
                <div>
                    <label for="usage_domain" class="block text-sm font-medium text-gray-700 mb-1">Domain</label>
                    <select id="usage_domain" name="usage_domain" 
                            class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                        <option value="all" {{ request('usage_domain') === 'all' ? 'selected' : '' }}>All Domains</option>
                        @foreach($usageDomains as $key => $label)
                            <option value="{{ $key }}" {{ request('usage_domain') == $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                
                <!-- Support Phase Filter -->
                <div>
                    <label for="support_phase" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select id="support_phase" name="support_phase" 
                            class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                        <option value="all" {{ request('support_phase') === 'all' ? 'selected' : '' }}>All Statuses</option>
                        @foreach($supportPhases as $key => $label)
                            <option value="{{ $key }}" {{ request('support_phase') == $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                
                <!-- Action Buttons -->
                <div class="flex space-x-2">
                    <button type="submit" 
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="-ml-1 mr-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 019 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd" />
                        </svg>
                        Apply Filters
                    </button>
                    <a href="{{ route('equipment.index') }}" 
                       class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="-ml-1 mr-2 h-4 w-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                        Clear All
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Equipment List Section -->
    <div class="px-4 py-5 sm:p-6">
        <div class="flex flex-col">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    @if($equipment->count() > 0)
                        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Equipment Details</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Facility</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Domain & Status</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($equipment as $item)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10 flex items-center justify-center rounded-full bg-indigo-100 text-indigo-600">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" />
                                                    </svg>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">{{ $item->Name }}</div>
                                                    <div class="text-xs text-gray-500">
                                                        <span class="font-semibold">ID:</span> {{ $item->InventoryCode }}
                                                        @if($item->Description)
                                                            <span class="mx-1">•</span>
                                                            {{ Str::limit($item->Description, 40) }}
                                                        @endif
                                                    </div>
                                                    <div class="mt-1 text-xs text-gray-500">
                                                        <span class="font-semibold">Capabilities:</span> {{ Str::limit($item->Capabilities, 50) }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($item->facility)
                                                <div class="text-sm text-gray-900">{{ $item->facility->Name }}</div>
                                                <div class="text-xs text-gray-500">{{ $item->facility->Location }}</div>
                                            @else
                                                <span class="text-sm text-gray-500">N/A</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex flex-col space-y-2">
                                                @php
                                                    $domainColors = [
                                                        'Electronics' => 'bg-blue-100 text-blue-800',
                                                        'Mechanical' => 'bg-green-100 text-green-800',
                                                        'IoT' => 'bg-purple-100 text-purple-800'
                                                    ];
                                                    $phaseColors = [
                                                        'Planning' => 'bg-yellow-100 text-yellow-800',
                                                        'Development' => 'bg-blue-100 text-blue-800',
                                                        'Testing' => 'bg-indigo-100 text-indigo-800',
                                                        'Production' => 'bg-green-100 text-green-800',
                                                        'Maintenance' => 'bg-orange-100 text-orange-800',
                                                        'Retired' => 'bg-red-100 text-red-800'
                                                    ];
                                                    $domainColor = $domainColors[$item->UsageDomain] ?? 'bg-gray-100 text-gray-800';
                                                    $phaseColor = $phaseColors[$item->SupportPhase] ?? 'bg-gray-100 text-gray-800';
                                                @endphp
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $domainColor }} w-fit">
                                                    {{ $item->UsageDomain }}
                                                </span>
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $phaseColor }} w-fit">
                                                    {{ $item->SupportPhase }}
                                                </span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex items-center space-x-3">
                                                <a href="{{ route('equipment.show', $item) }}" 
                                                   class="text-blue-600 hover:text-blue-900" 
                                                   title="View details">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                    </svg>
                                                </a>
                                                <a href="{{ route('equipment.edit', $item) }}" 
                                                   class="text-indigo-600 hover:text-indigo-900" 
                                                   title="Edit">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                </a>
                                                <form action="{{ route('equipment.destroy', $item) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this equipment?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900" title="Delete">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 22H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Pagination -->
                        <div class="mt-4">
                            {{ $equipment->appends(request()->except('page'))->links() }}
                        </div>
                    @else
                        <div class="text-center py-12 bg-gray-50 rounded-lg">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No equipment found</h3>
                            <p class="mt-1 text-sm text-gray-500">
                                @if(request()->hasAny(['search', 'facility', 'usage_domain', 'support_phase']))
                                    Try adjusting your search or filter criteria
                                @else
                                    Get started by adding a new equipment
                                @endif
                            </p>
                            <div class="mt-6">
                                <a href="{{ route('equipment.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                                    </svg>
                                    New Equipment
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
