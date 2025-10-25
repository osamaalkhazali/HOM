{{ $greeting }}

@if (!empty($intro))
    {{ $intro }}
@endif
@if (!empty($lines))
    @foreach ($lines as $line)
        {{ $line }}
    @endforeach
@endif
@if (!empty($actionText) && !empty($actionUrl))
    {{ $actionText }}: {{ $actionUrl }}
@endif
@if (!empty($support))
    {{ $support }}
@endif
@if (!empty($buttonFallback) && !empty($actionUrl))
    {{ $buttonFallback }}
    {{ $actionUrl }}
@endif
{{ $signature }}
{{ $team }}

{{ $footer }}
