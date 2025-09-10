@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Edit Participant</h1>
        <a href="{{ route('participants.index') }}" class="text-gray-600 hover:text-gray-800">
            Back to Participants
        </a>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="p-6">
            <form action="{{ route('participants.update', $participant->ParticipantId) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="col-span-2">
                        <label for="FullName" class="block text-sm font-medium text-gray-700">Full Name *</label>
                        <input type="text" name="FullName" id="FullName" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            value="{{ old('FullName', $participant->FullName) }}">
                        @error('FullName')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="Email" class="block text-sm font-medium text-gray-700">Email *</label>
                        <input type="email" name="Email" id="Email" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            value="{{ old('Email', $participant->Email) }}">
                        @error('Email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="Institution" class="block text-sm font-medium text-gray-700">Institution *</label>
                        <select name="Institution" id="Institution" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Select Institution</option>
                            <option value="SCIT" {{ old('Institution', $participant->Institution) == 'SCIT' ? 'selected' : '' }}>SCIT</option>
                            <option value="CEDAT" {{ old('Institution', $participant->Institution) == 'CEDAT' ? 'selected' : '' }}>CEDAT</option>
                            <option value="UniPod" {{ old('Institution', $participant->Institution) == 'UniPod' ? 'selected' : '' }}>UniPod</option>
                            <option value="UIRI" {{ old('Institution', $participant->Institution) == 'UIRI' ? 'selected' : '' }}>UIRI</option>
                            <option value="Lwera" {{ old('Institution', $participant->Institution) == 'Lwera' ? 'selected' : '' }}>Lwera</option>
                            <option value="Other" {{ old('Institution', $participant->Institution) == 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('Institution')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="Affiliation" class="block text-sm font-medium text-gray-700">Affiliation *</label>
                        <select name="Affiliation" id="Affiliation" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Select Affiliation</option>
                            <option value="CS" {{ old('Affiliation', $participant->Affiliation) == 'CS' ? 'selected' : '' }}>CS</option>
                            <option value="SE" {{ old('Affiliation', $participant->Affiliation) == 'SE' ? 'selected' : '' }}>SE</option>
                            <option value="Engineering" {{ old('Affiliation', $participant->Affiliation) == 'Engineering' ? 'selected' : '' }}>Engineering</option>
                            <option value="Other" {{ old('Affiliation', $participant->Affiliation) == 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('Affiliation')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="Specialization" class="block text-sm font-medium text-gray-700">Specialization *</label>
                        <select name="Specialization" id="Specialization" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Select Specialization</option>
                            <option value="Software" {{ old('Specialization', $participant->Specialization) == 'Software' ? 'selected' : '' }}>Software</option>
                            <option value="Hardware" {{ old('Specialization', $participant->Specialization) == 'Hardware' ? 'selected' : '' }}>Hardware</option>
                            <option value="Business" {{ old('Specialization', $participant->Specialization) == 'Business' ? 'selected' : '' }}>Business</option>
                        </select>
                        @error('Specialization')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center">
                        <div class="flex items-center h-5">
                            <input id="CrossSkillTrained" name="CrossSkillTrained" type="checkbox"
                                class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                                {{ old('CrossSkillTrained', $participant->CrossSkillTrained) ? 'checked' : '' }}>
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="CrossSkillTrained" class="font-medium text-gray-700">Cross-Skill Trained</label>
                            <p class="text-gray-500">Check if the participant has cross-skill training</p>
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex justify-end">
                    <button type="submit"
                        class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Update Participant
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
