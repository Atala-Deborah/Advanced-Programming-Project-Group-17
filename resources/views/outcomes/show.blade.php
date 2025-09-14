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
                        @if(Storage::disk('public')->exists($outcome->ArtifactLink))
                            <a href="{{ Storage::url($outcome->ArtifactLink) }}" 
                               target="_blank" 
                               class="text-blue-600 hover:underline">
                                Download Artifact
                            </a>
                        @else
                            <span class="text-red-500">File not found</span>
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
        <form action="{{ route('outcomes.destroy', $outcome->OutcomeId) }}" method="POST" class="inline">
            @csrf
            @method('DELETE')
            <button type="submit" 
                    class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded"
                    onclick="return confirm('Are you sure you want to delete this outcome?')">
                Delete Outcome
            </button>
        </form>
    </div>
</div>
@endsection
