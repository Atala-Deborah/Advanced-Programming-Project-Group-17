@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Projects</h1>
        <a href="{{ route('projects.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Create New Project
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 p  ➜  press h + enter to show helpx-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white shadow-md rounded my-6">
        <table class="min-w-full">
            <thead>
                <tr class="bg-gray-100">
                    <th class="py-3 px-6 text-left">Title</th>
                    <th class="py-3 px-6 text-left">Status</th>
                    <th class="py-3 px-6 text-left">Facility</th>
                    <th class="py-3 px-6 text-left">Start Date</th>
                    <th class="py-3 px-6 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($projects as $project)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-4 px-6">{{ $project->Title }}</td>
                        <td class="py-4 px-6">
                            <span class="px-2 py-1 rounded text-sm 
                                @if($project->Status === 'Active') bg-green-100 text-green-800
                                @elseif($project->Status === 'Planning') bg-blue-100 text-blue-800
                                @elseif($project->Status === 'Completed') bg-gray-100 text-gray-800
                                @else bg-yellow-100 text-yellow-800
                                @endif">
                                {{ $project->Status }}
                            </span>
                        </td>
                        <td class="py-4 px-6">{{ $project->facility->Name }}</td>
                        <td class="py-4 px-6">{{ $project->StartDate->format('Y-m-d') }}</td>
                        <td class="py-4 px-6">
                            <div class="flex space-x-2">
                                <a href="{{ route('projects.show', $project) }}" class="text-blue-600 hover:text-blue-900">View</a>
                                <a href="{{ route('projects.edit', $project) }}" class="text-green-600 hover:text-green-900">Edit</a>
                                <form action="{{ route('projects.destroy', $project) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <div class="mt-4">
        {{ $projects->links() }}
    </div>
</div>
@endsection
