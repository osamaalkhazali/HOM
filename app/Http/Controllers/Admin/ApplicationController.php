<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Job;
use App\Models\ApplicationDocumentRequest;
use Illuminate\Http\Request;
use App\Notifications\ApplicationStatusChanged;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ApplicationController extends Controller
{
  /**
   * Display a listing of applications with filtering and sorting
   */
  public function index(Request $request)
  {
    $query = Application::with([
      'user' => function ($q) {
        $q->withTrashed();
      },
      'user.profile',
      'job' => function ($q) {
        $q->withTrashed();
      },
      'job.subCategory.category',
      'questionAnswers',
      'documents',
      'documentRequests'
    ]);

    // Enhanced search functionality - searches across applicant, job, and application data
    if ($request->filled('search')) {
      $search = $request->search;
      $query->where(function ($q) use ($search) {
        // Search in applicant data
        $q->whereHas('user', function ($userQuery) use ($search) {
          $userQuery->withTrashed()
            ->where('name', 'like', "%{$search}%")
            ->orWhere('email', 'like', "%{$search}%")
            ->orWhere('phone', 'like', "%{$search}%")
            // Search in applicant's profile
            ->orWhereHas('profile', function ($profileQuery) use ($search) {
              $profileQuery->where('headline', 'like', "%{$search}%")
                ->orWhere('current_position', 'like', "%{$search}%")
                ->orWhere('skills', 'like', "%{$search}%")
                ->orWhere('location', 'like', "%{$search}%");
            });
        })
          // Search in job data
          ->orWhereHas('job', function ($jobQuery) use ($search) {
          $jobQuery->where('title', 'like', "%{$search}%")
              ->orWhere('title_ar', 'like', "%{$search}%")
              ->orWhere('company', 'like', "%{$search}%")
              ->orWhere('company_ar', 'like', "%{$search}%")
              ->orWhere('location', 'like', "%{$search}%")
              ->orWhere('location_ar', 'like', "%{$search}%");
          })
          // Search in cover letter
          ->orWhere('cover_letter', 'like', "%{$search}%")
          // Search in question answers
          ->orWhereHas('questionAnswers', function ($answerQuery) use ($search) {
            $answerQuery->where('answer', 'like', "%{$search}%");
        });
      });
    }

    // Filter by status
    if ($request->filled('status')) {
      $query->where('status', $request->status);
    }

    // Filter by job
    if ($request->filled('job_id')) {
      $query->where('job_id', $request->job_id);
    }

    // Filter by category
    if ($request->filled('category_id')) {
      $query->whereHas('job.subCategory', function ($q) use ($request) {
        $q->where('category_id', $request->category_id);
      });
    }

    // Filter by applications with question answers
    if ($request->filled('has_answers')) {
      if ($request->has_answers === 'yes') {
        $query->has('questionAnswers');
      } elseif ($request->has_answers === 'no') {
        $query->doesntHave('questionAnswers');
      }
    }

    // Filter by applications with additional documents
    if ($request->filled('has_documents')) {
      if ($request->has_documents === 'yes') {
        $query->has('documents');
      } elseif ($request->has_documents === 'no') {
        $query->doesntHave('documents');
      }
    }

    // Filter by applications with cover letter
    if ($request->filled('has_cover_letter')) {
      if ($request->has_cover_letter === 'yes') {
        $query->whereNotNull('cover_letter')->where('cover_letter', '!=', '');
      } elseif ($request->has_cover_letter === 'no') {
        $query->where(function ($q) {
          $q->whereNull('cover_letter')->orWhere('cover_letter', '');
        });
      }
    }

    // Filter by date range
    if ($request->filled('date_from')) {
      $query->whereDate('created_at', '>=', $request->date_from);
    }
    if ($request->filled('date_to')) {
      $query->whereDate('created_at', '<=', $request->date_to);
    }

    // Sorting
    $sortBy = $request->get('sort', 'created_at');
    $sortDirection = $request->get('direction', 'desc');

    $allowedSorts = ['created_at', 'status'];
    if (in_array($sortBy, $allowedSorts)) {
      $query->orderBy($sortBy, $sortDirection);
    } elseif ($sortBy === 'user_name') {
      $query->join('users', 'applications.user_id', '=', 'users.id')
        ->orderBy('users.name', $sortDirection)
        ->select('applications.*');
    } elseif ($sortBy === 'job_title') {
      $query->join('jobs', 'applications.job_id', '=', 'jobs.id')
        ->orderBy('jobs.title', $sortDirection)
        ->select('applications.*');
    }

    $applications = $query->paginate(15)->withQueryString();
    $jobs = Job::select('id', 'title', 'company')->get();
    $categories = \App\Models\Category::all();

    return view('admin.applications.index', compact('applications', 'jobs', 'categories'));
  }

  /**
   * Display the specified application
   */
  public function show(Application $application)
  {
    $application->load([
      'user' => function ($q) {
        $q->withTrashed();
      },
      'user.profile',
      'job' => function ($q) {
        $q->withTrashed();
      },
      'job.subCategory.category',
      'questionAnswers.question',
      'documents.jobDocument',
      'documentRequests'
    ]);
    return view('admin.applications.show', compact('application'));
  }

  /**
   * Show the form for editing the specified application
   */
  public function edit(Application $application)
  {
    $application->load([
      'user' => function ($q) {
        $q->withTrashed();
      },
      'user.profile',
      'job' => function ($q) {
        $q->withTrashed();
      },
      'job.subCategory.category',
      'questionAnswers.question',
      'documents.jobDocument',
      'documentRequests'
    ]);
    return view('admin.applications.edit', compact('application'));
  }

  /**
   * Update the specified application
   */
  public function update(Request $request, Application $application)
  {
    $validated = $request->validate([
      'status' => 'required|in:pending,under_reviewing,reviewed,shortlisted,documents_requested,documents_submitted,rejected,hired',
      'notes' => 'nullable|string|max:1000',
      'interview_date' => 'nullable|date|after:now',
      'interview_notes' => 'nullable|string|max:1000',
      'document_requests' => 'nullable|array',
      'document_requests.*.id' => 'nullable|integer|exists:application_document_requests,id',
      'document_requests.*.name' => 'nullable|string|max:255',
      'document_requests.*.name_ar' => 'nullable|string|max:255',
      'document_requests.*.notes' => 'nullable|string|max:500',
      'document_requests.*.is_submitted' => 'nullable|boolean',
      'document_requests.*._delete' => 'nullable|boolean'
    ]);

    $application->load('documentRequests');

    $requestsPayload = collect($validated['document_requests'] ?? [])
      ->map(function ($item, $index) {
        $deleteRequested = !empty($item['_delete']);
        $name = trim($item['name'] ?? '');
        $nameAr = trim($item['name_ar'] ?? '');
        $notes = trim($item['notes'] ?? '');

        return [
          'index' => $index,
          'id' => $item['id'] ?? null,
          'name' => $deleteRequested ? null : ($name === '' ? null : $name),
          'name_ar' => $deleteRequested ? null : ($nameAr === '' ? null : $nameAr),
          'notes' => $deleteRequested ? null : ($notes === '' ? null : $notes),
          'is_submitted' => !$deleteRequested && !empty($item['is_submitted']),
          'delete' => $deleteRequested,
        ];
      });

    $remainingRequests = $application->documentRequests->count();

    $requestsPayload->each(function ($payload) use (&$remainingRequests) {
      if (!empty($payload['id'])) {
        if ($payload['delete']) {
          $remainingRequests = max(0, $remainingRequests - 1);
        }
      } elseif (!$payload['delete'] && !blank($payload['name'])) {
        $remainingRequests++;
      }

      if (!$payload['delete']) {
        if (blank($payload['name'])) {
          throw ValidationException::withMessages([
            "document_requests.{$payload['index']}.name" => 'Please provide the document name in English.',
          ]);
        }
        if (blank($payload['name_ar'])) {
          throw ValidationException::withMessages([
            "document_requests.{$payload['index']}.name_ar" => 'Please provide the document name in Arabic.',
          ]);
        }
      }
    });

    if ($validated['status'] === 'documents_requested') {
      if ($application->status !== 'shortlisted') {
        throw ValidationException::withMessages([
          'status' => 'You can only request documents after shortlisting the application.',
        ]);
      }

      if ($remainingRequests <= 0) {
        throw ValidationException::withMessages([
          'status' => 'Add at least one document request before moving to Documents Requested.',
        ]);
      }
    }

    if ($validated['status'] === 'documents_submitted' && $remainingRequests <= 0) {
      throw ValidationException::withMessages([
        'status' => 'Add at least one document request before marking documents as received.',
      ]);
    }

    // Auto-change status to documents_requested when adding document requests from shortlisted
    if ($application->status === 'shortlisted' && $remainingRequests > 0 && $validated['status'] === 'shortlisted') {
      $validated['status'] = 'documents_requested';
    }

    DB::transaction(function () use ($application, $validated, $requestsPayload) {
      $application->update([
        'status' => $validated['status'],
        'notes' => $validated['notes'] ?? null,
        'interview_date' => $validated['interview_date'] ?? null,
        'interview_notes' => $validated['interview_notes'] ?? null,
      ]);

      $requestsPayload->each(function ($payload) use ($application) {
        $existing = null;
        if (!empty($payload['id'])) {
          $existing = $application->documentRequests()->find($payload['id']);
        }

        if ($existing) {
          if ($payload['delete']) {
            $existing->delete();
            return;
          }

          $updateData = [
            'name' => $payload['name'] ?? $existing->name,
            'name_ar' => $payload['name_ar'],
            'notes' => $payload['notes'],
            'is_submitted' => $payload['is_submitted'],
          ];

          if ($payload['is_submitted'] && !$existing->is_submitted) {
            $updateData['submitted_at'] = now();
          }

          if (!$payload['is_submitted']) {
            $updateData['submitted_at'] = null;
          }

          $existing->update($updateData);
          return;
        }

        if ($payload['delete']) {
          return;
        }

        if (blank($payload['name'])) {
          return;
        }

        $application->documentRequests()->create([
          'name' => $payload['name'],
          'name_ar' => $payload['name_ar'],
          'notes' => $payload['notes'],
          'is_submitted' => $payload['is_submitted'],
          'submitted_at' => $payload['is_submitted'] ? now() : null,
        ]);
      });
    });

    return redirect()->route('admin.applications.show', $application)
      ->with('success', 'Application updated successfully');
  }

  /**
   * Update the application status
   */
  public function updateStatus(Request $request, Application $application)
  {
    $validated = $request->validate([
      'status' => 'required|in:pending,under_reviewing,reviewed,shortlisted,documents_requested,documents_submitted,rejected,hired'
    ]);

    if ($validated['status'] === 'documents_requested') {
      if ($application->status !== 'shortlisted') {
        return redirect()->back()->with('error', 'Set the application to Shortlisted before requesting documents.');
      }

      if ($application->documentRequests()->count() === 0) {
        return redirect()->back()->with('error', 'Add at least one document request before moving to Documents Requested.');
      }
    }

    if ($validated['status'] === 'documents_submitted') {
      if (!in_array($application->status, ['documents_requested', 'documents_submitted'])) {
        return redirect()->back()->with('error', 'Mark documents as requested before confirming submission.');
      }

      if ($application->documentRequests()->count() === 0) {
        return redirect()->back()->with('error', 'Add at least one document request before marking documents as received.');
      }
    }

    $oldStatus = $application->status;
    $application->update($validated);

    // Notify the applicant about status change
    try {
      $application->load(['job', 'user']);
      if ($application->user) {
        Notification::send($application->user, new ApplicationStatusChanged($application, $oldStatus, $application->status));
      }
    } catch (\Throwable $e) {
      report($e);
    }

    return redirect()->back()->with('success', 'Application status updated successfully');
  }

  /**
   * Update multiple applications status
   */
  public function bulkUpdateStatus(Request $request)
  {
    $validated = $request->validate([
      'application_ids' => 'required|array',
      'application_ids.*' => 'exists:applications,id',
      'status' => 'required|in:pending,under_reviewing,reviewed,shortlisted,documents_requested,documents_submitted,rejected,hired'
    ]);

    Application::whereIn('id', $validated['application_ids'])
      ->update(['status' => $validated['status']]);

    $count = count($validated['application_ids']);
    return redirect()->back()->with('success', "Successfully updated {$count} applications");
  }

  /**
   * Delete multiple applications
   */
  public function bulkDelete(Request $request)
  {
    $validated = $request->validate([
      'application_ids' => 'required|array',
      'application_ids.*' => 'exists:applications,id'
    ]);

    Application::whereIn('id', $validated['application_ids'])->delete();

    $count = count($validated['application_ids']);
    return redirect()->back()->with('success', "Successfully deleted {$count} applications");
  }

  /**
   * Remove the specified application
   */
  public function destroy(Application $application)
  {
    $application->delete();
    return redirect()->route('admin.applications.index')->with('success', 'Application deleted successfully');
  }

  /**
   * View or download a submitted document
   */
  public function viewDocument(ApplicationDocumentRequest $document)
  {
    // Ensure the document has been submitted
    if (!$document->is_submitted || !$document->file_path) {
      abort(404, 'Document not found');
    }

    // Check if file exists
    if (!\Storage::disk('public')->exists($document->file_path)) {
      abort(404, 'File not found');
    }

    // Get file path and determine type
    $path = storage_path('app/public/' . $document->file_path);
    $mimeType = \Storage::disk('public')->mimeType($document->file_path);

    // Return file response
    return response()->file($path, [
      'Content-Type' => $mimeType,
      'Content-Disposition' => 'inline; filename="' . $document->original_name . '"'
    ]);
  }
}
