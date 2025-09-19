<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Job;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Application;

class JobController extends Controller
{
    /**
     * Display a listing of jobs
     */
    public function index(Request $request)
    {
        $query = Job::with(['subCategory.category', 'postedBy'])
            ->where('is_active', true); // Only hide inactive jobs, show expired ones

        // Filter by category if provided (through subcategories)
        if ($request->filled('category')) {
            $subcategoryIds = SubCategory::where('category_id', $request->category)->pluck('id');
            $query->whereIn('sub_category_id', $subcategoryIds);
        }

        // Filter by subcategory if provided
        if ($request->filled('subcategory')) {
            $query->where('sub_category_id', $request->subcategory);
        }

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('company', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%");
            });
        }

        // Filter by location
        if ($request->filled('location')) {
            $query->where('location', 'like', "%{$request->location}%");
        }

        // Filter by job level
        if ($request->filled('level')) {
            $query->where('level', $request->level);
        }

        // Sort options
        $sort = $request->get('sort', 'newest');
        switch ($sort) {
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'title':
                $query->orderBy('title', 'asc');
                break;
            case 'company':
                $query->orderBy('company', 'asc');
                break;
            default: // newest
                $query->orderBy('created_at', 'desc');
                break;
        }

        $jobs = $query->paginate(12);
        $categories = Category::with('subCategories')->get();
        $locations = Job::where('is_active', true)->distinct()->pluck('location')->filter()->sort()->values();
        $levels = Job::where('is_active', true)->distinct()->pluck('level')->filter()->sort()->values();

        return view('jobs.index', compact('jobs', 'categories', 'locations', 'levels'));
    }

    /**
     * Display the specified job
     */
    public function show(Job $job)
    {
        $job->load(['subCategory.category', 'postedBy', 'applications']);

        // Get related jobs from the same subcategory
        $relatedJobs = Job::with(['subCategory.category'])
            ->where('sub_category_id', $job->sub_category_id)
            ->where('id', '!=', $job->id)
            ->where('is_active', true)
            ->limit(3)
            ->get();

        // Check if current user has already applied
        $hasApplied = false;
        $hasCv = false;
        if (Auth::check()) {
            $hasApplied = $job->applications()->where('user_id', Auth::id())->exists();
            $hasCv = Auth::user()->profile && Auth::user()->profile->cv_path;
        }

        return view('jobs.show', compact('job', 'relatedJobs', 'hasApplied', 'hasCv'));
    }

    /**
     * Show job application form
     */
    public function apply(Job $job)
    {
        // Check if job is expired
        if ($job->isExpired()) {
            return redirect()->route('jobs.show', $job)
                ->with('error', 'This job application deadline has passed. You can no longer apply for this position.');
        }

        // Check if job is active
        if (!$job->is_active) {
            return redirect()->route('jobs.show', $job)
                ->with('error', 'This job is no longer accepting applications.');
        }

        // Check if user has already applied
        if ($job->applications()->where('user_id', Auth::id())->exists()) {
            return redirect()->route('jobs.show', $job)
                ->with('error', 'You have already applied for this job.');
        }

        // Check if user has uploaded CV to profile
        $hasCv = Auth::user()->profile && Auth::user()->profile->cv_path;

        return view('jobs.apply', compact('job', 'hasCv'));
    }

    /**
     * Store job application
     */
    public function storeApplication(Request $request, Job $job)
    {
        // Check if job is expired
        if ($job->isExpired()) {
            return redirect()->route('jobs.show', $job)
                ->with('error', 'This job application deadline has passed. You can no longer apply for this position.');
        }

        // Check if job is active
        if (!$job->is_active) {
            return redirect()->route('jobs.show', $job)
                ->with('error', 'This job is no longer accepting applications.');
        }

        // Check if user has already applied
        if ($job->applications()->where('user_id', Auth::id())->exists()) {
            return redirect()->route('jobs.show', $job)
                ->with('error', 'You have already applied for this job.');
        }

        $user = Auth::user();
        $hasCv = $user->profile && $user->profile->cv_path;

        // Validate based on CV option
        $rules = [];
        if (!$hasCv || $request->cv_option === 'upload') {
            $rules['resume'] = 'required|file|mimes:pdf,doc,docx|max:5120'; // 5MB max
        }

        $request->validate($rules);

        // Determine CV path
        $cvPath = null;
        if ($hasCv && $request->cv_option === 'profile') {
            // Use CV from profile
            $cvPath = $user->profile->cv_path;
        } elseif ($request->hasFile('resume')) {
            // Store the uploaded resume file
            $cvPath = $request->file('resume')->store('resumes', 'public');
        }

        // Create the application
        Application::create([
            'job_id' => $job->id,
            'user_id' => Auth::id(),
            'cv_path' => $cvPath,
            'cover_letter' => $request->cover_letter,
            'status' => 'pending',
        ]);

        return redirect()->route('jobs.show', $job)
            ->with('success', 'Your application has been submitted successfully!');
    }

    /**
     * Display user's applications
     */
    public function myApplications(Request $request)
    {
        $query = Auth::user()->applications()->with(['job.subCategory.category']);

        // Filter by search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('job', function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('company', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Sort options
        $sort = $request->get('sort', 'newest');
        switch ($sort) {
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'job_title':
                $query->join('jobs', 'applications.job_id', '=', 'jobs.id')
                    ->orderBy('jobs.title', 'asc')
                    ->select('applications.*');
                break;
            case 'company':
                $query->join('jobs', 'applications.job_id', '=', 'jobs.id')
                    ->orderBy('jobs.company', 'asc')
                    ->select('applications.*');
                break;
            default: // newest
                $query->orderBy('created_at', 'desc');
                break;
        }

        $applications = $query->paginate(10);

        return view('applications.index', compact('applications'));
    }
}
