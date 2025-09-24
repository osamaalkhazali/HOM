@extends('errors.layout')

@section('title', 'Page Not Found')

@section('content')
    <div class="error-icon">
        <i class="fas fa-search"></i>
    </div>

    <div class="error-code">404</div>

    <h1 class="error-title">Page Not Found</h1>

    <p class="error-message">
        Oops! The page you're looking for seems to have wandered off.
        Don't worry though, we'll help you find what you're looking for.
    </p>

    <div class="glass-effect">
        <h5 style="color: var(--primary-color); margin-bottom: 1rem; font-weight: 600;">
            <i class="fas fa-lightbulb me-2"></i>Looking for something specific?
        </h5>
        <div class="d-flex flex-wrap justify-content-center gap-2">
            <a href="{{ route('jobs.index') }}" class="btn btn-sm btn-outline-primary" style="border-radius: 10px;">
                <i class="fas fa-briefcase me-1"></i>Browse Jobs
            </a>
            <a href="{{ route('dashboard') }}" class="btn btn-sm btn-outline-primary" style="border-radius: 10px;">
                <i class="fas fa-tachometer-alt me-1"></i>Dashboard
            </a>
            <a href="{{ route('profile.edit') }}" class="btn btn-sm btn-outline-primary" style="border-radius: 10px;">
                <i class="fas fa-user me-1"></i>My Profile
            </a>
        </div>
    </div>
@endsection
