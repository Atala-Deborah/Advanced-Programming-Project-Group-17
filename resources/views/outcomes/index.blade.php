@extends('layouts.app')

@section('content')
<div class="bg-white shadow rounded-lg overflow-hidden">
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-[#070600] to-blue-800 text-white px-4 py-8 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div class="flex-1">
                    <h1 class="text-2xl font-bold">
                        @if(isset($project))
                            Outcomes for {{ $project->Title }}
                        @else
                            All Project Outcomes
                        @endif
                    </h1>
                    <p class="mt-2 text-blue-100">
                        @if(isset($project))
                            <a href="{{ route('projects.show', $project->ProjectId) }}" class="text-blue-200 hover:text-white">
                                &larr; Back to project
                            </a>
                        @else
                            Browse and manage all project outcomes
                        @endif
                    </p>
                </div>
                <div class="mt-4 md:mt-0">
                    <a href="{{ route('outcomes.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-blue-700 bg-white hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                        Add Outcome
                    </a>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="max-w-7xl mx-auto px-4 py-3">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    <div class="px-4 py-5 sm:p-6">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Project</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($outcomes as $outcome)
                    <tr>
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-gray-900">{{ $outcome->Title }}</div>
                            <div class="text-sm text-gray-500">{{ Str::limit($outcome->Description, 50) }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                @switch($outcome->OutcomeType)
                                    @case('CAD') bg-blue-100 text-blue-800 @break
                                    @case('PCB') bg-purple-100 text-purple-800 @break
                                    @case('Prototype') bg-yellow-100 text-yellow-800 @break
                                    @case('Report') bg-green-100 text-green-800 @break
                                    @case('Business Plan') bg-indigo-100 text-indigo-800 @break
                                    @default bg-gray-100 text-gray-800
                                @endswitch">
                                {{ $outcome->OutcomeType }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            {{ $outcome->project->Title ?? 'N/A' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                @switch($outcome->CommercializationStatus)
                                    @case('Demoed') bg-blue-100 text-blue-800 @break
                                    @case('Market Linked') bg-green-100 text-green-800 @break
                                    @case('Launched') bg-purple-100 text-purple-800 @break
                                    @default bg-gray-100 text-gray-800
                                @endswitch">
                                {{ $outcome->CommercializationStatus }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="{{ route('outcomes.show', $outcome->OutcomeId) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">View</a>
                            <a href="{{ route('outcomes.edit', $outcome->OutcomeId) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                            <form id="delete-outcome-{{ $outcome->OutcomeId }}" 
                                  action="{{ route('outcomes.destroy', $outcome->OutcomeId) }}" 
                                  method="POST" class="hidden">
                                @csrf
                                @method('DELETE')
                            </form>
                            <button onclick="deleteOutcome({{ $outcome->OutcomeId }}, {{ json_encode($outcome->Title) }})" 
                                    class="text-red-600 hover:text-red-900">
                                Delete
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                            @if(isset($project))
                                No outcomes found for this project.
                            @else
                                No outcomes found.
                            @endif
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $outcomes->links() }}
    </div>
</div>

@push('scripts')
<script>
    // Outcomes use the universal delete function  
    console.log('Outcomes index script loaded');
</script>
@endpush

@endsection
