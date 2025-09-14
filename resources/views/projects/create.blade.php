@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold">Create New Project</h1>
            <a href="{{ route('projects.index') }}" class="text-blue-500 hover:text-blue-700">Back to Projects</a>
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

        <form action="{{ route('projects.store') }}" method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="Title">
                    Project Title
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="Title" type="text" name="Title" value="{{ old('Title') }}" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="Description">
                    Description
                </label>
                <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                    id="Description" name="Description" rows="4" required>{{ old('Description') }}</textarea>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="Status">
                    Status
                </label>
                <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="Status" name="Status" required>
                    <option value="Planning" {{ old('Status') == 'Planning' ? 'selected' : '' }}>Planning</option>
                    <option value="Active" {{ old('Status') == 'Active' ? 'selected' : '' }}>Active</option>
                    <option value="Completed" {{ old('Status') == 'Completed' ? 'selected' : '' }}>Completed</option>
                    <option value="On Hold" {{ old('Status') == 'On Hold' ? 'selected' : '' }}>On Hold</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="NatureOfProject">
                    Nature of Project
                </label>
                <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="NatureOfProject" name="NatureOfProject" required>
                    <option value="Research" {{ old('NatureOfProject') == 'Research' ? 'selected' : '' }}>Research</option>
                    <option value="Prototype" {{ old('NatureOfProject') == 'Prototype' ? 'selected' : '' }}>Prototype</option>
                    <option value="Applied work" {{ old('NatureOfProject') == 'Applied work' ? 'selected' : '' }}>Applied Work</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="InnovationFocus">
                    Innovation Focus
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="InnovationFocus" type="text" name="InnovationFocus" value="{{ old('InnovationFocus') }}">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="PrototypeStage">
                    Prototype Stage
                </label>
                <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="PrototypeStage" name="PrototypeStage" required>
                    <option value="Concept" {{ old('PrototypeStage') == 'Concept' ? 'selected' : '' }}>Concept</option>
                    <option value="Prototype" {{ old('PrototypeStage') == 'Prototype' ? 'selected' : '' }}>Prototype</option>
                    <option value="MVP" {{ old('PrototypeStage') == 'MVP' ? 'selected' : '' }}>MVP</option>
                    <option value="Market Launch" {{ old('PrototypeStage') == 'Market Launch' ? 'selected' : '' }}>Market Launch</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="FacilityId">
                    Facility
                </label>
                <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="FacilityId" name="FacilityId" required>
                    @foreach($facilities as $facility)
                        <option value="{{ $facility->FacilityId }}" 
                            {{ (old('FacilityId') == $facility->FacilityId || (isset($selectedFacilityId) && $selectedFacilityId == $facility->FacilityId)) ? 'selected' : '' }}>
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
                    id="StartDate" type="date" name="StartDate" value="{{ old('StartDate') }}" required>
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="EndDate">
                    End Date
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="EndDate" type="date" name="EndDate" value="{{ old('EndDate') }}">
            </div>

            <div class="flex items-center justify-end">
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                    type="submit">
                    Create Project
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
