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
                <label for="Name" class="block text-sm font-medium text-gray-700">Name</label>
                <input type="text" name="Name" id="Name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                @error('Name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="Description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea name="Description" id="Description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
                @error('Description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="NationalAlignment" class="block text-sm font-medium text-gray-700">National Alignment</label>
                <select name="NationalAlignment" id="NationalAlignment" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">Select National Alignment</option>
                    <option value="NDPIII" {{ old('NationalAlignment') == 'NDPIII' ? 'selected' : '' }}>NDPIII</option>
                    <option value="Roadmap" {{ old('NationalAlignment') == 'Roadmap' ? 'selected' : '' }}>Roadmap</option>
                    <option value="4IR" {{ old('NationalAlignment') == '4IR' ? 'selected' : '' }}>4IR</option>
                </select>
                @error('NationalAlignment')
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
@endsection
