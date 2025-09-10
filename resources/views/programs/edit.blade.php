@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Edit Program</h1>
        <a href="{{ route('programs.index') }}" class="text-blue-600 hover:text-blue-800">
            Back to Programs
        </a>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <form action="{{ route('programs.update', $program->ProgramId) }}" method="POST" class="p-6">
            @csrf
            @method('PUT')
            
            <div class="mb-4">
                <label for="Name" class="block text-sm font-medium text-gray-700">Name</label>
                <input type="text" name="Name" id="Name" value="{{ old('Name', $program->Name) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                @error('Name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="Description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea name="Description" id="Description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('Description', $program->Description) }}</textarea>
                @error('Description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="NationalAlignment" class="block text-sm font-medium text-gray-700">National Alignment</label>
                <input type="text" name="NationalAlignment" id="NationalAlignment" value="{{ old('NationalAlignment', $program->NationalAlignment) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                @error('NationalAlignment')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="FocusAreas" class="block text-sm font-medium text-gray-700">Focus Areas</label>
                <input type="text" name="FocusAreas" id="FocusAreas" value="{{ old('FocusAreas', $program->FocusAreas) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                @error('FocusAreas')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="Phases" class="block text-sm font-medium text-gray-700">Phases (comma separated)</label>
                <input type="text" name="Phases" id="Phases" value="{{ old('Phases', is_array($program->Phases) ? implode(',', $program->Phases) : $program->Phases) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="e.g., Planning,Implementation,Evaluation">
                @error('Phases')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end space-x-3">
                <a href="{{ route('programs.index') }}" class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                    Cancel
                </a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">
                    Update Program
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
