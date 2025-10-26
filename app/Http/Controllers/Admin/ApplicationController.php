<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Concerns\SendsApplicationStatusNotifications;
use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Job;
use App\Models\ApplicationDocumentRequest;
use App\Models\Admin;
use App\Services\Admin\AdminExportService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class ApplicationController extends Controller
{
    use SendsApplicationStatusNotifications;
    protected AdminExportService $exportService;

    public function __construct(AdminExportService $exportService)
    {
        $this->exportService = $exportService;
    }

    /**
     * Display a listing of applications with filtering and sorting
     */
  public function index(Request $request)
  {
        $query = $this->baseQuery();

        $this->applyFilters($request, $query);
        $this->applySorting($request, $query);

        $applications = $query->paginate(15)->withQueryString();
        $jobs = Job::select('id', 'title', 'company')->get();
        $categories = \App\Models\Category::all();
        $exportQuery = $request->except(['page']);

        return view('admin.applications.index', compact('applications', 'jobs', 'categories', 'exportQuery'));
    }

    protected function baseQuery(): Builder
    {
        return Application::with([
      'user' => function ($q) {
        $q->withTrashed();
      },
      'user.profile',
      'job' => function ($q) {
        $q->withTrashed();
      },
            'job.category',
      'job.subCategory.category',
            'questionAnswers.question',
            'documents.jobDocument',
            'documentRequests',
    ]);
    }

    protected function applyFilters(Request $request, Builder $query): void
    {
    if ($request->filled('search')) {
      $search = $request->search;
            $query->where(function ($q) use ($search) {
        $q->whereHas('user', function ($userQuery) use ($search) {
          $userQuery->withTrashed()
            ->where('name', 'like', "%{$search}%")
            ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%")
            ->orWhereHas('profile', function ($profileQuery) use ($search) {
              $profileQuery->where('headline', 'like', "%{$search}%")
                ->orWhere('current_position', 'like', "%{$search}%")
                ->orWhere('skills', 'like', "%{$search}%")
                ->orWhere('location', 'like', "%{$search}%");
            });
                })
                    ->orWhereHas('job', function ($jobQuery) use ($search) {
          $jobQuery->where('title', 'like', "%{$search}%")
                        ->orWhere('title_ar', 'like', "%{$search}%")
                        ->orWhere('company', 'like', "%{$search}%")
                        ->orWhere('company_ar', 'like', "%{$search}%")
                        ->orWhere('location', 'like', "%{$search}%")
                        ->orWhere('location_ar', 'like', "%{$search}%");
                })
                    ->orWhere('cover_letter', 'like', "%{$search}%")
                    ->orWhereHas('questionAnswers', function ($answerQuery) use ($search) {
                        $answerQuery->where('answer', 'like', "%{$search}%");
        });
      });
    }

        if ($request->filled('status')) {
      $query->where('status', $request->status);
    }

        if ($request->filled('job_id')) {
      $query->where('job_id', $request->job_id);
    }

        if ($request->filled('category_id')) {
      $query->whereHas('job.subCategory', function ($q) use ($request) {
        $q->where('category_id', $request->category_id);
      });
    }

        if ($request->filled('has_answers')) {
      if ($request->has_answers === 'yes') {
        $query->has('questionAnswers');
      } elseif ($request->has_answers === 'no') {
        $query->doesntHave('questionAnswers');
      }
    }

        if ($request->filled('has_documents')) {
      if ($request->has_documents === 'yes') {
        $query->has('documents');
      } elseif ($request->has_documents === 'no') {
        $query->doesntHave('documents');
      }
    }

        if ($request->filled('has_cover_letter')) {
      if ($request->has_cover_letter === 'yes') {
        $query->whereNotNull('cover_letter')->where('cover_letter', '!=', '');
      } elseif ($request->has_cover_letter === 'no') {
        $query->where(function ($q) {
          $q->whereNull('cover_letter')->orWhere('cover_letter', '');
        });
      }
    }

        if ($request->filled('date_from')) {
      $query->whereDate('created_at', '>=', $request->date_from);
    }

        if ($request->filled('date_to')) {
      $query->whereDate('created_at', '<=', $request->date_to);
    }
    }

    protected function applySorting(Request $request, Builder $query): void
    {
    $sortBy = $request->get('sort', 'created_at');
    $sortDirection = $request->get('direction', 'desc');

    $allowedSorts = ['created_at', 'status'];
        if (in_array($sortBy, $allowedSorts, true)) {
      $query->orderBy($sortBy, $sortDirection);
            return;
        }

        if ($sortBy === 'user_name') {
      $query->join('users', 'applications.user_id', '=', 'users.id')
        ->orderBy('users.name', $sortDirection)
        ->select('applications.*');
            return;
        }

        if ($sortBy === 'job_title') {
      $query->join('jobs', 'applications.job_id', '=', 'jobs.id')
        ->orderBy('jobs.title', $sortDirection)
        ->select('applications.*');
    }
    }

    public function export(Request $request, string $format)
    {
        $scope = $request->get('scope', 'filtered');
        $query = $this->baseQuery();

        if ($scope !== 'all') {
            $this->applyFilters($request, $query);
        }

        $this->applySorting($request, $query);

        $applications = $query->get();

        if ($applications->isEmpty()) {
            return redirect()->route('admin.applications.index', $request->except(['page', 'scope']))
                ->with('warning', 'No applications available for export with the selected filters.');
        }

        [$headings, $rows, $meta] = $this->buildApplicationExportRows($applications, $request, $scope);

        $fileName = 'applications_' . now()->format('Ymd_His');

        return $this->exportService->download($format, $fileName, $headings, $rows, $meta);
    }

    /**
     * @return array{0: array<int, string>, 1: array<int, array<int, string|int|float|null>>, 2: array<string, mixed>}
     */
    protected function buildApplicationExportRows(Collection $applications, Request $request, string $scope): array
    {
        $headings = [
            '#',
            'Status',
            'Applied At',
            'Applicant Name',
            'Applicant Email',
            'Applicant Phone',
            'Profile Headline',
            'Profile Position',
            'Profile Experience (Years)',
            'Profile Skills',
            'Profile Location',
            'Profile About',
            'CV URL',
            'Job Title (EN)',
            'Job Title (AR)',
            'Job Status',
            'Job Company (EN)',
            'Job Company (AR)',
            'Job Location (EN)',
            'Job Location (AR)',
            'Job Category',
            'Job Subcategory',
            'Job Level',
            'Job Deadline',
            'Cover Letter',
            'Question Answers',
            'Requested Documents',
            'Uploaded Documents',
        ];

        $rowNumber = 0;
        $rows = $applications->map(function (Application $application) use (&$rowNumber) {
            $rowNumber++;
            return $this->mapApplicationRow($application, $rowNumber);
        })->all();

        $meta = [
            'title' => 'Applications Export',
            'description' => 'Total applications: ' . $applications->count() . ($scope === 'all' ? ' (full dataset)' : ' (filtered)'),
            'generated_at' => now()->format('Y-m-d H:i'),
            'filters' => $scope === 'all' ? null : $this->summarizeFilters($request),
        ];

        return [$headings, $rows, $meta];
    }

    /**
     * @return array<int, string|int|float|null>
     */
    protected function mapApplicationRow(Application $application, int $rowNumber): array
    {
        $user = $application->user;
        $profile = $user?->profile;
        $job = $application->job;

        $baseUrl = config('app.url', 'http://www.hom-intl.com');

        // Format question answers with numbering
        $questionAnswers = $application->questionAnswers->map(function ($answer, $index) {
            $question = $answer->question;
            $label = $question?->question ?? $question?->question_ar ?? ('Question #' . $answer->id);
            return ($index + 1) . '- ' . trim($label . ': ' . $answer->answer);
        })->filter()->join(' | ');

        // Format requested documents with numbering and URLs
        $requestedDocuments = $application->documentRequests->map(function ($request, $index) use ($baseUrl) {
            $status = $request->is_submitted ? 'Submitted' : 'Pending';
            $docName = $request->name ?: 'Document';

            if ($request->file_path) {
                $url = $baseUrl . Storage::url($request->file_path);
                $fileInfo = $request->original_name . ' [' . $url . ']';
            } else {
                $fileInfo = 'No file';
            }

            return ($index + 1) . '- ' . $docName . ': ' . $status . ' - ' . $fileInfo;
        })->filter()->join(' | ');

        // Format uploaded documents with numbering and URLs
        $uploadedDocuments = $application->documents->map(function ($doc, $index) use ($baseUrl) {
            $jobDocument = $doc->jobDocument;
            $name = $jobDocument?->name ?? $doc->original_name ?? 'Document';
            $url = $baseUrl . Storage::url($doc->file_path);
            return ($index + 1) . '- ' . $name . ': ' . $doc->original_name . ' [' . $url . ']';
        })->filter()->join(' | ');

        $cvPath = $application->cv_path ?: ($profile->cv_path ?? null);
        $cvUrl = $cvPath ? $baseUrl . Storage::url($cvPath) : '—';

        $deadline = $job && $job->deadline ? $job->deadline->format('Y-m-d') : '—';

        // Get job category - try to get from category relationship or from subcategory's category
        $jobCategory = null;
        if ($job) {
            if ($job->category) {
                $jobCategory = $job->category->name;
            } elseif ($job->subCategory && $job->subCategory->category) {
                $jobCategory = $job->subCategory->category->name;
            }
        }

        return [
            $rowNumber,
            Str::headline($application->status),
            optional($application->created_at)->format('Y-m-d H:i'),
            $user->name ?? '—',
            $user->email ?? '—',
            $user->phone ?? '—',
            $profile->headline ?? '—',
            $profile->current_position ?? '—',
            $profile->experience_years ?? '—',
            $profile->skills ?? '—',
            $profile->location ?? '—',
            $profile->about ?? '—',
            $cvUrl,
            $job->title ?? '—',
            $job->title_ar ?? '—',
            $job ? Str::headline($job->status) : '—',
            $job->company ?? '—',
            $job->company_ar ?? '—',
            $job->location ?? '—',
            $job->location_ar ?? '—',
            $jobCategory ?? '—',
            optional($job->subCategory)->name ?? '—',
            $job ? Str::headline($job->level) : '—',
            $deadline,
            $application->cover_letter ?? '—',
            $questionAnswers ?: '—',
            $requestedDocuments ?: '—',
            $uploadedDocuments ?: '—',
        ];
    }

    protected function summarizeFilters(Request $request): ?string
    {
        $filters = collect($request->except(['page', 'sort', 'direction', 'scope', 'format']))
            ->filter(function ($value) {
                return !is_null($value) && $value !== '';
            })
            ->map(function ($value, $key) {
                $label = Str::headline(str_replace('_', ' ', $key));
                if (is_array($value)) {
                    $value = implode(', ', $value);
                }
                return $label . ': ' . $value;
            });

        return $filters->isEmpty() ? null : $filters->join('; ');
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

        $previousStatus = $application->status;

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

        $application->refresh();

        if ($previousStatus !== $application->status) {
            $this->sendStatusNotifications($application, $application->status);
        }

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
    $newStatus = $validated['status'];

    $application->update(['status' => $newStatus]);

    if ($oldStatus !== $newStatus) {
            $this->sendStatusNotifications($application, $newStatus);
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

    $newStatus = $validated['status'];
    $applications = Application::with(['job', 'user'])
      ->whereIn('id', $validated['application_ids'])
      ->get();

    if ($applications->isEmpty()) {
      return redirect()->back()->with('warning', 'No applications were updated.');
    }

    $admins = Admin::active()->get();

    foreach ($applications as $app) {
      $oldStatus = $app->status;

      $app->update(['status' => $newStatus]);

      if ($oldStatus === $newStatus) {
        continue;
      }

            $this->sendStatusNotifications($app, $newStatus, $admins);
    }

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
