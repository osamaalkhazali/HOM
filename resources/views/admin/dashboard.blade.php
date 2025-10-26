@extends('layouts.admin.app')

@section('title', 'Admin Dashboard')

@section('content')
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Dashboard Overview</h1>
        <p class="text-gray-600 mt-2">Welcome back! Here's what's happening with your job portal today.</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Jobs -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                    <i class="fas fa-briefcase text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Jobs</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ number_format($stats['total_jobs']) }}</p>
                    <p class="text-xs text-gray-500">{{ number_format($stats['active_jobs']) }} active</p>
                </div>
            </div>
            <div class="mt-4">
                @php
                    $jobGrowth = $growth['jobs']['percentage'];
                    $isPositive = $jobGrowth >= 0;
                @endphp
                <span class="text-{{ $isPositive ? 'green' : 'red' }}-600 text-sm font-medium">
                    <i class="fas fa-{{ $isPositive ? 'arrow-up' : 'arrow-down' }} mr-1"></i>
                    {{ abs($jobGrowth) }}% from last month
                </span>
            </div>
        </div>

        <!-- Total Applications -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-600">
                    <i class="fas fa-file-alt text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Applications</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ number_format($stats['total_applications']) }}</p>
                    <p class="text-xs text-gray-500">{{ number_format($stats['pending_applications']) }} pending</p>
                </div>
            </div>
            <div class="mt-4">
                @php
                    $appGrowth = $growth['applications']['percentage'];
                    $isPositive = $appGrowth >= 0;
                @endphp
                <span class="text-{{ $isPositive ? 'green' : 'red' }}-600 text-sm font-medium">
                    <i class="fas fa-{{ $isPositive ? 'arrow-up' : 'arrow-down' }} mr-1"></i>
                    {{ abs($appGrowth) }}% from last month
                </span>
            </div>
        </div>

        <!-- Total Users -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                    <i class="fas fa-users text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Users</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ number_format($stats['total_users']) }}</p>
                    <p class="text-xs text-gray-500">{{ $insights['profile_completion_rate'] }}% with profiles</p>
                </div>
            </div>
            <div class="mt-4">
                @php
                    $userGrowth = $growth['users']['percentage'];
                    $isPositive = $userGrowth >= 0;
                @endphp
                <span class="text-{{ $isPositive ? 'green' : 'red' }}-600 text-sm font-medium">
                    <i class="fas fa-{{ $isPositive ? 'arrow-up' : 'arrow-down' }} mr-1"></i>
                    {{ abs($userGrowth) }}% from last month
                </span>
            </div>
        </div>

        <!-- Categories -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-orange-100 text-orange-600">
                    <i class="fas fa-tags text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Categories</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ number_format($stats['total_categories']) }}</p>
                    <p class="text-xs text-gray-500">{{ number_format($stats['total_subcategories']) }} subcategories</p>
                </div>
            </div>
            <div class="mt-4">
                <span class="text-blue-600 text-sm font-medium">
                    <i class="fas fa-chart-bar mr-1"></i>
                    {{ $insights['avg_applications_per_job'] }} avg apps/job
                </span>
            </div>
        </div>
    </div>

    <!-- Today's Insights -->
    <div class="mb-8">
        <div class="bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg shadow p-6 text-white">
            <h2 class="text-xl font-semibold mb-4">
                <i class="fas fa-calendar-day mr-2"></i>Today's Activity
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="text-center">
                    <div class="text-3xl font-bold">{{ $insights['jobs_today'] }}</div>
                    <div class="text-blue-100">{{ Str::plural('Job', $insights['jobs_today']) }} Posted Today</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold">{{ $insights['applications_today'] }}</div>
                    <div class="text-blue-100">{{ Str::plural('Application', $insights['applications_today']) }} Received
                        Today</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold">{{ $insights['users_today'] }}</div>
                    <div class="text-blue-100">New {{ Str::plural('User', $insights['users_today']) }} Today</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <!-- Jobs Posted Chart -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Jobs Posted (Last 6 Months)</h3>
            <div style="height: 250px;">
                <canvas id="jobsChart"></canvas>
            </div>
        </div>

        <!-- Application Status Chart -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Application Status</h3>
            <div style="height: 250px;">
                <canvas id="statusChart"></canvas>
            </div>
        </div>

        <!-- User Growth Chart -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">User Registrations (Last 6 Months)</h3>
            <div style="height: 250px;">
                <canvas id="usersChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Recent Activities and Quick Actions -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Jobs -->
        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Recent Jobs Posted</h3>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @forelse($recentJobs as $job)
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="text-sm font-medium text-gray-900">{{ $job->title }}</h4>
                                @php
                                    $categoryLabel = optional(optional($job->subCategory)->category)->name
                                        ?? 'Uncategorized';
                                    $subLabel = optional($job->subCategory)->name;
                                @endphp
                                <p class="text-sm text-gray-500">
                                    {{ $categoryLabel }}
                                    @if ($subLabel)
                                        &bull; {{ $subLabel }}
                                    @endif
                                </p>
                            </div>
                            <div class="text-right">
                                @if ($job->salary_range)
                                    <p class="text-sm text-gray-900">{{ $job->salary_range }}</p>
                                @endif
                                <p class="text-xs text-gray-500">{{ $job->created_at->diffForHumans() }}</p>
                                <span
                                    class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                    {{ $job->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-600' }}">
                                    {{ $job->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-gray-500 py-4">
                            <i class="fas fa-briefcase text-2xl mb-2 text-gray-300"></i>
                            <p>No jobs posted yet</p>
                        </div>
                    @endforelse
                </div>
                <div class="mt-4">
                    <a href="{{ route('admin.jobs.index') }}"
                        class="text-blue-600 text-sm font-medium hover:text-blue-800">View all jobs →</a>
                </div>
            </div>
        </div>

        <!-- Recent Applications -->
        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Recent Applications</h3>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @forelse($recentApplications as $application)
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <img class="h-8 w-8 rounded-full"
                                    src="https://ui-avatars.com/api/?name={{ urlencode($application->user->name) }}&background=random"
                                    alt="{{ $application->user->name }}">
                                <div class="ml-3">
                                    <h4 class="text-sm font-medium text-gray-900">{{ $application->user->name }}</h4>
                                    <p class="text-sm text-gray-500">Applied for {{ $application->job->title }}</p>
                                    <p class="text-xs text-gray-400">{{ $application->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <span
                                    class="px-2 py-1 text-xs font-medium rounded-full
                                    @if ($application->status === 'pending') bg-yellow-100 text-yellow-800
                                    @elseif($application->status === 'reviewed') bg-blue-100 text-blue-800
                                    @elseif($application->status === 'shortlisted') bg-purple-100 text-purple-800
                                    @elseif($application->status === 'hired') bg-green-100 text-green-800
                                    @else bg-red-100 text-red-800 @endif">
                                    {{ ucfirst($application->status) }}
                                </span>
                                @if ($application->cover_letter)
                                    <div class="text-xs text-gray-500 mt-1">
                                        <i class="fas fa-file-text mr-1"></i>Cover letter
                                    </div>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-gray-500 py-4">
                            <i class="fas fa-file-alt text-2xl mb-2 text-gray-300"></i>
                            <p>No applications yet</p>
                        </div>
                    @endforelse
                </div>
                <div class="mt-4">
                    <a href="{{ route('admin.applications.index') }}"
                        class="text-blue-600 text-sm font-medium hover:text-blue-800">View all applications →</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Top Categories -->
    <div class="mt-8">
        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Top Job Categories</h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    @forelse($topCategories as $index => $category)
                        @php
                            $colors = ['blue', 'green', 'purple', 'orange'];
                            $icons = ['fas fa-code', 'fas fa-chart-line', 'fas fa-paint-brush', 'fas fa-bullhorn'];
                            $color = $colors[$index] ?? 'gray';
                            $icon = $icons[$index] ?? 'fas fa-tag';
                        @endphp
                        <div class="bg-{{ $color }}-50 rounded-lg p-4 text-center">
                            <i class="{{ $icon }} text-2xl text-{{ $color }}-600 mb-2"></i>
                            <h4 class="font-medium text-gray-900">{{ $category->name }}</h4>
                            <p class="text-sm text-gray-600">{{ number_format($category->actual_jobs_count) }}
                                {{ Str::plural('job', $category->actual_jobs_count) }}</p>
                            <p class="text-xs text-gray-500 mt-1">{{ $category->subCategories->count() }}
                                {{ Str::plural('subcategory', $category->subCategories->count()) }}</p>
                        </div>
                    @empty
                        <div class="col-span-4 text-center text-gray-500 py-8">
                            <i class="fas fa-tags text-3xl mb-2 text-gray-300"></i>
                            <p>No categories with jobs yet</p>
                        </div>
                    @endforelse
                </div>
                @if ($topCategories->count() > 0)
                    <div class="mt-4 text-center">
                        <a href="{{ route('admin.categories.index') }}"
                            class="text-blue-600 text-sm font-medium hover:text-blue-800">
                            View all categories →
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Jobs Posted Chart - Real Data
        const jobsCtx = document.getElementById('jobsChart').getContext('2d');
        new Chart(jobsCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($jobsChartData->pluck('month')) !!},
                datasets: [{
                    label: 'Jobs Posted',
                    data: {!! json_encode($jobsChartData->pluck('count')) !!},
                    borderColor: 'rgb(59, 130, 246)',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                    }
                },
                scales: {
                    x: {
                        display: true,
                        title: {
                            display: true,
                            text: 'Month'
                        }
                    },
                    y: {
                        display: true,
                        title: {
                            display: true,
                            text: 'Jobs Posted'
                        },
                        beginAtZero: true
                    }
                },
                interaction: {
                    mode: 'nearest',
                    axis: 'x',
                    intersect: false
                }
            }
        });

        // Application Status Chart - Real Data
        const statusCtx = document.getElementById('statusChart').getContext('2d');
        new Chart(statusCtx, {
            type: 'doughnut',
            data: {
                labels: ['Pending', 'Reviewed', 'Shortlisted', 'Hired', 'Rejected'],
                datasets: [{
                    data: [
                        {{ $applicationStatusData['pending'] ?? 0 }},
                        {{ $applicationStatusData['reviewed'] ?? 0 }},
                        {{ $applicationStatusData['shortlisted'] ?? 0 }},
                        {{ $applicationStatusData['hired'] ?? 0 }},
                        {{ $applicationStatusData['rejected'] ?? 0 }}
                    ],
                    backgroundColor: [
                        '#fbbf24', // yellow - pending
                        '#3b82f6', // blue - reviewed
                        '#8b5cf6', // purple - shortlisted
                        '#10b981', // green - hired
                        '#ef4444' // red - rejected
                    ],
                    borderWidth: 2,
                    borderColor: '#ffffff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 10,
                            usePointStyle: true,
                            font: {
                                size: 11
                            }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let total = context.dataset.data.reduce((a, b) => a + b, 0);
                                let percentage = total > 0 ? Math.round((context.parsed / total) * 100) : 0;
                                return context.label + ': ' + context.parsed + ' (' + percentage + '%)';
                            }
                        }
                    }
                },
                cutout: '50%'
            }
        });

        // User Growth Chart - Real Data
        const usersCtx = document.getElementById('usersChart').getContext('2d');
        new Chart(usersCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($usersChartData->pluck('month')) !!},
                datasets: [{
                    label: 'New Users',
                    data: {!! json_encode($usersChartData->pluck('count')) !!},
                    backgroundColor: 'rgba(139, 92, 246, 0.8)',
                    borderColor: 'rgb(139, 92, 246)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                    }
                },
                scales: {
                    x: {
                        display: true,
                        title: {
                            display: true,
                            text: 'Month'
                        }
                    },
                    y: {
                        display: true,
                        title: {
                            display: true,
                            text: 'New Users'
                        },
                        beginAtZero: true
                    }
                },
                interaction: {
                    mode: 'nearest',
                    axis: 'x',
                    intersect: false
                }
            }
        });

        // Add some interactivity for today's insights
        document.addEventListener('DOMContentLoaded', function() {
            // Add pulse animation to today's stats if they exist
            @if ($insights['jobs_today'] > 0 || $insights['applications_today'] > 0 || $insights['users_today'] > 0)
                const statsCards = document.querySelectorAll('.bg-white.rounded-lg.shadow.p-6');
                statsCards.forEach(card => {
                    card.classList.add('hover:shadow-lg', 'transition-shadow', 'duration-200');
                });
            @endif

            // Auto-refresh data every 5 minutes
            setTimeout(function() {
                window.location.reload();
            }, 300000); // 5 minutes
        });
    </script>
@endpush
