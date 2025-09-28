@extends('layouts.admin.app')

@section('title', 'Notifications')

@section('content')
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-semibold">Notifications</h2>
            <form method="POST" action="{{ route('admin.notifications.readAll') }}">
                @csrf
                <button class="px-3 py-1 bg-gray-100 rounded hover:bg-gray-200">Mark all as read</button>
            </form>
        </div>
        <div class="space-y-2">
            @forelse($notifications as $notification)
                <div class="p-3 rounded {{ $notification->read_at ? 'bg-gray-50' : 'bg-blue-50' }}">
                    <div class="font-medium">{{ $notification->data['title'] ?? 'Notification' }}</div>
                    <div class="text-gray-600">{{ $notification->data['message'] ?? '' }}</div>
                    <a href="{{ route('admin.notifications.open', $notification->id) }}"
                        class="text-blue-600 text-sm">Open</a>
                </div>
            @empty
                <div class="text-gray-500">No notifications</div>
            @endforelse
        </div>
        <div class="mt-4">
            {{ $notifications->links('admin.partials.pagination') }}
        </div>
    @endsection
