@extends('layouts.admin.app')

@section('title', 'Create Client')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-gray-900">Create Client</h1>
        <p class="mt-1 text-sm text-gray-500">Add a new organisation to the public client carousel.</p>
    </div>

    <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6">
        <form action="{{ route('admin.clients.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @include('admin.clients.partials.form', ['client' => null, 'submitLabel' => 'Create Client'])
        </form>
    </div>
@endsection
