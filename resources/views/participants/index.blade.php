@extends('layouts.app')

@section('content')
<div class="bg-white shadow rounded-lg overflow-hidden">
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-[#070600] to-blue-800 text-white px-4 py-8 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div class="flex-1">
                    <h1 class="text-2xl font-bold">Participants</h1>
                    <p class="mt-2 text-blue-100">Browse and manage all participants across projects</p>
                </div>
                <div class="mt-4 md:mt-0">
                    <a href="{{ route('participants.create') }}" 
                       class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-blue-700 bg-white hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                        Add Participant
                    </a>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="max-w-7xl mx-auto px-4 py-3">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="max-w-7xl mx-auto px-4 py-3">
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        </div>
    @endif

    <!-- Search and Filter Section -->
    <div class="px-4 py-5 sm:p-6 border-b border-gray-200">
        <form method="GET" action="{{ route('participants.index') }}" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                <!-- Search -->
                <div class="lg:col-span-2">
                    <label for="search" class="block text-sm font-medium text-gray-700">Search</label>
                    <input type="text" name="search" id="search" value="{{ request('search') }}" 
                           placeholder="Search by name or email..."
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>

                <!-- Institution Filter -->
                <div>
                    <label for="institution" class="block text-sm font-medium text-gray-700">Institution</label>
                    <select name="institution" id="institution" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">All Institutions</option>
                        @foreach($institutions as $institution)
                            <option value="{{ $institution }}" {{ request('institution') == $institution ? 'selected' : '' }}>
                                {{ $institution }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Specialization Filter -->
                <div>
                    <label for="specialization" class="block text-sm font-medium text-gray-700">Specialization</label>
                    <select name="specialization" id="specialization" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">All Specializations</option>
                        @foreach($specializations as $specialization)
                            <option value="{{ $specialization }}" {{ request('specialization') == $specialization ? 'selected' : '' }}>
                                {{ $specialization }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Affiliation Filter -->
                <div>
                    <label for="affiliation" class="block text-sm font-medium text-gray-700">Affiliation</label>
                    <select name="affiliation" id="affiliation" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">All Affiliations</option>
                        @foreach($affiliations as $affiliation)
                            <option value="{{ $affiliation }}" {{ request('affiliation') == $affiliation ? 'selected' : '' }}>
                                {{ $affiliation }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row gap-4 items-start sm:items-center">
                <!-- Cross-Skill Trained Filter -->
                <div>
                    <label for="cross_skill" class="block text-sm font-medium text-gray-700">Cross-Skill Status</label>
                    <select name="cross_skill" id="cross_skill" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">All Statuses</option>
                        <option value="1" {{ request('cross_skill') == '1' ? 'selected' : '' }}>Cross-Skill Trained</option>
                        <option value="0" {{ request('cross_skill') == '0' ? 'selected' : '' }}>Not Cross-Skill Trained</option>
                    </select>
                </div>

                <!-- Action Buttons -->
                <div class="flex space-x-2 mt-6 sm:mt-0">
                    <button type="submit" 
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <svg class="-ml-1 mr-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        Filter
                    </button>
                    <a href="{{ route('participants.index') }}" 
                       class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Clear
                    </a>
                </div>
            </div>
        </form>
    </div>

    <div class="px-4 py-5 sm:p-6">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Institution</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Affiliation</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Specialization</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Projects</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($participants as $participant)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div>
                                    <div class="text-sm font-medium text-gray-900">{{ $participant->FullName }}</div>
                                    @if($participant->CrossSkillTrained)
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Cross-Skill Trained
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $participant->Email }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                {{ $participant->Institution }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $participant->Affiliation }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">
                                {{ $participant->Specialization }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                {{ $participant->projects->count() }} project(s)
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                <a href="{{ route('participants.show', $participant->ParticipantId) }}" 
                                   class="text-green-600 hover:text-green-900">View Profile</a>
                                <a href="{{ route('participants.edit', $participant->ParticipantId) }}" 
                                   class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                <form id="delete-participant-{{ $participant->ParticipantId }}" 
                                      action="{{ route('participants.destroy', $participant->ParticipantId) }}" 
                                      method="POST" class="hidden">
                                    @csrf
                                    @method('DELETE')
                                </form>
                                <button onclick="deleteParticipant({{ $participant->ParticipantId }}, {{ json_encode($participant->FullName) }})" 
                                        class="text-red-600 hover:text-red-900">
                                    Delete
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">
                            @if(request()->hasAny(['search', 'institution', 'specialization', 'affiliation', 'cross_skill']))
                                No participants found matching your search criteria.
                            @else
                                No participants found.
                            @endif
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $participants->links() }}
    </div>
</div>

@push('scripts')
<script>
    // Participants use the universal delete function
    console.log('Participants index script loaded');
</script>
@endpush

@endsection
