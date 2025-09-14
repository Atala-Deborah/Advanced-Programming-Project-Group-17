@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Add New Outcome</h1>
        <a href="{{ route('outcomes.index') }}" class="text-gray-600 hover:text-gray-800">
            Back to Outcomes
        </a>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="p-6">
            <form action="{{ route('outcomes.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="grid grid-cols-1 gap-6">
                    <div>
                        <label for="ProjectId" class="block text-sm font-medium text-gray-700">Project *</label>
                        <select name="ProjectId" id="ProjectId" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Select a project</option>
                            @foreach($projects as $project)
                                <option value="{{ $project->ProjectId }}" {{ old('ProjectId') == $project->ProjectId ? 'selected' : '' }}>
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
                            value="{{ old('Title') }}">
                        @error('Title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="Description" class="block text-sm font-medium text-gray-700">Description *</label>
                        <textarea name="Description" id="Description" rows="3" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('Description') }}</textarea>
                        @error('Description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="OutcomeType" class="block text-sm font-medium text-gray-700">Outcome Type *</label>
                            <select name="OutcomeType" id="OutcomeType" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Select type</option>
                                <option value="CAD" {{ old('OutcomeType') == 'CAD' ? 'selected' : '' }}>CAD Design</option>
                                <option value="PCB" {{ old('OutcomeType') == 'PCB' ? 'selected' : '' }}>PCB Design</option>
                                <option value="Prototype" {{ old('OutcomeType') == 'Prototype' ? 'selected' : '' }}>Prototype</option>
                                <option value="Report" {{ old('OutcomeType') == 'Report' ? 'selected' : '' }}>Report</option>
                                <option value="Business Plan" {{ old('OutcomeType') == 'Business Plan' ? 'selected' : '' }}>Business Plan</option>
                            </select>
                            @error('OutcomeType')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="CommercializationStatus" class="block text-sm font-medium text-gray-700">Commercialization Status *</label>
                            <select name="CommercializationStatus" id="CommercializationStatus" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Select status</option>
                                <option value="Demoed" {{ old('CommercializationStatus') == 'Demoed' ? 'selected' : '' }}>Demoed</option>
                                <option value="Market Linked" {{ old('CommercializationStatus') == 'Market Linked' ? 'selected' : '' }}>Market Linked</option>
                                <option value="Launched" {{ old('CommercializationStatus') == 'Launched' ? 'selected' : '' }}>Launched</option>
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
                            value="{{ old('QualityCertification') }}">
                        @error('QualityCertification')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="artifact" class="block text-sm font-medium text-gray-700">Artifact File</label>
                        <input type="file" name="artifact" id="artifact"
                            class="mt-1 block w-full text-sm text-gray-500
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-md file:border-0
                                file:text-sm file:font-semibold
                                file:bg-indigo-50 file:text-indigo-700
                                hover:file:bg-indigo-100">
                        <p class="mt-1 text-xs text-gray-500">Upload any related files (max: 10MB)</p>
                        @error('artifact')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="ArtifactLink" class="block text-sm font-medium text-gray-700">Or Artifact URL</label>
                        <input type="url" name="ArtifactLink" id="ArtifactLink"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            placeholder="https://example.com/artifact"
                            value="{{ old('ArtifactLink') }}">
                        <p class="mt-1 text-xs text-gray-500">Provide a URL if the artifact is hosted online</p>
                        @error('ArtifactLink')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-6 flex justify-end">
                    <button type="submit"
                        class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Save Outcome
                    </button>
                </div>
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
