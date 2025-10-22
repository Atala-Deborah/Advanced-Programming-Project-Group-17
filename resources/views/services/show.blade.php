@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-6">
    <div class="bg-white shadow overflow-hidden rounded-lg">
        <div class="px-4 py-5 border-b border-gray-200 sm:px-6">
            <div class="flex justify-between items-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    Service Details
                </h3>
                <div class="flex space-x-3">
                    <a href="{{ route('services.edit', $service) }}" 
                       class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Edit
                    </a>
                    <form action="{{ route('services.destroy', $service) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                onclick="return confirm('Are you sure you want to delete this service?')"
                                class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            Delete
                        </button>
                    </form>
                    <a href="{{ route('services.index') }}" 
                       class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Back to List
                    </a>
                </div>
            </div>
        </div>

        <div class="px-4 py-5 sm:p-6">
            <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
                <div class="sm:col-span-2">
                    <dt class="text-sm font-medium text-gray-500">Service Name</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $service->Name }}</dd>
                </div>

                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500">Category</dt>
                    <dd class="mt-1 text-sm text-gray-900">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                            {{ $service->Category === 'Machining' ? 'bg-blue-100 text-blue-800' : '' }}
                            {{ $service->Category === 'Testing' ? 'bg-green-100 text-green-800' : '' }}
                            {{ $service->Category === 'Training' ? 'bg-purple-100 text-purple-800' : '' }}">
                            {{ $service->Category }}
                        </span>
                    </dd>
                </div>

                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500">Skill Type</dt>
                    <dd class="mt-1 text-sm text-gray-900">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                            {{ $service->SkillType === 'Hardware' ? 'bg-orange-100 text-orange-800' : '' }}
                            {{ $service->SkillType === 'Software' ? 'bg-indigo-100 text-indigo-800' : '' }}
                            {{ $service->SkillType === 'Integration' ? 'bg-pink-100 text-pink-800' : '' }}">
                            {{ $service->SkillType }}
                        </span>
                    </dd>
                </div>

                <div class="sm:col-span-2">
                    <dt class="text-sm font-medium text-gray-500">Facility</dt>
                    <dd class="mt-1 text-sm text-gray-900">
                        <a href="{{ route('facilities.show', $service->facility) }}" 
                           class="text-blue-600 hover:text-blue-800 font-medium">
                            {{ $service->facility->Name }}
                        </a>
                        <span class="text-gray-500 ml-2">- {{ $service->facility->Location }}</span>
                    </dd>
                </div>

                <div class="sm:col-span-2">
                    <dt class="text-sm font-medium text-gray-500">Description</dt>
                    <dd class="mt-1 text-sm text-gray-900">
                        {{ $service->Description ?? 'No description provided' }}
                    </dd>
                </div>

                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500">Created At</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $service->created_at->format('M d, Y') }}</dd>
                </div>

                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $service->updated_at->format('M d, Y') }}</dd>
                </div>
            </dl>
        </div>
    </div>

    <!-- Related Information -->
    <div class="mt-6 bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Quick Links</h3>
            
            <div class="space-y-3">
                <a href="{{ route('facilities.show', $service->facility) }}" 
                   class="block w-full px-4 py-3 border border-gray-300 rounded-md hover:bg-gray-50 transition-colors">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-900">View Facility Details</span>
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </div>
                    <p class="mt-1 text-sm text-gray-500">{{ $service->facility->Name }}</p>
                </a>

                <a href="{{ route('services.index', ['facility' => $service->FacilityId]) }}" 
                   class="block w-full px-4 py-3 border border-gray-300 rounded-md hover:bg-gray-50 transition-colors">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-900">View All Services at This Facility</span>
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
