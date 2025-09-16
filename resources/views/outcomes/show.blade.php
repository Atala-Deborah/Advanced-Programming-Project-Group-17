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

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-200">
            <h2 class="text-lg font-medium text-gray-900">Outcome Information</h2>
        </div>
        <div class="px-6 py-5">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Title</h3>
                    <p class="mt-1 text-sm text-gray-900">{{ $outcome->Title }}</p>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Project</h3>
                    <p class="mt-1 text-sm text-gray-900">
                        {{ $outcome->project->Title ?? 'N/A' }}
                    </p>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Outcome Type</h3>
                    <p class="mt-1">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                            {{ $outcome->OutcomeType }}
                        </span>
                    </p>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Commercialization Status</h3>
                    @php
                        $statusColors = [
                            'Demoed' => 'bg-yellow-100 text-yellow-800',
                            'Market Linked' => 'bg-green-100 text-green-800',
                            'Launched' => 'bg-purple-100 text-purple-800'
                        ];
                        $color = $statusColors[$outcome->CommercializationStatus] ?? 'bg-gray-100 text-gray-800';
                    @endphp
                    <p class="mt-1">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $color }}">
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
                @if($outcome->ArtifactLink)
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Artifact</h3>
                    <p class="mt-1">
                        @if(filter_var($outcome->ArtifactLink, FILTER_VALIDATE_URL))
                            <a href="{{ $outcome->ArtifactLink }}" 
                               target="_blank" 
                               class="text-blue-600 hover:underline inline-flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                </svg>
                                View External Artifact
                            </a>
                        @elseif(Storage::disk('public')->exists($outcome->ArtifactLink))
                            <a href="{{ route('outcomes.download', $outcome->OutcomeId) }}" 
                               class="text-blue-600 hover:underline inline-flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                Download Artifact
                            </a>
                        @else
                            <span class="text-red-500 inline-flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                File not found
                            </span>
                        @endif
                    </p>
                </div>
                @endif
                <div class="col-span-2">
                    <h3 class="text-sm font-medium text-gray-500">Description</h3>
                    <div class="mt-1 text-sm text-gray-900 whitespace-pre-line">
                        {{ $outcome->Description }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-6 flex justify-end">
        <form id="delete-outcome-form" action="{{ route('outcomes.destroy', $outcome->OutcomeId) }}" method="POST" class="hidden">
            @csrf
            @method('DELETE')
        </form>
        <button onclick="deleteOutcome()" 
                class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded">
            Delete Outcome
        </button>
    </div>
</div>

@push('scripts')
<script>
    // Delete outcome function
    function deleteOutcome() {
        const form = document.getElementById('delete-outcome-form');
        
        confirmDelete({
            title: 'Delete Outcome',
            message: `Are you sure you want to delete "{{ $outcome->Title }}"?`,
            form: form
        });
    }
</script>
@endpush

@endsection
