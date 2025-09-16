@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold">Manage Project Participants</h1>
            <p class="text-gray-600">{{ $project->Title }}</p>
        </div>
        <div class="space-x-2">
            <a href="{{ route('projects.show', $project->ProjectId) }}"
               class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded">
                Back to Project
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Current Participants -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-medium text-gray-900">Current Participants ({{ $project->participants->count() }})</h2>
            </div>
            <div class="divide-y divide-gray-200">
                @forelse($project->participants as $participant)
                    <div class="px-6 py-4">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <div class="flex items-center space-x-3">
                                    <div class="flex-shrink-0">
                                        <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center">
                                            <span class="text-sm font-medium text-indigo-700">
                                                {{ substr($participant->FullName, 0, 2) }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm font-medium text-gray-900">{{ $participant->FullName }}</p>
                                        <p class="text-sm text-gray-500">{{ $participant->Email }}</p>
                                        <div class="flex flex-wrap gap-1 mt-1">
                                            <span class="px-2 py-1 text-xs font-medium bg-purple-100 text-purple-800 rounded-full">
                                                {{ $participant->pivot->RoleOnProject }}
                                            </span>
                                            <span class="px-2 py-1 text-xs font-medium bg-orange-100 text-orange-800 rounded-full">
                                                {{ $participant->pivot->SkillRole }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex-shrink-0 flex items-center space-x-2">
                                <a href="{{ route('participants.show', $participant->ParticipantId) }}" 
                                   class="text-indigo-600 hover:text-indigo-900 text-sm">View</a>
                                <form id="remove-participant-{{ $participant->ParticipantId }}" 
                                      action="{{ route('project.participants.destroy', [$project->ProjectId, $participant->ParticipantId]) }}" 
                                      method="POST" class="hidden">
                                    @csrf
                                    @method('DELETE')
                                </form>
                                <button onclick="removeParticipant({{ $participant->ParticipantId }}, '{{ $participant->FullName }}')" 
                                        class="text-red-600 hover:text-red-900 text-sm">
                                    Remove
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="px-6 py-8 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No participants assigned</h3>
                        <p class="mt-1 text-sm text-gray-500">Start by adding participants to this project.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Add New Participant -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-medium text-gray-900">Add New Participant</h2>
            </div>
            <div class="p-6">
                @if($participants->count() > 0)
                    <form action="{{ route('project.participants.store', $project->ProjectId) }}" method="POST">
                        @csrf
                        <div class="space-y-4">
                            <div>
                                <label for="ParticipantId" class="block text-sm font-medium text-gray-700">Select Participant</label>
                                <select name="ParticipantId" id="ParticipantId" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Choose a participant...</option>
                                    @foreach($participants as $participant)
                                        <option value="{{ $participant->ParticipantId }}">
                                            {{ $participant->FullName }} ({{ $participant->Institution }} - {{ $participant->Specialization }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('ParticipantId')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="RoleOnProject" class="block text-sm font-medium text-gray-700">Role on Project</label>
                                <select name="RoleOnProject" id="RoleOnProject" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Select role...</option>
                                    <option value="Student">Student</option>
                                    <option value="Lecturer">Lecturer</option>
                                    <option value="Contributor">Contributor</option>
                                </select>
                                @error('RoleOnProject')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="SkillRole" class="block text-sm font-medium text-gray-700">Skill Role</label>
                                <select name="SkillRole" id="SkillRole" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Select skill role...</option>
                                    <option value="Developer">Developer</option>
                                    <option value="Engineer">Engineer</option>
                                    <option value="Designer">Designer</option>
                                    <option value="Business Lead">Business Lead</option>
                                </select>
                                @error('SkillRole')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="pt-4">
                                <button type="submit"
                                        class="w-full inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Add Participant to Project
                                </button>
                            </div>
                        </div>
                    </form>
                @else
                    <div class="text-center py-8">
                        <svg class="mx-auto h-12 w-12 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">All participants already assigned</h3>
                        <p class="mt-1 text-sm text-gray-500">All available participants are already part of this project.</p>
                        <div class="mt-4">
                            <a href="{{ route('participants.create') }}" 
                               class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                                Create New Participant
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Project Summary -->
    <div class="mt-8 bg-gray-50 rounded-lg p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Project Summary</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="text-center">
                <div class="text-2xl font-bold text-indigo-600">{{ $project->participants->count() }}</div>
                <div class="text-sm text-gray-500">Total Participants</div>
            </div>
            <div class="text-center">
                <div class="text-2xl font-bold text-green-600">{{ $project->participants->where('pivot.RoleOnProject', 'Project Lead')->count() }}</div>
                <div class="text-sm text-gray-500">Project Leads</div>
            </div>
            <div class="text-center">
                <div class="text-2xl font-bold text-purple-600">{{ $project->participants->where('pivot.RoleOnProject', 'Team Member')->count() }}</div>
                <div class="text-sm text-gray-500">Team Members</div>
            </div>
            <div class="text-center">
                <div class="text-2xl font-bold text-orange-600">{{ $participants->count() }}</div>
                <div class="text-sm text-gray-500">Available to Add</div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Auto-suggest skill role based on participant selection
    document.getElementById('ParticipantId').addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const participantText = selectedOption.text;
        const skillRoleSelect = document.getElementById('SkillRole');
        
        if (participantText.includes('Software')) {
            skillRoleSelect.value = 'Developer';
        } else if (participantText.includes('Hardware')) {
            skillRoleSelect.value = 'Engineer';
        } else if (participantText.includes('Business')) {
            skillRoleSelect.value = 'Business Lead';
        } else if (participantText.includes('Design') || participantText.includes('UI')) {
            skillRoleSelect.value = 'Designer';
        }
    });

    // Remove participant function
    function removeParticipant(participantId, participantName) {
        const form = document.getElementById(`remove-participant-${participantId}`);
        
        confirmDelete({
            title: 'Remove Participant',
            message: `Are you sure you want to remove "${participantName}" from this project?`,
            form: form
        });
    }
</script>
@endpush