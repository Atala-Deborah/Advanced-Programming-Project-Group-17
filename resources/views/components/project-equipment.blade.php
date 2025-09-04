@props(['project'])

<div class="mt-6">
    <h3 class="text-lg font-medium text-gray-900">Add Equipment</h3>
    <div class="mt-4">
        <form action="{{ route('projects.equipment.attach', $project) }}" method="POST" class="flex items-center space-x-4">
            @csrf
            <select name="equipment_id" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                @foreach(\App\Models\Equipment::where('FacilityId', $project->FacilityId)->get() as $equipment)
                    @if(!$project->equipment->contains($equipment))
                        <option value="{{ $equipment->EquipmentId }}">{{ $equipment->Name }}</option>
                    @endif
                @endforeach
            </select>
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white tracking-widest hover:bg-blue-700">
                Add Equipment
            </button>
        </form>
    </div>

    <div class="mt-6">
        <h4 class="text-md font-medium text-gray-900 mb-4">Current Equipment</h4>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @forelse($project->equipment as $equipment)
                <div class="bg-white p-4 rounded-lg shadow">
                    <div class="flex justify-between items-start">
                        <div>
                            <h5 class="text-lg font-semibold">{{ $equipment->Name }}</h5>
                            <p class="text-sm text-gray-600">{{ $equipment->Description }}</p>
                        </div>
                        <form action="{{ route('projects.equipment.detach', [$project, $equipment]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure?')">
                                Remove
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <p class="text-gray-500">No equipment assigned to this project.</p>
            @endforelse
        </div>
    </div>
</div>
