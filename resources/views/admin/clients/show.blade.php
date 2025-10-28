@extends('layouts.admin.app')

@section('title', 'Client Details')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-gray-900">{{ $client->name }}</h1>
            <p class="mt-1 text-sm text-gray-500">Preview and manage client information.</p>
        </div>
        <div class="inline-flex items-center space-x-3">
            <a href="{{ route('admin.clients.edit', $client) }}"
                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700">
                <i class="fas fa-edit mr-2"></i>Edit
            </a>
            <form action="{{ route('admin.clients.destroy', $client) }}" method="POST"
                onsubmit="return confirm('Delete this client? This action cannot be undone.');">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700">
                    <i class="fas fa-trash-alt mr-2"></i>Delete
                </button>
            </form>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6">
                <h2 class="text-lg font-medium text-gray-900 mb-4">Overview</h2>
                <dl class="divide-y divide-gray-200">
                    <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5">
                        <dt class="text-sm font-medium text-gray-500">Name</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $client->name }}</dd>
                    </div>
                    <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5">
                        <dt class="text-sm font-medium text-gray-500">Slug</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">/{{ $client->slug }}</dd>
                    </div>
                    <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5">
                        <dt class="text-sm font-medium text-gray-500">Website</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            @if ($client->website_url)
                                <a href="{{ $client->website_url }}" class="text-blue-600 hover:text-blue-800"
                                    target="_blank" rel="noopener">
                                    {{ $client->website_url }}
                                </a>
                            @else
                                <span class="text-gray-400">Not provided</span>
                            @endif
                        </dd>
                    </div>
                    <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5">
                        <dt class="text-sm font-medium text-gray-500">Status</dt>
                        <dd class="mt-1 text-sm sm:mt-0 sm:col-span-2">
                            @if ($client->is_active)
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <i class="fas fa-check mr-1"></i>Active
                                </span>
                            @else
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-600">
                                    <i class="fas fa-pause mr-1"></i>Inactive
                                </span>
                            @endif
                        </dd>
                    </div>
                    <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5">
                        <dt class="text-sm font-medium text-gray-500">Linked jobs</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ number_format($client->jobs_count ?? 0) }}
                        </dd>
                    </div>
                    <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5">
                        <dt class="text-sm font-medium text-gray-500">Applications</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ number_format($client->applications_count ?? 0) }}
                        </dd>
                    </div>
                    <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5">
                        <dt class="text-sm font-medium text-gray-500">Description</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ $client->description ? $client->description : '—' }}
                        </dd>
                    </div>
                </dl>
            </div>

            <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6">
                <h2 class="text-lg font-medium text-gray-900 mb-4">Activity</h2>
                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">
                        <dt class="text-xs font-medium text-gray-500 uppercase tracking-wide">Created</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $client->created_at?->format('M d, Y H:i') ?? '—' }}</dd>
                        <dd class="text-xs text-gray-500">{{ $client->created_at?->diffForHumans() }}</dd>
                    </div>
                    <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">
                        <dt class="text-xs font-medium text-gray-500 uppercase tracking-wide">Last updated</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $client->updated_at?->format('M d, Y H:i') ?? '—' }}</dd>
                        <dd class="text-xs text-gray-500">{{ $client->updated_at?->diffForHumans() }}</dd>
                    </div>
                </dl>
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6 text-center">
                <h2 class="text-lg font-medium text-gray-900 mb-4">Logo preview</h2>
                @if ($client->logo_url)
                    <div class="flex items-center justify-center h-40">
                        <img src="{{ $client->logo_url }}" alt="{{ $client->name }} logo"
                            class="max-h-full object-contain">
                    </div>
                @else
                    <div
                        class="h-40 flex items-center justify-center border border-dashed border-gray-300 rounded-lg bg-gray-50">
                        <span class="text-sm text-gray-500">No logo uploaded</span>
                    </div>
                @endif
            </div>

            <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6">
                <h2 class="text-lg font-medium text-gray-900 mb-4">Quick actions</h2>
                <div class="space-y-3">
                    <a href="{{ route('admin.clients.edit', $client) }}"
                        class="block w-full text-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-md">
                        <i class="fas fa-edit mr-2"></i>Edit client
                    </a>
                    <a href="{{ route('welcome') }}#clients" target="_blank" rel="noopener"
                        class="block w-full text-center px-4 py-2 text-sm font-medium text-blue-600 border border-blue-100 rounded-md hover:bg-blue-50">
                        <i class="fas fa-external-link-alt mr-2"></i>View on landing page
                    </a>
                    <a href="{{ route('admin.jobs.index', ['client_id' => $client->id]) }}"
                        class="block w-full text-center px-4 py-2 text-sm font-medium text-slate-700 border border-slate-200 rounded-md hover:bg-slate-50">
                        <i class="fas fa-briefcase mr-2"></i>View related jobs
                    </a>
                    <a href="{{ route('admin.applications.index', ['client_id' => $client->id]) }}"
                        class="block w-full text-center px-4 py-2 text-sm font-medium text-purple-700 border border-purple-200 rounded-md hover:bg-purple-50">
                        <i class="fas fa-file-alt mr-2"></i>View client applications
                    </a>
                </div>
            </div>
        </div>
    </div>

@endsection
