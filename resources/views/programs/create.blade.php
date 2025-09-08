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
                <input type="text" name="NationalAlignment" id="NationalAlignment" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                @error('NationalAlignment')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="FocusAreas" class="block text-sm font-medium text-gray-700">Focus Areas</label>
                <input type="text" name="FocusAreas" id="FocusAreas" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                @error('FocusAreas')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="Phases" class="block text-sm font-medium text-gray-700">Phases (comma separated)</label>
                <input type="text" name="Phases" id="Phases" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="e.g., Planning,Implementation,Evaluation">
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
