@extends('layouts.admin.app')

@section('title', 'Edit Client')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-gray-900">Edit Client</h1>
            <p class="mt-1 text-sm text-gray-500">Update the details for {{ $client->name }}.</p>
        </div>
        <a href="{{ route('admin.clients.show', $client) }}"
            class="inline-flex items-center text-sm text-blue-600 hover:text-blue-800">
            <i class="fas fa-eye mr-2"></i>View client
        </a>
    </div>

    @if (session('success'))
        <div class="mb-6 rounded-md bg-green-50 p-4 border border-green-200 text-green-800">
            <div class="flex">
                <i class="fas fa-check-circle mt-1 mr-3"></i>
                <span>{{ session('success') }}</span>
            </div>
        </div>
    @endif

    <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6">
        <form action="{{ route('admin.clients.update', $client) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('admin.clients.partials.form', ['client' => $client, 'submitLabel' => 'Save Changes'])
        </form>
    </div>
@endsection
