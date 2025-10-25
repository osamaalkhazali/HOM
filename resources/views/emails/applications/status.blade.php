@extends('emails.layouts.base')

@section('content')
    <p style="margin:0 0 16px; font-weight:600;">{{ $greeting }}</p>

    @if (!empty($intro))
        <p style="margin:0 0 20px; color:#374151;">{{ $intro }}</p>
    @endif

    @if (!empty($lines))
        @foreach ($lines as $line)
            <p style="margin:0 0 16px; color:#4b5563;">{{ $line }}</p>
        @endforeach
    @endif

    @if (!empty($actionText) && !empty($actionUrl))
        <div style="text-align:center; margin:24px 0 32px;">
            <a href="{{ $actionUrl }}" target="_blank" rel="noopener"
                style="display:inline-block; padding:14px 32px; background-color:{{ $primaryColor ?? '#18458f' }}; color:#ffffff; border-radius:10px; text-decoration:none; font-weight:600;">
                {{ $actionText }}
            </a>
        </div>
    @endif

    @if (!empty($support))
        <p style="margin:0 0 18px; color:#4b5563;">{{ $support }}</p>
    @endif

    @if (!empty($buttonFallback) && !empty($actionUrl))
        <p style="margin:0 0 10px; color:#6b7280;">{{ $buttonFallback }}</p>
        <p style="margin:0 0 24px; word-break:break-all;">
            <a href="{{ $actionUrl }}" target="_blank" rel="noopener"
                style="color:{{ $primaryColor ?? '#18458f' }}; text-decoration:none;">{{ $actionUrl }}</a>
        </p>
    @endif

    <p style="margin:24px 0 4px;">{{ $signature }}</p>
    <p style="margin:0; font-weight:700; color:{{ $primaryColor ?? '#18458f' }};">{{ $team }}</p>
@endsection
