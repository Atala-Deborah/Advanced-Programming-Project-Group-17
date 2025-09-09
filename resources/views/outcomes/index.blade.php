@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold">
                @if(isset($project))
                    Outcomes for {{ $project->Title }}
                @else
                    All Project Outcomes
                @endif
            </h1>
            @if(isset($project))
                <p class="text-sm text-gray-500 mt-1">
                    <a href="{{ route('projects.show', $project->ProjectId) }}" class="text-indigo-600 hover:text-indigo-900">
                        &larr; Back to project
                    </a>
                </p>
            @endif
        </div>
        <a href="{{ route('outcomes.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
            Add Outcome
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Project</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($outcomes as $outcome)
                    <tr>
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-gray-900">{{ $outcome->Title }}</div>
                            <div class="text-sm text-gray-500">{{ Str::limit($outcome->Description, 50) }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                @switch($outcome->OutcomeType)
                                    @case('CAD') bg-blue-100 text-blue-800 @break
                                    @case('PCB') bg-purple-100 text-purple-800 @break
                                    @case('Prototype') bg-yellow-100 text-yellow-800 @break
                                    @case('Report') bg-green-100 text-green-800 @break
                                    @case('Business Plan') bg-indigo-100 text-indigo-800 @break
                                    @default bg-gray-100 text-gray-800
                                @endswitch">
                                {{ $outcome->OutcomeType }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            {{ $outcome->project->Title ?? 'N/A' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                @switch($outcome->CommercializationStatus)
                                    @case('Demoed') bg-blue-100 text-blue-800 @break
                                    @case('Market Linked') bg-green-100 text-green-800 @break
                                    @case('Launched') bg-purple-100 text-purple-800 @break
                                    @default bg-gray-100 text-gray-800
                                @endswitch">
                                {{ $outcome->CommercializationStatus }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="{{ route('outcomes.show', $outcome->OutcomeId) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">View</a>
                            <a href="{{ route('outcomes.edit', $outcome->OutcomeId) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                            <form action="{{ route('outcomes.destroy', $outcome->OutcomeId) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900" 
                                    onclick="return confirm('Are you sure you want to delete this outcome?')">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                            @if(isset($project))
                                No outcomes found for this project.
                            @else
                                No outcomes found.
                            @endif
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $outcomes->links() }}
    </div>
</div>
@endsection
