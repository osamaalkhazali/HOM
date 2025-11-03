<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Job;
use App\Models\Application;
use App\Models\Category;
use App\Models\SubCategory;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard
     */
    public function index()
    {
        // Get the authenticated admin
        $admin = Auth::guard('admin')->user();

        // Get current month and previous month data for comparisons
        $currentMonth = Carbon::now()->startOfMonth();
        $previousMonth = Carbon::now()->subMonth()->startOfMonth();
        $lastMonth = Carbon::now()->subMonth()->endOfMonth();

        // Determine if filtering by client (for Client HR)
        $clientId = $admin->isClientHr() ? $admin->client_id : null;

        // Get basic statistics
        $jobsQuery = $clientId ? Job::where('client_id', $clientId) : Job::query();
        $applicationsQuery = $clientId
            ? Application::whereHas('job', fn($q) => $q->where('client_id', $clientId))
            : Application::query();

        $stats = [
            'total_jobs' => (clone $jobsQuery)->count(),
            'active_jobs' => (clone $jobsQuery)->where('is_active', true)->count(),
            'total_applications' => (clone $applicationsQuery)->count(),
            'pending_applications' => (clone $applicationsQuery)->where('status', 'pending')->count(),
            'total_users' => User::count(),
            'users_with_profiles' => User::whereHas('profile')->count(),
            'total_categories' => Category::count(),
            'total_subcategories' => SubCategory::count(),
        ];

        // Get growth metrics (this month vs last month)
        $growth = [
            'jobs' => [
                'current' => (clone $jobsQuery)->where('created_at', '>=', $currentMonth)->count(),
                'previous' => (clone $jobsQuery)->whereBetween('created_at', [$previousMonth, $lastMonth])->count(),
            ],
            'applications' => [
                'current' => (clone $applicationsQuery)->where('created_at', '>=', $currentMonth)->count(),
                'previous' => (clone $applicationsQuery)->whereBetween('created_at', [$previousMonth, $lastMonth])->count(),
            ],
            'users' => [
                'current' => User::where('created_at', '>=', $currentMonth)->count(),
                'previous' => User::whereBetween('created_at', [$previousMonth, $lastMonth])->count(),
            ],
        ];

        // Calculate percentage changes
        foreach ($growth as $key => $data) {
            $growth[$key]['percentage'] = $data['previous'] > 0
                ? round((($data['current'] - $data['previous']) / $data['previous']) * 100, 1)
                : ($data['current'] > 0 ? 100 : 0);
        }

        // Get jobs posted over last 6 months for chart
        $jobsChartData = collect();
        for ($i = 5; $i >= 0; $i--) {
            $monthStart = Carbon::now()->subMonths($i)->startOfMonth();
            $monthEnd = Carbon::now()->subMonths($i)->endOfMonth();
            $query = $clientId
                ? Job::where('client_id', $clientId)->whereBetween('created_at', [$monthStart, $monthEnd])
                : Job::whereBetween('created_at', [$monthStart, $monthEnd]);
            $jobsChartData->push([
                'month' => $monthStart->format('M'),
                'count' => $query->count()
            ]);
        }

        // Get user registrations over last 6 months for chart
        $usersChartData = collect();
        for ($i = 5; $i >= 0; $i--) {
            $monthStart = Carbon::now()->subMonths($i)->startOfMonth();
            $monthEnd = Carbon::now()->subMonths($i)->endOfMonth();
            $usersChartData->push([
                'month' => $monthStart->format('M'),
                'count' => User::whereBetween('created_at', [$monthStart, $monthEnd])->count()
            ]);
        }

        // Get application status distribution
        $applicationStatusQuery = $clientId
            ? Application::whereHas('job', fn($q) => $q->where('client_id', $clientId))
            : Application::query();

        $applicationStatusData = $applicationStatusQuery
            ->select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get()
            ->pluck('count', 'status')
            ->toArray();

        // Ensure all statuses are represented
        $statusTypes = ['pending', 'reviewed', 'shortlisted', 'hired', 'rejected'];
        foreach ($statusTypes as $status) {
            if (!isset($applicationStatusData[$status])) {
                $applicationStatusData[$status] = 0;
            }
        }

        // Get recent jobs
        $recentJobsQuery = Job::with(['subCategory.category']);
        if ($clientId) {
            $recentJobsQuery->where('client_id', $clientId);
        }
        $recentJobs = $recentJobsQuery->latest()->limit(5)->get();

        // Get recent applications
        $recentApplicationsQuery = Application::with(['user', 'job']);
        if ($clientId) {
            $recentApplicationsQuery->whereHas('job', fn($q) => $q->where('client_id', $clientId));
        }
        $recentApplications = $recentApplicationsQuery->latest()->limit(5)->get();

        // Get top categories by job count
        $topCategories = Category::withCount(['subCategories as jobs_count' => function ($query) {
            $query->withCount('jobs');
        }])
            ->orderBy('jobs_count', 'desc')
            ->limit(4)
            ->get()
            ->map(function ($category) {
                // Get actual job count through subcategories
                $category->actual_jobs_count = $category->subCategories()
                    ->withCount('jobs')
                    ->get()
                    ->sum('jobs_count');
                return $category;
            });

        // Get recent user registrations
        $recentUsers = User::with('profile')
            ->latest()
            ->limit(5)
            ->get();

        // Additional insights
        $insights = [
            'jobs_today' => $clientId
                ? Job::where('client_id', $clientId)->whereDate('created_at', Carbon::today())->count()
                : Job::whereDate('created_at', Carbon::today())->count(),
            'applications_today' => $clientId
                ? Application::whereHas('job', fn($q) => $q->where('client_id', $clientId))->whereDate('created_at', Carbon::today())->count()
                : Application::whereDate('created_at', Carbon::today())->count(),
            'users_today' => User::whereDate('created_at', Carbon::today())->count(),
            'avg_applications_per_job' => $stats['total_jobs'] > 0
                ? round($stats['total_applications'] / $stats['total_jobs'], 1)
                : 0,
            'profile_completion_rate' => $stats['total_users'] > 0
                ? round(($stats['users_with_profiles'] / $stats['total_users']) * 100, 1)
                : 0,
        ];

        return view('admin.dashboard', compact(
            'admin',
            'stats',
            'growth',
            'jobsChartData',
            'usersChartData',
            'applicationStatusData',
            'recentJobs',
            'recentApplications',
            'topCategories',
            'recentUsers',
            'insights',
            'clientId'
        ));
    }

    /**
     * Get current authenticated admin
     */
    public function getAuthenticatedAdmin()
    {
        return Auth::guard('admin')->user();
    }
}
