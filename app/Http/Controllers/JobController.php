<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Job;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Application;
use App\Models\Admin;
use App\Notifications\ApplicationSubmitted;
use App\Notifications\NewApplicationReceived;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;

class JobController extends Controller
{
    /**
     * Display a listing of jobs
     */
    public function index(Request $request)
    {
        $query = Job::with(['subCategory.category', 'postedBy'])
            ->visible(); // Only show active and inactive jobs, hide draft

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
        // Prevent access to draft jobs on public site
        if ($job->isDraft()) {
            abort(404);
        }

        $job->load(['subCategory.category', 'postedBy', 'applications']);

        // Get related jobs from the same subcategory
        $relatedJobs = Job::with(['subCategory.category'])
            ->where('sub_category_id', $job->sub_category_id)
            ->where('id', '!=', $job->id)
            ->visible() // Only show active and inactive jobs
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
        if (!$job->isActive()) {
            return redirect()->route('jobs.show', $job)
                ->with('error', 'This job is no longer accepting applications.');
        }

        // Check if user has already applied
        if ($job->applications()->where('user_id', Auth::id())->exists()) {
            return redirect()->route('jobs.show', $job)
                ->with('error', 'You have already applied for this job.');
        }

        // Load job-specific requirements
        $job->loadMissing(['questions', 'documents']);

        $profile = Auth::user()->profile;
        $hasCv = $profile && $profile->cv_path;

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
        if (!$job->isActive()) {
            return redirect()->route('jobs.show', $job)
                ->with('error', 'This job is no longer accepting applications.');
        }

        // Check if user has already applied
        if ($job->applications()->where('user_id', Auth::id())->exists()) {
            return redirect()->route('jobs.show', $job)
                ->with('error', 'You have already applied for this job.');
        }

        $job->load(['questions', 'documents']);

        $user = Auth::user();
        $profile = $user->profile;
        $hasCv = $profile && $profile->cv_path;

        $rules = [
            'questions' => 'nullable|array',
            'documents' => 'nullable|array',
        ];
        if (!$hasCv || $request->cv_option === 'upload') {
            $rules['resume'] = 'required|file|mimes:pdf,doc,docx|max:5120';
        }

        foreach ($job->questions as $question) {
            $rules['questions.' . $question->id] = $question->is_required ? 'required|string|max:5000' : 'nullable|string|max:5000';
        }

        foreach ($job->documents as $document) {
            $rules['documents.' . $document->id] = $document->is_required ? 'required|file|mimes:pdf,doc,docx|max:5120' : 'nullable|file|mimes:pdf,doc,docx|max:5120';
        }

        $validated = $request->validate($rules);

        $cvPath = null;
        $uploadedResume = false;
        if ($hasCv && $request->cv_option === 'profile') {
            $cvPath = $profile->cv_path;
        } elseif ($request->hasFile('resume')) {
            $cvPath = $request->file('resume')->store('resumes', 'public');
            $uploadedResume = true;
        }

        $storedFiles = [];

        DB::beginTransaction();

        try {
            $application = Application::create([
                'job_id' => $job->id,
                'user_id' => Auth::id(),
                'cv_path' => $cvPath,
                'cover_letter' => $request->cover_letter,
                'status' => 'pending',
            ]);

            foreach ($job->questions as $question) {
                $answer = trim($request->input('questions.' . $question->id, ''));
                if ($answer !== '') {
                    $application->questionAnswers()->create([
                        'job_question_id' => $question->id,
                        'answer' => $answer,
                    ]);
                }
            }

            foreach ($job->documents as $document) {
                if ($request->hasFile('documents.' . $document->id)) {
                    $file = $request->file('documents.' . $document->id);
                    $path = $file->store('applications/documents', 'public');
                    $storedFiles[] = $path;

                    $application->documents()->create([
                        'job_document_id' => $document->id,
                        'file_path' => $path,
                        'original_name' => $file->getClientOriginalName(),
                    ]);
                }
            }

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            foreach ($storedFiles as $path) {
                Storage::disk('public')->delete($path);
            }
            if ($uploadedResume && $cvPath) {
                Storage::disk('public')->delete($cvPath);
            }
            throw $e;
        }

        try {
            $application->load(['job', 'user']);

            Notification::send($user, new ApplicationSubmitted($application));

            $admins = Admin::active()->get();
            Notification::send($admins, new NewApplicationReceived($application));
        } catch (\Throwable $e) {
            report($e);
        }

        return redirect()->route('jobs.show', $job)
            ->with('success', 'Your application has been submitted successfully!');
    }

    /**
     * Display user's applications
     */
    public function myApplications(Request $request)
    {
        $userId = Auth::id();
        $query = Application::with(['job' => function ($q) {
            $q->withTrashed(); // Include soft-deleted jobs
        }, 'job.subCategory.category'])
            ->where('user_id', $userId);

        // Filter by search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('job', function ($q) use ($search) {
                $q->withTrashed() // Include soft-deleted jobs in search
                    ->where('title', 'like', "%{$search}%")
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
                $query->leftJoin('jobs', 'applications.job_id', '=', 'jobs.id')
                    ->orderByRaw('COALESCE(jobs.title, "Deleted Job") asc')
                    ->select('applications.*');
                break;
            case 'company':
                $query->leftJoin('jobs', 'applications.job_id', '=', 'jobs.id')
                    ->orderByRaw('COALESCE(jobs.company, "Deleted Job") asc')
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


