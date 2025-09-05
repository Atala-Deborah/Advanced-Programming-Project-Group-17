@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            <h2 class="text-2xl font-bold mb-6">Delete Facility: {{ $facility->Name }}</h2>

            @if($facility->projects->count() > 0)
                <div class="mb-6">
                    <p class="text-red-600 font-semibold mb-2">Warning: This facility has {{ $facility->projects->count() }} associated project(s).</p>
                    <p class="mb-4">Please choose how to handle these projects:</p>

                    <form action="{{ route('facilities.destroy', $facility) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('DELETE')

                        <div class="bg-gray-50 p-4 rounded">
                            <div class="mb-4">
                                <label class="inline-flex items-center">
                                    <input type="radio" name="deletion_type" value="reassign" class="form-radio" checked>
                                    <span class="ml-2">Reassign projects to another facility</span>
                                </label>
                            </div>

                            <div class="ml-6" id="reassignmentOptions">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="new_facility">
                                    Select New Facility
                                </label>
                                <select name="new_facility_id" id="new_facility" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                    @foreach($otherFacilities as $otherFacility)
                                        <option value="{{ $otherFacility->FacilityId }}">
                                            {{ $otherFacility->Name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mt-4">
                                <label class="inline-flex items-center">
                                    <input type="radio" name="deletion_type" value="delete_all" class="form-radio">
                                    <span class="ml-2">Delete facility and all associated projects</span>
                                </label>
                            </div>
                        </div>

                        <div class="flex items-center justify-end space-x-4">
                            <a href="{{ route('facilities.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Cancel
                            </a>
                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Confirm Delete
                            </button>
                        </div>
                    </form>
                </div>
            @else
                <div class="mb-6">
                    <p class="mb-4">Are you sure you want to delete this facility? This will also delete all associated services and equipment.</p>
                    
                    <form action="{{ route('facilities.destroy', $facility) }}" method="POST" class="flex items-center justify-end space-x-4">
                        @csrf
                        @method('DELETE')
                        <a href="{{ route('facilities.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Cancel
                        </a>
                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Confirm Delete
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
