@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold">{{ $project->Title }}</h1>
            <div class="space-x-2">
                <a href="{{ route('projects.edit', $project) }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Edit Project</a>
                <a href="{{ route('projects.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Back to Projects</a>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        @if(session('warning'))
            <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded mb-4">
                <strong>⚠️ Warning:</strong> {{ session('warning') }}
            </div>
        @endif

        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="p-6">
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <h2 class="text-xl font-semibold mb-4">Project Details</h2>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-gray-600 text-sm">Status</label>
                                <span class="px-2 py-1 rounded text-sm inline-block mt-1
                                    @if($project->Status === 'Active') bg-green-100 text-green-800
                                    @elseif($project->Status === 'Planning') bg-blue-100 text-blue-800
                                    @elseif($project->Status === 'Completed') bg-gray-100 text-gray-800
                                    @else bg-yellow-100 text-yellow-800
                                    @endif">
                                    {{ $project->Status }}
                                </span>
                            </div>
                            <div>
                                <label class="block text-gray-600 text-sm">Facility</label>
                                <p class="text-gray-800">{{ $project->facility->Name }}</p>
                            </div>
                            <div>
                                <label class="block text-gray-600 text-sm">Start Date</label>
                                <p class="text-gray-800">{{ $project->StartDate->format('Y-m-d') }}</p>
                            </div>
                            <div>
                                <label class="block text-gray-600 text-sm">End Date</label>
                                <p class="text-gray-800">{{ $project->EndDate ? $project->EndDate->format('Y-m-d') : 'Not set' }}</p>
                            </div>
                        </div>
                    </div>
                    <div>
                        <h2 class="text-xl font-semibold mb-4">Description</h2>
                        <p class="text-gray-800 whitespace-pre-line">{{ $project->Description }}</p>
                    </div>
                </div>

                <div class="mt-8">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-semibold">Equipment ({{ $project->equipment->count() }})</h2>
                        <a href="{{ route('project.equipment.manage', $project->ProjectId) }}"
                           class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            Manage Equipment
                        </a>
                    </div>
                    @if($project->equipment->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($project->equipment as $equipment)
                                <div class="border rounded p-4">
                                    <h3 class="font-semibold">{{ $equipment->Name }}</h3>
                                    <p class="text-sm text-gray-600">{{ $equipment->Description }}</p>
                                    <div class="mt-2">
                                        <span class="px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full">
                                            {{ $equipment->Type }}
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="bg-gray-50 rounded-lg p-8 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No equipment assigned</h3>
                            <p class="mt-1 text-sm text-gray-500">Get started by adding equipment to this project.</p>
                        </div>
                    @endif
                </div>

                <div class="mt-8">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-semibold">Project Participants ({{ $project->participants->count() }})</h2>
                        <a href="{{ route('project.participants.manage', $project->ProjectId) }}"
                           class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4" />
                            </svg>
                            Manage Participants
                        </a>
                    </div>
                    @if($project->participants->count() > 0)
                        <div class="grid gap-4">
                            @foreach($project->participants as $participant)
                                <div class="bg-gray-50 rounded-lg p-4 flex items-center justify-between">
                                    <div class="flex items-center space-x-4">
                                        <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center">
                                            <span class="text-sm font-medium text-indigo-700">
                                                {{ substr($participant->FullName, 0, 2) }}
                                            </span>
                                        </div>
                                        <div>
                                            <div class="font-medium text-gray-900">{{ $participant->FullName }}</div>
                                            <div class="text-sm text-gray-500">{{ $participant->Email }}</div>
                                            <div class="flex gap-2 mt-1">
                                                <span class="px-2 py-1 text-xs font-medium bg-purple-100 text-purple-800 rounded-full">
                                                    {{ $participant->pivot->RoleOnProject }}
                                                </span>
                                                <span class="px-2 py-1 text-xs font-medium bg-orange-100 text-orange-800 rounded-full">
                                                    {{ $participant->pivot->SkillRole }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('participants.show', $participant->ParticipantId) }}" 
                                           class="text-indigo-600 hover:text-indigo-900 text-sm">View Profile</a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="bg-gray-50 rounded-lg p-8 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No participants assigned</h3>
                            <p class="mt-1 text-sm text-gray-500">Get started by adding participants to this project.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
