<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\SendsApplicationStatusNotifications;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Job;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Application;
use App\Models\ApplicationDocument;
use App\Support\SecureStorage;
use Illuminate\Support\Facades\DB;

class JobController extends Controller
{
    use SendsApplicationStatusNotifications;
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

        $job->load([
            'subCategory.category',
            'postedBy',
            'applications',
            'questions',
            'documents',
        ]);

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
                ->with('error', __('site.flash.job_deadline_passed'));
        }

        // Check if job is active
        if (!$job->isActive()) {
            return redirect()->route('jobs.show', $job)
                ->with('error', __('site.flash.job_no_longer_accepting'));
        }

        // Check if user has already applied
        if ($job->applications()->where('user_id', Auth::id())->exists()) {
            return redirect()->route('jobs.show', $job)
                ->with('error', __('site.flash.already_applied'));
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
                ->with('error', __('site.flash.job_deadline_passed'));
        }

        // Check if job is active
        if (!$job->isActive()) {
            return redirect()->route('jobs.show', $job)
                ->with('error', __('site.flash.job_no_longer_accepting'));
        }

        // Check if user has already applied
        if ($job->applications()->where('user_id', Auth::id())->exists()) {
            return redirect()->route('jobs.show', $job)
                ->with('error', __('site.flash.already_applied'));
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

        $documentRuleBase = 'file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120';

        foreach ($job->documents as $document) {
            $rules['documents.' . $document->id] = ($document->is_required ? 'required|' : 'nullable|') . $documentRuleBase;
        }

        $messages = [
            'resume.required' => __('site.jobs.apply.validation.resume_required'),
            'resume.mimes' => __('site.jobs.apply.validation.resume_mimes'),
            'resume.max' => __('site.jobs.apply.validation.resume_max'),
            'documents.*.required' => __('site.jobs.apply.validation.documents_required'),
            'documents.*.mimes' => __('site.jobs.apply.validation.documents_mimes'),
            'documents.*.max' => __('site.jobs.apply.validation.documents_max'),
        ];

        $validated = $request->validate($rules, $messages);

        $cvPath = null;
        $uploadedResume = false;
        if ($hasCv && $request->cv_option === 'profile') {
            $cvPath = $profile->cv_path;
        } elseif ($request->hasFile('resume')) {
            $cvPath = SecureStorage::storeUploadedFile($request->file('resume'), 'resumes');
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
                    $path = SecureStorage::storeUploadedFile($file, 'applications/documents');
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
                SecureStorage::delete($path);
            }
            if ($uploadedResume && $cvPath) {
                SecureStorage::delete($cvPath);
            }
            throw $e;
        }

        $this->sendStatusNotifications($application, 'pending');

        return redirect()->route('jobs.show', $job)
            ->with('success', __('site.flash.application_submitted'));
    }

    /**
     * Display user's applications
     */
    public function myApplications(Request $request)
    {
        $userId = Auth::id();
        $query = Application::with([
            'job' => function ($q) {
                $q->withTrashed()
                    ->with(['subCategory.category', 'questions', 'documents']);
            },
            'questionAnswers.question',
            'documents.jobDocument',
            'documentRequests',
        ])
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

        // Check if user has applications with pending document requests
        $hasPendingDocuments = Application::where('user_id', Auth::id())
            ->where('status', 'documents_requested')
            ->whereHas('documentRequests', function ($q) {
                $q->where('is_submitted', false);
            })
            ->exists();

        return view('applications.index', compact('applications', 'hasPendingDocuments'));
    }

    /**
     * Upload requested documents for an application
     */
    public function uploadRequestedDocuments(Request $request, Application $application)
    {
        // Ensure the application belongs to the authenticated user
        if ($application->user_id !== Auth::id()) {
            abort(403);
        }

        // Validate that the application status allows document uploads
        if (!in_array($application->status, ['documents_requested', 'documents_submitted'])) {
            return redirect()->back()->with('error', __('site.flash.documents_upload_unavailable'));
        }

        $application->loadMissing('documentRequests');

        $documentRequests = $application->documentRequests;
        $documentRuleBase = 'file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120';
        $hasPending = $documentRequests->contains(fn($doc) => !$doc->is_submitted);

        $rules = [
            'documents' => ($hasPending ? 'required' : 'nullable') . '|array',
        ];

        foreach ($documentRequests as $docRequest) {
            $rules['documents.' . $docRequest->id] = ($docRequest->is_submitted ? 'nullable|' : 'required|') . $documentRuleBase;
        }

        $messages = [
            'documents.required' => __('site.jobs.apply.validation.documents_required'),
            'documents.*.required' => __('site.jobs.apply.validation.documents_required'),
            'documents.*.mimes' => __('site.jobs.apply.validation.documents_mimes'),
            'documents.*.max' => __('site.jobs.apply.validation.documents_max'),
        ];

        $validated = $request->validate($rules, $messages);

        $uploadedDocuments = $documentRequests->filter(fn($doc) => $request->hasFile('documents.' . $doc->id));

        if (!$hasPending && $uploadedDocuments->isEmpty()) {
            return redirect()->back()->with('error', __('site.flash.documents_no_changes'));
        }
        $storedFiles = [];
        $oldPaths = [];
        $shouldNotifyDocumentsSubmitted = false;

        DB::beginTransaction();

        try {
            foreach ($documentRequests as $docRequest) {
                if (!$request->hasFile('documents.' . $docRequest->id)) {
                    continue;
                }

                $file = $request->file('documents.' . $docRequest->id);
                $path = SecureStorage::storeUploadedFile($file, 'applications/requested-documents');
                $storedFiles[] = $path;
                $oldPaths[] = $docRequest->file_path;

                $docRequest->update([
                    'is_submitted' => true,
                    'submitted_at' => now(),
                    'file_path' => $path,
                    'original_name' => $file->getClientOriginalName(),
                ]);
            }

            $allSubmitted = $application->documentRequests()
                ->where('is_submitted', false)
                ->doesntExist();

            if ($allSubmitted && $application->status === 'documents_requested') {
                $application->update(['status' => 'documents_submitted']);
                $shouldNotifyDocumentsSubmitted = true;
            }

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            foreach ($storedFiles as $path) {
                SecureStorage::delete($path);
            }
            throw $e;
        }

        if ($shouldNotifyDocumentsSubmitted) {
            $this->sendStatusNotifications($application, 'documents_submitted');
        }

        foreach ($oldPaths as $oldPath) {
            if ($oldPath) {
                SecureStorage::delete($oldPath);
            }
        }

        return redirect()->back()->with('success', __('site.flash.documents_uploaded'));
    }

    public function updateSupportingDocument(Request $request, Application $application, ApplicationDocument $document)
    {
        if ($application->user_id !== Auth::id()) {
            abort(403);
        }

        if ($document->application_id !== $application->id) {
            abort(404);
        }

        if ($application->status !== 'pending') {
            return redirect()->back()->with('error', __('site.flash.document_update_unavailable'));
        }

        $messages = [
            'document.required' => __('site.jobs.apply.validation.documents_required'),
            'document.mimes' => __('site.jobs.apply.validation.documents_mimes'),
            'document.max' => __('site.jobs.apply.validation.documents_max'),
        ];

        $request->validate([
            'document' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
            'document_id' => 'sometimes|integer',
        ], $messages);

        $file = $request->file('document');
        $oldPath = $document->file_path;

        DB::beginTransaction();

        try {
            $newPath = SecureStorage::storeUploadedFile($file, 'applications/documents');

            $document->update([
                'file_path' => $newPath,
                'original_name' => $file->getClientOriginalName(),
            ]);

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            if (isset($newPath)) {
                SecureStorage::delete($newPath);
            }
            throw $e;
        }

        if (!empty($oldPath)) {
            SecureStorage::delete($oldPath);
        }

        return redirect()->back()->with('success', __('site.flash.document_updated'));
    }
}


