@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold">Edit Project</h1>
            <a href="{{ route('projects.show', $project) }}" class="text-blue-500 hover:text-blue-700">Back to Project</a>
        </div>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('projects.update', $project) }}" method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            @csrf
            @method('PUT')
            
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="Name">
                    Project Name
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="Name" type="text" name="Name" value="{{ old('Name', $project->Name) }}" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="Description">
                    Description
                </label>
                <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                    id="Description" name="Description" rows="4" required>{{ old('Description', $project->Description) }}</textarea>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="Status">
                    Status
                </label>
                <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="Status" name="Status" required>
                    <option value="Planning" {{ old('Status', $project->Status) == 'Planning' ? 'selected' : '' }}>Planning</option>
                    <option value="Active" {{ old('Status', $project->Status) == 'Active' ? 'selected' : '' }}>Active</option>
                    <option value="Completed" {{ old('Status', $project->Status) == 'Completed' ? 'selected' : '' }}>Completed</option>
                    <option value="On Hold" {{ old('Status', $project->Status) == 'On Hold' ? 'selected' : '' }}>On Hold</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="FacilityId">
                    Facility
                </label>
                <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="FacilityId" name="FacilityId" required>
                    @foreach($facilities as $facility)
                        <option value="{{ $facility->FacilityId }}" {{ old('FacilityId', $project->FacilityId) == $facility->FacilityId ? 'selected' : '' }}>
                            {{ $facility->Name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="StartDate">
                    Start Date
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="StartDate" type="date" name="StartDate" value="{{ old('StartDate', $project->StartDate->format('Y-m-d')) }}" required>
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="EndDate">
                    End Date
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="EndDate" type="date" name="EndDate" value="{{ old('EndDate', $project->EndDate ? $project->EndDate->format('Y-m-d') : '') }}">
            </div>

            <div class="flex items-center justify-end">
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                    type="submit">
                    Update Project
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
