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
                    <h2 class="text-xl font-semibold mb-4">Equipment</h2>
                    @if($project->equipment->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($project->equipment as $equipment)
                                <div class="border rounded p-4">
                                    <h3 class="font-semibold">{{ $equipment->Name }}</h3>
                                    <p class="text-sm text-gray-600">{{ $equipment->Description }}</p>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-600">No equipment assigned to this project.</p>
                    @endif
                </div>

                <div class="mt-8">
                    <h2 class="text-xl font-semibold mb-4">Project Participants</h2>
                    @if($project->participants->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full">
                                <thead>
                                    <tr class="bg-gray-100">
                                        <th class="py-3 px-6 text-left">Name</th>
                                        <th class="py-3 px-6 text-left">Role</th>
                                        <th class="py-3 px-6 text-left">Joined Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($project->participants as $participant)
                                        <tr class="border-b">
                                            <td class="py-4 px-6">{{ $participant->name }}</td>
                                            <td class="py-4 px-6">{{ $participant->pivot->role }}</td>
                                            <td class="py-4 px-6">{{ $participant->pivot->created_at->format('Y-m-d') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-gray-600">No participants assigned to this project.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
