@extends('errors.layout')

@section('title', 'Server Error')

@section('content')
    <div class="error-icon">
        <i class="fas fa-exclamation-triangle"></i>
    </div>

    <div class="error-code">500</div>

    <h1 class="error-title">Server Error</h1>

    <p class="error-message">
        Something went wrong on our end. We've been notified and are working to fix it.
        Please try again in a few moments.
    </p>
@endsection
