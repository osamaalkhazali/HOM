@extends('layouts.admin.app')

@section('title', 'Job Details')

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900">Job Details</h1>
                <p class="mt-1 text-sm text-gray-600">View complete job information and manage applications</p>
            </div>
            <div class="flex space-x-3">
                <form method="POST" action="{{ route('admin.jobs.toggle-status', $job) }}" class="inline">
                    @csrf
                    @method('PATCH')
                    <button type="submit"
                        class="px-4 py-2 rounded-lg font-medium transition-colors
                        {{ $job->is_active ? 'bg-red-600 hover:bg-red-700 text-white' : 'bg-green-600 hover:bg-green-700 text-white' }}">
                        <i class="fas fa-toggle-{{ $job->is_active ? 'off' : 'on' }} mr-2"></i>
                        {{ $job->is_active ? 'Deactivate' : 'Activate' }}
                    </button>
                </form>
                <a href="{{ route('admin.jobs.edit', $job) }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors">
                    <i class="fas fa-edit mr-2"></i>Edit Job
                </a>
                <a href="{{ route('admin.jobs.index') }}"
                    class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>Back to Jobs
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Job Information -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Job Overview -->
                <div class="bg-white rounded-lg shadow">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-medium text-gray-900">Job Overview</h3>
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                            {{ $job->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                <span
                                    class="w-1.5 h-1.5 mr-1.5 rounded-full
                                {{ $job->is_active ? 'bg-green-400' : 'bg-red-400' }}"></span>
                                {{ $job->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            <div>
                                <h2 class="text-2xl font-bold text-gray-900">{{ $job->title }}</h2>
                                <p class="text-lg text-gray-600 mt-1">{{ $job->company }}</p>
                            </div>

                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                <div class="flex items-center text-sm text-gray-600">
                                    <i class="fas fa-map-marker-alt mr-2 text-gray-400"></i>
                                    {{ $job->location }}
                                </div>
                                <div class="flex items-center text-sm text-gray-600">
                                    <i class="fas fa-dollar-sign mr-2 text-gray-400"></i>
                                    @if ($job->salary && $job->salary > 0)
                                        ${{ number_format($job->salary) }}
                                    @else
                                        Negotiable
                                    @endif
                                </div>
                                <div class="flex items-center text-sm text-gray-600">
                                    <i class="fas fa-layer-group mr-2 text-gray-400"></i>
                                    {{ ucfirst($job->level) }}
                                </div>
                                <div class="flex items-center text-sm text-gray-600">
                                    <i class="fas fa-calendar mr-2 text-gray-400"></i>
                                    {{ $job->deadline->format('M d, Y') }}
                                </div>
                            </div>

                            <div class="flex items-center space-x-4">
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    <i class="fas fa-tag mr-1"></i>{{ $job->category->name }}
                                </span>
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                    <i class="fas fa-tags mr-1"></i>{{ $job->subCategory->name }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Job Description -->
                <div class="bg-white rounded-lg shadow">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Job Description</h3>
                    </div>
                    <div class="p-6">
                        <div class="prose max-w-none">
                            {!! nl2br(e($job->description)) !!}
                        </div>
                    </div>
                </div>

                <!-- Applications -->
                <div class="bg-white rounded-lg shadow">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-medium text-gray-900">Applications ({{ $job->applications->count() }})
                            </h3>
                            <a href="{{ route('admin.applications.index', ['job' => $job->id]) }}"
                                class="text-blue-600 hover:text-blue-800 text-sm">
                                View All Applications →
                            </a>
                        </div>
                    </div>
                    @if ($job->applications->count() > 0)
                        <div class="divide-y divide-gray-200">
                            @foreach ($job->applications->take(5) as $application)
                                <div class="p-6">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-3">
                                            <div class="flex-shrink-0">
                                                <div
                                                    class="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center">
                                                    <i class="fas fa-user text-blue-600 text-sm"></i>
                                                </div>
                                            </div>
                                            <div>
                                                <p class="text-sm font-medium text-gray-900">{{ $application->user->name }}
                                                </p>
                                                <p class="text-sm text-gray-500">{{ $application->user->email }}</p>
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-3">
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            @switch($application->status)
                                                @case('pending') bg-yellow-100 text-yellow-800 @break
                                                @case('reviewed') bg-blue-100 text-blue-800 @break
                                                @case('accepted') bg-green-100 text-green-800 @break
                                                @case('rejected') bg-red-100 text-red-800 @break
                                                @default bg-gray-100 text-gray-800
                                            @endswitch">
                                                {{ ucfirst($application->status) }}
                                            </span>
                                            <span class="text-xs text-gray-500">
                                                {{ $application->created_at->diffForHumans() }}
                                            </span>
                                            <a href="{{ route('admin.applications.show', $application) }}"
                                                class="text-blue-600 hover:text-blue-800">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="p-6 text-center">
                            <i class="fas fa-inbox text-gray-400 text-3xl mb-3"></i>
                            <p class="text-gray-500">No applications yet</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Sidebar Information -->
            <div class="space-y-6">
                <!-- Job Statistics -->
                <div class="bg-white rounded-lg shadow">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Job Statistics</h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Total Applications</span>
                            <span class="text-sm font-medium text-gray-900">{{ $job->applications->count() }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Pending</span>
                            <span class="text-sm font-medium text-yellow-600">
                                {{ $job->applications->where('status', 'pending')->count() }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Reviewed</span>
                            <span class="text-sm font-medium text-blue-600">
                                {{ $job->applications->where('status', 'reviewed')->count() }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Accepted</span>
                            <span class="text-sm font-medium text-green-600">
                                {{ $job->applications->where('status', 'accepted')->count() }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Rejected</span>
                            <span class="text-sm font-medium text-red-600">
                                {{ $job->applications->where('status', 'rejected')->count() }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Job Details -->
                <div class="bg-white rounded-lg shadow">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Job Details</h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Job ID</dt>
                            <dd class="mt-1 text-sm text-gray-900">#{{ $job->id }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Posted By</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $job->postedBy->name }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Created Date</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $job->created_at->format('F d, Y \a\t H:i') }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $job->updated_at->format('F d, Y \a\t H:i') }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Application Deadline</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $job->deadline->format('F d, Y') }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Days Until Deadline</dt>
                            <dd
                                class="mt-1 text-sm
                            @if ($job->deadline->isPast()) text-red-600 @elseif($job->deadline->diffInDays() <= 7) text-yellow-600 @else text-green-600 @endif">
                                @if ($job->deadline->isPast())
                                    Expired {{ $job->deadline->diffForHumans() }}
                                @else
                                    {{ $job->deadline->diffInDays() }} days remaining
                                @endif
                            </dd>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white rounded-lg shadow">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Quick Actions</h3>
                    </div>
                    <div class="p-6 space-y-3">
                        <a href="{{ route('admin.jobs.edit', $job) }}"
                            class="w-full flex items-center justify-center px-4 py-2 border border-blue-300 rounded-md shadow-sm text-sm font-medium text-blue-700 bg-blue-50 hover:bg-blue-100 transition-colors">
                            <i class="fas fa-edit mr-2"></i>Edit Job
                        </a>

                        <form method="POST" action="{{ route('admin.jobs.toggle-status', $job) }}">
                            @csrf
                            @method('PATCH')
                            <button type="submit"
                                class="w-full flex items-center justify-center px-4 py-2 border rounded-md shadow-sm text-sm font-medium transition-colors
                                {{ $job->is_active ? 'border-red-300 text-red-700 bg-red-50 hover:bg-red-100' : 'border-green-300 text-green-700 bg-green-50 hover:bg-green-100' }}">
                                <i class="fas fa-toggle-{{ $job->is_active ? 'off' : 'on' }} mr-2"></i>
                                {{ $job->is_active ? 'Deactivate Job' : 'Activate Job' }}
                            </button>
                        </form>

                        <a href="{{ route('admin.applications.index', ['job' => $job->id]) }}"
                            class="w-full flex items-center justify-center px-4 py-2 border border-purple-300 rounded-md shadow-sm text-sm font-medium text-purple-700 bg-purple-50 hover:bg-purple-100 transition-colors">
                            <i class="fas fa-file-alt mr-2"></i>View Applications
                        </a>

                        <form method="POST" action="{{ route('admin.jobs.destroy', $job) }}"
                            onsubmit="return confirm('Are you sure you want to delete this job? This action can be undone from the deleted jobs section.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="w-full flex items-center justify-center px-4 py-2 border border-red-300 rounded-md shadow-sm text-sm font-medium text-red-700 bg-red-50 hover:bg-red-100 transition-colors">
                                <i class="fas fa-trash mr-2"></i>Delete Job
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
