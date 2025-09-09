@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold">{{ $outcome->Title }}</h1>
            <p class="text-gray-600">Outcome Details</p>
        </div>
        <div class="space-x-2">
            <a href="{{ route('outcomes.edit', $outcome->OutcomeId) }}" 
               class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded">
                Edit
            </a>
            <a href="{{ route('outcomes.index') }}" 
               class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded">
                Back to List
            </a>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden mb-8">
        <div class="px-6 py-5 border-b border-gray-200">
            <h2 class="text-lg font-medium text-gray-900">Outcome Information</h2>
        </div>
        <div class="px-6 py-5">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Project</h3>
                    <p class="mt-1 text-sm text-gray-900">
                        <a href="{{ route('projects.show', $outcome->ProjectId) }}" class="text-indigo-600 hover:text-indigo-900">
                            {{ $outcome->project->Title ?? 'N/A' }}
                        </a>
                    </p>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Outcome Type</h3>
                    <p class="mt-1">
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
                    </p>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Commercialization Status</h3>
                    <p class="mt-1">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                            @switch($outcome->CommercializationStatus)
                                @case('Demoed') bg-blue-100 text-blue-800 @break
                                @case('Market Linked') bg-green-100 text-green-800 @break
                                @case('Launched') bg-purple-100 text-purple-800 @break
                                @default bg-gray-100 text-gray-800
                            @endswitch">
                            {{ $outcome->CommercializationStatus }}
                        </span>
                    </p>
                </div>
                @if($outcome->QualityCertification)
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Quality Certification</h3>
                    <p class="mt-1 text-sm text-gray-900">{{ $outcome->QualityCertification }}</p>
                </div>
                @endif
            </div>

            <div class="mt-6">
                <h3 class="text-sm font-medium text-gray-500">Description</h3>
                <div class="mt-1 text-sm text-gray-900 whitespace-pre-line">
                    {{ $outcome->Description }}
                </div>
            </div>

            @if($outcome->ArtifactLink)
            <div class="mt-6">
                <h3 class="text-sm font-medium text-gray-500 mb-2">Artifact</h3>
                @if(str_starts_with($outcome->ArtifactLink, 'http'))
                    <a href="{{ $outcome->ArtifactLink }}" target="_blank" 
                       class="inline-flex items-center text-indigo-600 hover:text-indigo-900">
                        <svg class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                        </svg>
                        {{ $outcome->ArtifactLink }}
                    </a>
                @else
                    <div class="flex items-center">
                        <svg class="h-5 w-5 text-gray-400 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        @if($outcome->artifact_url)
                        <a href="{{ $outcome->artifact_url }}" 
                           class="text-indigo-600 hover:text-indigo-900"
                           target="_blank"
                           download>
                            Download {{ basename($outcome->ArtifactLink) }}
                        </a>
                        @php
                            try {
                                $size = Storage::disk('public')->exists($outcome->ArtifactLink) 
                                    ? round(Storage::disk('public')->size($outcome->ArtifactLink) / 1024, 1) . ' KB'
                                    : 'N/A';
                            } catch (\Exception $e) {
                                $size = 'N/A';
                            }
                        @endphp
                        <span class="ml-2 text-xs text-gray-500">
                            ({{ $size }})
                        </span>
                    @else
                        <span class="text-gray-500">File not found</span>
                    @endif
                    </div>
                @endif
            </div>
            @endif
        </div>
    </div>

    <!-- Related Project Information -->
    @if($outcome->project)
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-200">
            <h2 class="text-lg font-medium text-gray-900">Project Information</h2>
        </div>
        <div class="px-6 py-5">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Project Title</h3>
                    <p class="mt-1 text-sm text-gray-900">
                        <a href="{{ route('projects.show', $outcome->project->ProjectId) }}" class="text-indigo-600 hover:text-indigo-900">
                            {{ $outcome->project->Title }}
                        </a>
                    </p>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Project Status</h3>
                    <p class="mt-1">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                            @switch($outcome->project->Status)
                                @case('Planning') bg-blue-100 text-blue-800 @break
                                @case('In Progress') bg-yellow-100 text-yellow-800 @break
                                @case('Completed') bg-green-100 text-green-800 @break
                                @case('On Hold') bg-red-100 text-red-800 @break
                                @default bg-gray-100 text-gray-800
                            @endswitch">
                            {{ $outcome->project->Status }}
                        </span>
                    </p>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Start Date</h3>
                    <p class="mt-1 text-sm text-gray-900">
                        {{ $outcome->project->StartDate->format('F j, Y') }}
                    </p>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-500">End Date</h3>
                    <p class="mt-1 text-sm text-gray-900">
                        {{ $outcome->project->EndDate ? $outcome->project->EndDate->format('F j, Y') : 'Ongoing' }}
                    </p>
                </div>
                <div class="md:col-span-2">
                    <h3 class="text-sm font-medium text-gray-500">Description</h3>
                    <div class="mt-1 text-sm text-gray-900 whitespace-pre-line">
                        {{ $outcome->project->Description }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="hidden fixed z-10 inset-0 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
            <div>
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                    <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <div class="mt-3 text-center sm:mt-5">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Delete Outcome</h3>
                    <div class="mt-2">
                        <p class="text-sm text-gray-500">
                            Are you sure you want to delete this outcome? This action cannot be undone.
                        </p>
                    </div>
                </div>
            </div>
            <div class="mt-5 sm:mt-6 sm:grid sm:grid-cols-2 sm:gap-3 sm:grid-flow-row-dense">
                <form action="{{ route('outcomes.destroy', $outcome->OutcomeId) }}" method="POST" class="inline-block w-full">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:col-start-2 sm:text-sm">
                        Delete
                    </button>
                </form>
                <button type="button" onclick="document.getElementById('deleteModal').classList.add('hidden')" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:col-start-1 sm:text-sm">
                    Cancel
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function showDeleteModal() {
        document.getElementById('deleteModal').classList.remove('hidden');
    }
</script>
@endpush
@endsection
