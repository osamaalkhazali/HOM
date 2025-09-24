@extends('errors.layout')

@section('title', 'Access Forbidden')

@section('content')
    <div class="error-icon">
        <i class="fas fa-shield-alt"></i>
    </div>

    <div class="error-code">403</div>

    <h1 class="error-title">Access Forbidden</h1>

    <p class="error-message">
        You don't have permission to access this resource.
        If you believe this is an error, please contact support.
    </p>
@endsection
