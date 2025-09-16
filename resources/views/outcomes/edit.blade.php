@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Edit Outcome</h1>
        <a href="{{ route('outcomes.index') }}" class="text-gray-600 hover:text-gray-800">
            Back to Outcomes
        </a>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="p-6">
            <form action="{{ route('outcomes.update', $outcome->OutcomeId) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 gap-6">
                    <div>
                        <label for="ProjectId" class="block text-sm font-medium text-gray-700">Project *</label>
                        <select name="ProjectId" id="ProjectId" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @foreach($projects as $project)
                                <option value="{{ $project->ProjectId }}" 
                                    {{ old('ProjectId', $outcome->ProjectId) == $project->ProjectId ? 'selected' : '' }}>
                                    {{ $project->Title }}
                                </option>
                            @endforeach
                        </select>
                        @error('ProjectId')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="Title" class="block text-sm font-medium text-gray-700">Title *</label>
                        <input type="text" name="Title" id="Title" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            value="{{ old('Title', $outcome->Title) }}">
                        @error('Title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="Description" class="block text-sm font-medium text-gray-700">Description *</label>
                        <textarea name="Description" id="Description" rows="3" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('Description', $outcome->Description) }}</textarea>
                        @error('Description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="OutcomeType" class="block text-sm font-medium text-gray-700">Outcome Type *</label>
                            <select name="OutcomeType" id="OutcomeType" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="CAD" {{ old('OutcomeType', $outcome->OutcomeType) == 'CAD' ? 'selected' : '' }}>CAD Design</option>
                                <option value="PCB" {{ old('OutcomeType', $outcome->OutcomeType) == 'PCB' ? 'selected' : '' }}>PCB Design</option>
                                <option value="Prototype" {{ old('OutcomeType', $outcome->OutcomeType) == 'Prototype' ? 'selected' : '' }}>Prototype</option>
                                <option value="Report" {{ old('OutcomeType', $outcome->OutcomeType) == 'Report' ? 'selected' : '' }}>Report</option>
                                <option value="Business Plan" {{ old('OutcomeType', $outcome->OutcomeType) == 'Business Plan' ? 'selected' : '' }}>Business Plan</option>
                            </select>
                            @error('OutcomeType')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="CommercializationStatus" class="block text-sm font-medium text-gray-700">Commercialization Status *</label>
                            <select name="CommercializationStatus" id="CommercializationStatus" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="Demoed" {{ old('CommercializationStatus', $outcome->CommercializationStatus) == 'Demoed' ? 'selected' : '' }}>Demoed</option>
                                <option value="Market Linked" {{ old('CommercializationStatus', $outcome->CommercializationStatus) == 'Market Linked' ? 'selected' : '' }}>Market Linked</option>
                                <option value="Launched" {{ old('CommercializationStatus', $outcome->CommercializationStatus) == 'Launched' ? 'selected' : '' }}>Launched</option>
                            </select>
                            @error('CommercializationStatus')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label for="QualityCertification" class="block text-sm font-medium text-gray-700">Quality Certification</label>
                        <input type="text" name="QualityCertification" id="QualityCertification"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            value="{{ old('QualityCertification', $outcome->QualityCertification) }}">
                        @error('QualityCertification')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    @if($outcome->ArtifactLink)
                        <div class="border border-gray-200 rounded-md p-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Current Artifact</label>
                            @if(str_starts_with($outcome->ArtifactLink, 'http'))
                                <a href="{{ $outcome->ArtifactLink }}" target="_blank" class="text-indigo-600 hover:text-indigo-900 break-all">
                                    {{ $outcome->ArtifactLink }}
                                </a>
                            @else
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <svg class="h-5 w-5 text-gray-400 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        <span>File: {{ basename($outcome->ArtifactLink) }}</span>
                                    </div>
                                    @if(Storage::disk('public')->exists($outcome->ArtifactLink))
                                        <a href="{{ route('outcomes.download', $outcome->OutcomeId) }}" 
                                           class="text-indigo-600 hover:text-indigo-900 text-sm inline-flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                            Download
                                        </a>
                                    @endif
                                </div>
                                <div class="mt-2">
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" name="remove_artifact" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                        <span class="ml-2 text-sm text-gray-600">Remove current artifact</span>
                                    </label>
                                </div>
                            @endif
                        </div>
                    @endif

                    <div>
                        <label for="artifact" class="block text-sm font-medium text-gray-700">Update Artifact File</label>
                        <input type="file" name="artifact" id="artifact"
                            class="mt-1 block w-full text-sm text-gray-500
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-md file:border-0
                                file:text-sm file:font-semibold
                                file:bg-indigo-50 file:text-indigo-700
                                hover:file:bg-indigo-100">
                        <p class="mt-1 text-xs text-gray-500">Upload a new file to replace the current one (max: 10MB)</p>
                        @error('artifact')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="ArtifactLink" class="block text-sm font-medium text-gray-700">Or Update Artifact URL</label>
                        <input type="url" name="ArtifactLink" id="ArtifactLink"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            placeholder="https://example.com/artifact"
                            value="{{ old('ArtifactLink', str_starts_with($outcome->ArtifactLink, 'http') ? $outcome->ArtifactLink : '') }}">
                        <p class="mt-1 text-xs text-gray-500">Provide a URL if the artifact is hosted online</p>
                        @error('ArtifactLink')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-6 flex justify-between">
                    <button type="button" onclick="if(confirm('Are you sure you want to delete this outcome?')) { document.getElementById('delete-form').submit(); }"
                        class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        Delete Outcome
                    </button>
                    <div>
                        <a href="{{ route('outcomes.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded mr-2">
                            Cancel
                        </a>
                        <button type="submit"
                            class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Update Outcome
                        </button>
                    </div>
                </div>
            </form>

            <form id="delete-form" action="{{ route('outcomes.destroy', $outcome->OutcomeId) }}" method="POST" class="hidden">
                @csrf
                @method('DELETE')
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Toggle between file upload and URL input
    document.getElementById('artifact').addEventListener('change', function(e) {
        if (this.files.length > 0) {
            document.getElementById('ArtifactLink').value = '';
            document.getElementById('ArtifactLink').disabled = true;
        } else {
            document.getElementById('ArtifactLink').disabled = false;
        }
    });

    document.getElementById('ArtifactLink').addEventListener('input', function(e) {
        if (this.value) {
            document.getElementById('artifact').value = '';
            document.getElementById('artifact').disabled = true;
        } else {
            document.getElementById('artifact').disabled = false;
        }
    });
</script>
@endpush
@endsection
