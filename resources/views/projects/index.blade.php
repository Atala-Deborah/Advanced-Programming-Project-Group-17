@extends('layouts.app')

@section('content')
<div class="bg-white shadow rounded-lg overflow-hidden">
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-indigo-600 to-blue-600 text-white px-4 py-8 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div class="flex-1">
                    <h1 class="text-2xl font-bold">
                        @if(isset($facility))
                            Projects at {{ $facility->Name }}
                        @else
                            All Projects
                        @endif
                    </h1>
                    <p class="mt-2 text-blue-100">Browse and manage innovation projects across facilities</p>
                </div>
                <div class="mt-4 md:mt-0">
                    <a href="{{ route('projects.create', isset($facility) ? ['facility_id' => $facility->FacilityId] : []) }}" 
                       class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-blue-700 bg-white hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                        New Project
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Search and Filters Section -->
    <div class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <form method="GET" action="{{ isset($facility) ? route('projects.by_facility', $facility->FacilityId) : route('projects.index') }}">
                <div class="py-4 flex flex-col sm:flex-row items-end space-y-4 sm:space-y-0 sm:space-x-4">
                    <!-- Search Input -->
                    <div class="flex-1 w-full">
                        <label for="search" class="sr-only">Search projects</label>
                        <div class="relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input type="text" name="search" id="search" 
                                   value="{{ request('search') }}"
                                   class="focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 sm:text-sm border-gray-300 rounded-md h-10" 
                                   placeholder="Search projects...">
                        </div>
                    </div>
                    
                    <!-- Facility Filter -->
                    <div class="w-full sm:w-48">
                        <label for="facility" class="block text-xs font-medium text-gray-700 mb-1">Facility</label>
                        <select id="facility" name="facility" 
                                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md h-10">
                            <option value="all" {{ request('facility') === 'all' ? 'selected' : '' }}>All Facilities</option>
                            @foreach($facilities as $id => $name)
                                <option value="{{ $id }}" {{ request('facility') == $id ? 'selected' : '' }}>{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <!-- Status Filter -->
                    <div class="w-full sm:w-40">
                        <label for="status" class="block text-xs font-medium text-gray-700 mb-1">Status</label>
                        <select id="status" name="status" 
                                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md h-10">
                            <option value="all" {{ request('status') === 'all' ? 'selected' : '' }}>All Statuses</option>
                            @foreach($statuses as $key => $label)
                                <option value="{{ $key }}" {{ request('status') == $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                
                    <!-- Nature Filter -->
                    <div class="w-full sm:w-48">
                        <label for="nature" class="block text-xs font-medium text-gray-700 mb-1">Project Type</label>
                        <select id="nature" name="nature" 
                                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md h-10">
                            <option value="all" {{ request('nature') === 'all' ? 'selected' : '' }}>All Types</option>
                            @foreach($natures as $key => $label)
                                <option value="{{ $key }}" {{ request('nature') == $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <!-- Stage Filter -->
                    <div class="w-full sm:w-48">
                        <label for="stage" class="block text-xs font-medium text-gray-700 mb-1">Stage</label>
                        <select id="stage" name="stage" 
                                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md h-10">
                            <option value="all" {{ request('stage') === 'all' ? 'selected' : '' }}>All Stages</option>
                            @foreach($stages as $key => $label)
                                <option value="{{ $key }}" {{ request('stage') == $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                
                    <!-- Action Buttons -->
                    <div class="flex items-end space-x-2">
                        <button type="submit" 
                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 h-10">
                            <svg class="-ml-0.5 mr-1.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 019 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd" />
                            </svg>
                            Apply
                        </button>
                        <a href="{{ isset($facility) ? route('projects.by_facility', $facility->FacilityId) : route('projects.index') }}" 
                           class="inline-flex items-center px-3 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 h-10">
                            <svg class="-ml-0.5 mr-1.5 h-4 w-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                            Clear
                        </a>
                    </div>
                </div>
                
                <!-- Results Count -->
                <div class="mt-2 text-xs text-gray-500">
                    {{ $projects->total() }} {{ Str::plural('project', $projects->total()) }} found
                </div>
            </form>
        </div>
    </div>
    
    <!-- Projects List Section -->
    <div class="px-4 py-5 sm:p-6">
        @if($projects->count() > 0)
            <div class="space-y-4">
                @foreach($projects as $project)
                    <div class="bg-white overflow-hidden shadow rounded-lg border border-gray-200 hover:shadow-md transition-shadow duration-200">
                        <div class="p-5">
                            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center">
                                        <h3 class="text-lg font-semibold text-gray-900 truncate">
                                            {{ $project->Title }}
                                        </h3>
                                        <span class="ml-2 px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            @if($project->Status === 'Active') bg-green-100 text-green-800
                                            @elseif($project->Status === 'Planning') bg-blue-100 text-blue-800
                                            @elseif($project->Status === 'Completed') bg-gray-100 text-gray-800
                                            @else bg-yellow-100 text-yellow-800
                                            @endif">
                                            {{ $project->Status }}
                                        </span>
                                    </div>
                                    <p class="mt-1 text-sm text-gray-600 line-clamp-2">
                                        {{ $project->Description }}
                                    </p>
                                    <div class="mt-2 flex flex-wrap gap-2">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            {{ $project->NatureOfProject }}
                                        </span>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                            {{ $project->PrototypeStage }}
                                        </span>
                                        @if($project->InnovationFocus)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                                {{ $project->InnovationFocus }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="mt-4 md:mt-0 md:ml-4 flex-shrink-0">
                                    <div class="flex items-center space-x-4">
                                        <div class="text-right">
                                            <a href="{{ route('projects.by_facility', $project->facility->FacilityId) }}" 
                                               class="text-sm font-medium text-blue-600 hover:text-blue-800 hover:underline">
                                                {{ $project->facility->Name }}
                                            </a>
                                            <p class="text-xs text-gray-500">
                                                {{ $project->StartDate->format('M d, Y') }} 
                                                @if($project->EndDate)
                                                    - {{ $project->EndDate->format('M d, Y') }}
                                                @else
                                                    - Present
                                                @endif
                                            </p>
                                        </div>
                                        <div class="flex space-x-2">
                                            <a href="{{ route('projects.show', $project) }}" 
                                               class="inline-flex items-center p-2 border border-gray-300 rounded-full shadow-sm text-gray-400 hover:text-blue-600 hover:border-blue-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                                               title="View details">
                                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </a>
                                            <a href="{{ route('projects.edit', $project) }}" 
                                               class="inline-flex items-center p-2 border border-gray-300 rounded-full shadow-sm text-gray-400 hover:text-green-600 hover:border-green-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500"
                                               title="Edit">
                                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </a>
                                            <form action="{{ route('projects.destroy', $project) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this project?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="inline-flex items-center p-2 border border-gray-300 rounded-full shadow-sm text-gray-400 hover:text-red-600 hover:border-red-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                                                        title="Delete">
                                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 22H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            @if($project->participants->count() > 0)
                                <div class="mt-4 pt-4 border-t border-gray-100">
                                    <div class="flex items-center">
                                        <div class="flex -space-x-2 overflow-hidden">
                                            @foreach($project->participants->take(5) as $participant)
                                                <div class="inline-block h-8 w-8 rounded-full ring-2 ring-white bg-gray-200 flex items-center justify-center text-gray-600 text-xs font-medium">
                                                    {{ substr($participant->FullName, 0, 1) }}{{ substr(strrchr($participant->FullName, ' '), 1, 1) }}
                                                </div>
                                            @endforeach
                                            @if($project->participants->count() > 5)
                                                <div class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-gray-200 text-gray-600 text-xs font-medium">
                                                    +{{ $project->participants->count() - 5 }}
                                                </div>
                                            @endif
                                        </div>
                                        <span class="ml-3 text-sm text-gray-500">
                                            {{ $project->participants->count() }} {{ Str::plural('participant', $project->participants->count()) }}
                                        </span>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            <div class="mt-6">
                {{ $projects->appends(request()->except('page'))->links() }}
            </div>
        @else
            <div class="text-center py-12 bg-gray-50 rounded-lg">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No projects found</h3>
                <p class="mt-1 text-sm text-gray-500">
                    @if(request()->hasAny(['search', 'facility', 'status', 'nature', 'stage', 'start_date', 'end_date']))
                        Try adjusting your search or filter criteria
                    @else
                        Get started by creating a new project
                    @endif
                </p>
                <div class="mt-6">
                    <a href="{{ route('projects.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                        New Project
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
