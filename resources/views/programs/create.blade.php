@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Create New Program</h1>
        <a href="{{ route('programs.index') }}" class="text-blue-600 hover:text-blue-800">
            Back to Programs
        </a>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <form action="{{ route('programs.store') }}" method="POST" class="p-6">
            @csrf
            
            <div class="mb-4">
                <label for="Name" class="block text-sm font-medium text-gray-700">
                    Name <span class="text-red-500">*</span>
                </label>
                <input type="text" name="Name" id="Name" value="{{ old('Name') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                <p class="mt-1 text-sm text-gray-500">Must be unique across all programs</p>
                @error('Name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="Description" class="block text-sm font-medium text-gray-700">
                    Description <span class="text-red-500">*</span>
                </label>
                <textarea name="Description" id="Description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>{{ old('Description') }}</textarea>
                @error('Description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="FocusAreas" class="block text-sm font-medium text-gray-700">Focus Areas</label>
                <select name="FocusAreas" id="FocusAreas" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">Select Focus Area</option>
                    <option value="IoT" {{ old('FocusAreas') == 'IoT' ? 'selected' : '' }}>IoT (Internet of Things)</option>
                    <option value="Automation" {{ old('FocusAreas') == 'Automation' ? 'selected' : '' }}>Automation</option>
                    <option value="Renewable Energy" {{ old('FocusAreas') == 'Renewable Energy' ? 'selected' : '' }}>Renewable Energy</option>
                    <option value="Biotechnology" {{ old('FocusAreas') == 'Biotechnology' ? 'selected' : '' }}>Biotechnology</option>
                    <option value="AI/ML" {{ old('FocusAreas') == 'AI/ML' ? 'selected' : '' }}>AI/ML (Artificial Intelligence/Machine Learning)</option>
                    <option value="Robotics" {{ old('FocusAreas') == 'Robotics' ? 'selected' : '' }}>Robotics</option>
                </select>
                @error('FocusAreas')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="NationalAlignment" class="block text-sm font-medium text-gray-700">
                    National Alignment <span class="text-red-500" id="alignment-required" style="display: none;">*</span>
                    <span class="ml-1 text-gray-500 cursor-help" title="Required when Focus Areas is specified. Must include at least one recognized alignment.">ⓘ</span>
                </label>
                <select name="NationalAlignment" id="NationalAlignment" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('NationalAlignment') border-red-500 @enderror">
                    <option value="">Select National Alignment</option>
                    <option value="NDPIII" {{ old('NationalAlignment') == 'NDPIII' ? 'selected' : '' }}>NDPIII (National Development Plan III)</option>
                    <option value="DigitalRoadmap2023_2028" {{ old('NationalAlignment') == 'DigitalRoadmap2023_2028' ? 'selected' : '' }}>Digital Roadmap 2023-2028</option>
                    <option value="4IR" {{ old('NationalAlignment') == '4IR' ? 'selected' : '' }}>4IR (Fourth Industrial Revolution)</option>
                    <option value="NDPIII, DigitalRoadmap2023_2028" {{ old('NationalAlignment') == 'NDPIII, DigitalRoadmap2023_2028' ? 'selected' : '' }}>NDPIII & Digital Roadmap</option>
                    <option value="NDPIII, 4IR" {{ old('NationalAlignment') == 'NDPIII, 4IR' ? 'selected' : '' }}>NDPIII & 4IR</option>
                    <option value="DigitalRoadmap2023_2028, 4IR" {{ old('NationalAlignment') == 'DigitalRoadmap2023_2028, 4IR' ? 'selected' : '' }}>Digital Roadmap & 4IR</option>
                    <option value="NDPIII, DigitalRoadmap2023_2028, 4IR" {{ old('NationalAlignment') == 'NDPIII, DigitalRoadmap2023_2028, 4IR' ? 'selected' : '' }}>All Three Alignments</option>
                </select>
                @error('NationalAlignment')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="Phases" class="block text-sm font-medium text-gray-700">Current Phase</label>
                <select name="Phases" id="Phases" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">Select Current Phase</option>
                    <option value="Cross-Skilling" {{ old('Phases') == 'Cross-Skilling' ? 'selected' : '' }}>Cross-Skilling</option>
                    <option value="Collaboration" {{ old('Phases') == 'Collaboration' ? 'selected' : '' }}>Collaboration</option>
                    <option value="Technical Skills" {{ old('Phases') == 'Technical Skills' ? 'selected' : '' }}>Technical Skills</option>
                    <option value="Prototyping" {{ old('Phases') == 'Prototyping' ? 'selected' : '' }}>Prototyping</option>
                    <option value="Commercialization" {{ old('Phases') == 'Commercialization' ? 'selected' : '' }}>Commercialization</option>
                </select>
                @error('Phases')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">
                    Create Program
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const focusAreasSelect = document.getElementById('FocusAreas');
    const alignmentInput = document.getElementById('NationalAlignment');
    const alignmentRequired = document.getElementById('alignment-required');
    
    function updateAlignmentRequirement() {
        if (focusAreasSelect.value) {
            alignmentInput.required = true;
            alignmentRequired.style.display = 'inline';
        } else {
            alignmentInput.required = false;
            alignmentRequired.style.display = 'none';
        }
    }
    
    focusAreasSelect.addEventListener('change', updateAlignmentRequirement);
    updateAlignmentRequirement(); // Initial check
});
</script>
@endsection
