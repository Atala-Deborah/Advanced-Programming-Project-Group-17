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
                <label class="block text-gray-700 text-sm font-bold mb-2" for="ProgramId">
                    Program <span class="text-red-500">*</span>
                </label>
                <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="ProgramId" name="ProgramId" required>
                    <option value="">Select Program</option>
                    @foreach($programs as $program)
                        <option value="{{ $program->ProgramId }}" {{ old('ProgramId') == $program->ProgramId ? 'selected' : '' }}>
                            {{ $program->Name }}
                        </option>
                    @endforeach
                </select>
                <p class="mt-1 text-xs text-gray-500">Every project must belong to a program</p>
            </div>
            
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="Title">
                    Project Title <span class="text-red-500">*</span>
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="Title" type="text" name="Title" value="{{ old('Title') }}" required>
                <p class="mt-1 text-xs text-gray-500">Must be unique within the program</p>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="Description">
                    Description <span class="text-red-500">*</span>
                </label>
                <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('Description') border-red-500 @enderror"
                    id="Description" name="Description" rows="3" required>{{ old('Description') }}</textarea>
                @error('Description')
                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="NatureOfProject">
                    Nature of Project <span class="text-red-500">*</span>
                </label>
                <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('NatureOfProject') border-red-500 @enderror"
                    id="NatureOfProject" name="NatureOfProject" required>
                    <option value="">Select Nature</option>
                    <option value="Research" {{ old('NatureOfProject') == 'Research' ? 'selected' : '' }}>Research</option>
                    <option value="Prototype" {{ old('NatureOfProject') == 'Prototype' ? 'selected' : '' }}>Prototype</option>
                    <option value="Applied work" {{ old('NatureOfProject') == 'Applied work' ? 'selected' : '' }}>Applied Work</option>
                </select>
                @error('NatureOfProject')
                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="Status">
                    Status <span class="text-red-500">*</span>
                    <span class="ml-1 text-gray-500 cursor-help" title="Completed projects must have at least one outcome documented">ⓘ</span>
                </label>
                <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('Status') border-red-500 @enderror"
                    id="Status" name="Status" required>
                    <option value="Planning" {{ old('Status') == 'Planning' ? 'selected' : '' }}>Planning</option>
                    <option value="Active" {{ old('Status') == 'Active' ? 'selected' : '' }}>Active</option>
                    <option value="Completed" {{ old('Status') == 'Completed' ? 'selected' : '' }}>Completed</option>
                    <option value="On Hold" {{ old('Status') == 'On Hold' ? 'selected' : '' }}>On Hold</option>
                </select>
                @error('Status')
                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="InnovationFocus">
                    Innovation Focus
                    <span class="ml-1 text-gray-500 cursor-help" title="Primary innovation area for this project">ⓘ</span>
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="InnovationFocus" type="text" name="InnovationFocus" value="{{ old('InnovationFocus') }}">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="PrototypeStage">
                    Prototype Stage <span class="text-red-500">*</span>
                </label>
                <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="PrototypeStage" name="PrototypeStage" required>
                    <option value="Concept" {{ old('PrototypeStage') == 'Concept' ? 'selected' : '' }}>Concept</option>
                    <option value="Prototype" {{ old('PrototypeStage') == 'Prototype' ? 'selected' : '' }}>Prototype</option>
                    <option value="MVP" {{ old('PrototypeStage') == 'MVP' ? 'selected' : '' }}>MVP (Minimum Viable Product)</option>
                    <option value="Market Launch" {{ old('PrototypeStage') == 'Market Launch' ? 'selected' : '' }}>Market Launch</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="FacilityId">
                    Facility <span class="text-red-500">*</span>
                    <span class="ml-1 text-gray-500 cursor-help" title="Ensure the facility's capabilities match your equipment needs">ⓘ</span>
                </label>
                <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('FacilityId') border-red-500 @enderror"
                    id="FacilityId" name="FacilityId" required>
                    <option value="">Select Facility</option>
                    @foreach($facilities as $facility)
                        <option value="{{ $facility->FacilityId }}" 
                            {{ (old('FacilityId') == $facility->FacilityId || (isset($selectedFacilityId) && $selectedFacilityId == $facility->FacilityId)) ? 'selected' : '' }}>
                            {{ $facility->Name }} - {{ $facility->Location }}
                        </option>
                    @endforeach
                </select>
                @error('FacilityId')
                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="StartDate">
                    Start Date <span class="text-red-500">*</span>
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('StartDate') border-red-500 @enderror"
                    id="StartDate" type="date" name="StartDate" value="{{ old('StartDate') }}" required>
                @error('StartDate')
                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="EndDate">
                    End Date
                    <span class="ml-1 text-gray-500 cursor-help" title="Must be after or equal to Start Date">ⓘ</span>
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('EndDate') border-red-500 @enderror"
                    id="EndDate" type="date" name="EndDate" value="{{ old('EndDate') }}">
                @error('EndDate')
                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="TestingRequirements">
                    Testing Requirements
                    <span class="ml-1 text-gray-500 cursor-help" title="Describe testing needs and methodologies">ⓘ</span>
                </label>
                <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="TestingRequirements" name="TestingRequirements" rows="2">{{ old('TestingRequirements') }}</textarea>
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="CommercializationPlan">
                    Commercialization Plan
                    <span class="ml-1 text-gray-500 cursor-help" title="Strategy for bringing project to market">ⓘ</span>
                </label>
                <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    id="CommercializationPlan" name="CommercializationPlan" rows="2">{{ old('CommercializationPlan') }}</textarea>
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
