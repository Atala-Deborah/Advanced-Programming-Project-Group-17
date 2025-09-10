@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold">{{ $participant->FullName }}</h1>
            <p class="text-gray-600">Participant Details</p>
        </div>
        <div class="space-x-2">
            <a href="{{ route('participants.edit', $participant->ParticipantId) }}"
               class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded">
                Edit
            </a>
            <a href="{{ route('participants.index') }}"
               class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded">
                Back to List
            </a>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-200">
            <h2 class="text-lg font-medium text-gray-900">Personal Information</h2>
        </div>
        <div class="px-6 py-5">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Full Name</h3>
                    <p class="mt-1 text-sm text-gray-900">{{ $participant->FullName }}</p>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Email</h3>
                    <p class="mt-1 text-sm text-gray-900">{{ $participant->Email }}</p>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Institution</h3>
                    <p class="mt-1 text-sm text-gray-900">{{ $participant->Institution }}</p>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Affiliation</h3>
                    <p class="mt-1 text-sm text-gray-900">{{ $participant->Affiliation }}</p>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Specialization</h3>
                    <p class="mt-1 text-sm text-gray-900">{{ $participant->Specialization }}</p>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Cross-Skill Trained</h3>
                    <p class="mt-1">
                        @if($participant->CrossSkillTrained)
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                Yes
                            </span>
                        @else
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                No
                            </span>
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Projects Section -->
    <div class="mt-8">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold">Projects</h2>
        </div>

        @if($participant->projects->count() > 0)
            <div class="bg-white shadow overflow-hidden sm:rounded-md">
                <ul class="divide-y divide-gray-200">
                    @foreach($participant->projects as $project)
                        <li>
                            <div class="px-4 py-4 sm:px-6">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <a href="{{ route('projects.show', $project->ProjectId) }}" class="text-indigo-600 hover:text-indigo-900 font-medium">
                                            {{ $project->Title }}
                                        </a>
                                        <p class="mt-1 text-sm text-gray-500">
                                            {{ $project->pivot->RoleOnProject }} - {{ $project->pivot->SkillRole }}
                                        </p>
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        {{ $project->StartDate->format('M d, Y') }} - {{ $project->EndDate?->format('M d, Y') ?? 'Present' }}
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        @else
            <div class="bg-white shadow overflow-hidden sm:rounded-md p-6 text-center">
                <p class="text-gray-500">This participant is not associated with any projects yet.</p>
            </div>
        @endif
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="hidden fixed z-10 inset-0 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
            <div>
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                    <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <div class="mt-3 text-center sm:mt-5">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Delete Participant</h3>
                    <div class="mt-2">
                        <p class="text-sm text-gray-500">
                            Are you sure you want to delete this participant? This action cannot be undone.
                        </p>
                    </div>
                </div>
            </div>
            <div class="mt-5 sm:mt-6 sm:grid sm:grid-cols-2 sm:gap-3 sm:grid-flow-row-dense">
                <form action="{{ route('participants.destroy', $participant->ParticipantId) }}" method="POST" class="inline-block w-full">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:col-start-2 sm:text-sm">
                        Delete
                    </button>
                </form>
                <button type="button" onclick="document.getElementById('deleteModal').classList.add('hidden')" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:col-start-1 sm:text-sm">
                    Cancel
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function showDeleteModal() {
        document.getElementById('deleteModal').classList.remove('hidden');
    }
</script>
@endpush
@endsection
