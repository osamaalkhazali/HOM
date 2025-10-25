@extends('emails.layouts.base')

@section('content')
    <p style="margin:0 0 16px; font-weight:600;">{{ $greeting }}</p>
    <p style="margin:0 0 24px; color:#374151;">{{ $intro }}</p>

    <div style="text-align:center; margin:0 0 32px;">
        <a href="{{ $actionUrl }}" target="_blank" rel="noopener"
            style="display:inline-block; padding:14px 32px; background-color:{{ $primaryColor ?? '#18458f' }}; color:#ffffff; border-radius:10px; text-decoration:none; font-weight:600;">
            {{ $actionText }}
        </a>
    </div>

    <p style="margin:0 0 20px; color:#4b5563;">{{ $support }}</p>
    <p style="margin:0 0 12px; color:#4b5563;">{{ $buttonFallback }}</p>
    <p style="margin:0 0 28px; word-break:break-all;">
        <a href="{{ $actionUrl }}" target="_blank" rel="noopener"
            style="color:{{ $primaryColor ?? '#18458f' }}; text-decoration:none;">{{ $actionUrl }}</a>
    </p>

    <p style="margin:24px 0 4px;">{{ $signature }}</p>
    <p style="margin:0; font-weight:700; color:{{ $primaryColor ?? '#18458f' }};">{{ $team }}</p>
@endsection
