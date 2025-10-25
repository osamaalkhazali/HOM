<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 fw-semibold">Notifications</h2>
    </x-slot>

    <div class="panel">
        <div class="panel-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <form method="POST" action="{{ route('notifications.readAll') }}">
                    @csrf
                    <button class="btn btn-sm btn-outline-secondary">Mark all as read</button>
                </form>
            </div>
            <ul class="list-group">
                @forelse($notifications as $notification)
                    <li class="list-group-item d-flex justify-content-between align-items-start {{ $notification->read_at ? '' : 'bg-light' }}"
                        style="border-radius: 10px; margin-bottom: 8px;">
                        <div class="ms-2 me-auto">
                            <div class="fw-bold">{{ $notification->data['title_' . app()->getLocale()] ?? $notification->data['title'] ?? __('site.nav.notifications') }}</div>
                            {{ $notification->data['message_' . app()->getLocale()] ?? $notification->data['message'] ?? '' }}
                        </div>
                        <a href="{{ route('notifications.open', $notification->id) }}" class="btn btn-sm btn-primary"
                            style="border-radius: 8px;">Open</a>
                    </li>
                @empty
                    <li class="list-group-item">No notifications</li>
                @endforelse
            </ul>

            <div class="mt-3">
                {{ $notifications->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
