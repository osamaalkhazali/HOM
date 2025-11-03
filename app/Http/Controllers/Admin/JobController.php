<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Job;
use App\Models\Category;
use App\Models\SubCategory;
use App\Services\Admin\AdminExportService;
use App\Support\RichText;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class JobController extends Controller
{
    protected AdminExportService $exportService;

    public function __construct(AdminExportService $exportService)
    {
        $this->exportService = $exportService;
    }

    /**
     * Display a listing of jobs with filtering and sorting
     */
  public function index(Request $request)
  {
        $query = $this->baseIndexQuery();

        $this->applyIndexFilters($request, $query);
        $this->applyIndexSorting($request, $query);

        $jobs = $query->withCount('applications')->paginate(15)->withQueryString();
        $categories = Category::all();
    $clients = Client::orderBy('name')->get(['id', 'name']);
    $exportQuery = $request->except(['page']);

    return view('admin.jobs.index', compact('jobs', 'categories', 'clients', 'exportQuery'));
    }

    protected function baseIndexQuery(): Builder
    {
        $query = Job::with([
            'client',
            'category',
            'subCategory.category',
            'postedBy',
            'applications',
            'applications.user',
            'questions',
            'documents',
        ]);

        // Scope to client for Client HR role
        if (auth('admin')->user()->isClientHr()) {
            $query->where('client_id', auth('admin')->user()->client_id);
        }

        return $query;
    }

    protected function applyIndexFilters(Request $request, Builder $query): void
    {
        if ($request->filled('search')) {
      $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
          ->orWhere('title_ar', 'like', "%{$search}%")
          ->orWhere('company', 'like', "%{$search}%")
          ->orWhere('company_ar', 'like', "%{$search}%")
          ->orWhere('location', 'like', "%{$search}%")
          ->orWhere('location_ar', 'like', "%{$search}%")
          ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('description_ar', 'like', "%{$search}%")
                    ->orWhere('salary', 'like', "%{$search}%")
                    ->orWhere('level', 'like', "%{$search}%")
                    ->orWhereHas('category', function ($catQuery) use ($search) {
                        $catQuery->where('name', 'like', "%{$search}%")
                        ->orWhere('name_ar', 'like', "%{$search}%");
                    })
                    ->orWhereHas('subCategory', function ($subCatQuery) use ($search) {
                        $subCatQuery->where('name', 'like', "%{$search}%")
                        ->orWhere('name_ar', 'like', "%{$search}%");
                    })
                    ->orWhereHas('questions', function ($questionQuery) use ($search) {
                        $questionQuery->where('question', 'like', "%{$search}%")
                            ->orWhere('question_ar', 'like', "%{$search}%");
                    })
                    ->orWhereHas('documents', function ($docQuery) use ($search) {
                        $docQuery->where('name', 'like', "%{$search}%")
                            ->orWhere('name_ar', 'like', "%{$search}%");
                    });
      });
    }

        if ($request->filled('category')) {
      $query->whereHas('subCategory', function ($q) use ($request) {
        $q->where('category_id', $request->category);
      });
    }

        if ($request->filled('subcategory')) {
      $query->where('sub_category_id', $request->subcategory);
    }

        if ($request->filled('status')) {
      $query->where('status', $request->status);
    }

        if ($request->filled('level')) {
      $query->where('level', $request->level);
    }

        if ($request->filled('has_applications')) {
            if ($request->has_applications === 'yes') {
                $query->has('applications');
            } elseif ($request->has_applications === 'no') {
                $query->doesntHave('applications');
            }
        }

        if ($request->filled('has_questions')) {
            if ($request->has_questions === 'yes') {
                $query->has('questions');
            } elseif ($request->has_questions === 'no') {
                $query->doesntHave('questions');
            }
        }

        if ($request->filled('has_documents')) {
            if ($request->has_documents === 'yes') {
                $query->has('documents');
            } elseif ($request->has_documents === 'no') {
                $query->doesntHave('documents');
            }
        }

        if ($request->filled('deadline_status')) {
            if ($request->deadline_status === 'expired') {
                $query->where('deadline', '<', now()->toDateString());
            } elseif ($request->deadline_status === 'active') {
                $query->where('deadline', '>=', now()->toDateString());
            }
        }

        if ($request->filled('date_from')) {
      $query->whereDate('created_at', '>=', $request->date_from);
    }

        if ($request->filled('date_to')) {
      $query->whereDate('created_at', '<=', $request->date_to);
    }

    if ($request->filled('client_id')) {
      $query->where('client_id', $request->client_id);
    }
    }

    protected function applyIndexSorting(Request $request, Builder $query): void
    {
    $sortBy = $request->get('sort', 'created_at');
    $sortDirection = $request->get('direction', 'desc');

    $allowedSorts = ['title', 'company', 'location', 'level', 'created_at', 'deadline'];
        if (in_array($sortBy, $allowedSorts, true)) {
      $query->orderBy($sortBy, $sortDirection);
    }
    }

    public function export(Request $request, string $format)
    {
        $scope = $request->get('scope', 'filtered');
        $query = $this->baseIndexQuery();

        if ($scope !== 'all') {
            $this->applyIndexFilters($request, $query);
        }

        $this->applyIndexSorting($request, $query);

        $jobs = $query->withCount('applications')->get();

        if ($jobs->isEmpty()) {
            return redirect()->route('admin.jobs.index', $request->except(['page', 'scope']))
                ->with('warning', 'No jobs available for export with the selected filters.');
        }

        [$headings, $rows, $meta] = $this->buildJobExportRows($jobs, $request, $scope);

        $fileName = 'jobs_' . now()->format('Ymd_His');

        return $this->exportService->download($format, $fileName, $headings, $rows, $meta);
    }

    /**
     * @return array{0: array<int, string>, 1: array<int, array<int, string|int|float|null>>, 2: array<string, mixed>}
     */
    protected function buildJobExportRows(Collection $jobs, Request $request, string $scope): array
    {
        $headings = [
            'Job ID',
            'Title (EN)',
            'Title (AR)',
            'Status',
            'Active',
            'Level',
            'Salary',
            'Deadline',
            'Company (EN)',
            'Company (AR)',
      'Client',
            'Location (EN)',
            'Location (AR)',
            'Category',
            'Subcategory',
            'Parent Category',
            'Posted By',
            'Created At',
            'Updated At',
            'Deleted At',
            'Applications Count',
            'Applications Breakdown',
            'Questions',
            'Required Documents',
            'Description (EN)',
            'Description (AR)',
        ];

        $rows = $jobs->map(function (Job $job) {
            return $this->mapJobRow($job);
        })->all();

        $meta = [
            'title' => 'Jobs Export',
            'description' => 'Total jobs: ' . $jobs->count() . ($scope === 'all' ? ' (full dataset)' : ' (filtered)'),
            'generated_at' => now()->format('Y-m-d H:i'),
            'filters' => $scope === 'all' ? null : $this->summarizeFilters($request),
        ];

        return [$headings, $rows, $meta];
    }

    /**
     * @return array<int, string|int|float|null>
     */
    protected function mapJobRow(Job $job): array
    {
        $questions = $job->questions->map(function ($question) {
            $label = $question->question ?? $question->question_ar ?? 'Question';
            return $label . ' (' . ($question->is_required ? 'Required' : 'Optional') . ')';
        })->filter()->join(PHP_EOL);

        $documents = $job->documents->map(function ($doc) {
            $label = $doc->name ?? $doc->name_ar ?? 'Document';
            return $label . ' (' . ($doc->is_required ? 'Required' : 'Optional') . ')';
        })->filter()->join(PHP_EOL);

        $applicationsBreakdown = $job->applications->groupBy('status')->map(function ($group, $status) {
            return Str::headline($status) . ': ' . $group->count();
        })->values()->join(PHP_EOL);

        $postedBy = $job->postedBy;
        $deadline = $job->deadline instanceof Carbon ? $job->deadline->format('Y-m-d') : ($job->deadline ? Carbon::parse($job->deadline)->format('Y-m-d') : '—');

        $salary = $job->salary !== null ? number_format((float)$job->salary, 2) : '—';

        return [
            $job->id,
            $job->title ?? '—',
            $job->title_ar ?? '—',
            Str::headline($job->status ?? ''),
            $job->is_active ? 'Yes' : 'No',
            Str::headline($job->level ?? ''),
            $salary,
            $deadline,
            $job->company ?? '—',
            $job->company_ar ?? '—',
      optional($job->client)->name ?? '—',
            $job->location ?? '—',
            $job->location_ar ?? '—',
            optional($job->category)->name ?? '—',
            optional($job->subCategory)->name ?? '—',
            optional($job->subCategory?->category)->name ?? '—',
            $postedBy ? ($postedBy->name . ' <' . $postedBy->email . '>') : '—',
            optional($job->created_at)->format('Y-m-d H:i'),
            optional($job->updated_at)->format('Y-m-d H:i'),
            optional($job->deleted_at)->format('Y-m-d H:i'),
            $job->applications_count ?? $job->applications->count(),
            $applicationsBreakdown ?: '—',
            $questions ?: '—',
            $documents ?: '—',
            $job->description ?? '—',
            $job->description_ar ?? '—',
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
   * Show the form for creating a new job
   */
  public function create()
  {
    $categories = Category::with('subCategories')->get();
    $clients = Client::orderBy('name')->get(['id', 'name']);
        $defaultDeadline = now()->addDays(14);
        $defaultDeadlineDays = 14;

    return view('admin.jobs.create', compact('categories', 'clients', 'defaultDeadline', 'defaultDeadlineDays'));
  }

  /**
   * Store a newly created job
   */
  public function store(Request $request)
  {
        $useCustomDeadline = $request->boolean('use_custom_deadline');

        if (!$useCustomDeadline) {
            $request->merge([
                'deadline' => now()->addDays(14)->toDateString(),
            ]);
        }

        // Validate basic fields first
        $validated = $request->validate([
      'title' => 'required|string|max:255',
      'title_ar' => 'nullable|string|max:255',
      'description' => 'required|string',
      'description_ar' => 'nullable|string',
      'category_id' => 'required|exists:categories,id',
      'sub_category_id' => 'nullable|exists:sub_categories,id',
      'company' => 'required|string|max:255',
      'company_ar' => 'nullable|string|max:255',
      'client_id' => 'required|exists:clients,id',
      'location' => 'required|string|max:255',
      'location_ar' => 'nullable|string|max:255',
      'level' => 'required|in:entry,mid,senior,executive',
      'deadline' => 'required|date|after:today',
      'status' => 'required|in:active,inactive,draft',
      'questions' => 'nullable|array',
      'questions.*.question' => 'nullable|string|max:500',
      'questions.*.question_ar' => 'nullable|string|max:500',
      'questions.*.is_required' => 'nullable|boolean',
      'documents' => 'nullable|array',
      'documents.*.name' => 'nullable|string|max:255',
      'documents.*.name_ar' => 'nullable|string|max:255',
      'documents.*.is_required' => 'nullable|boolean',
    ]);

    $questionsInput = $validated['questions'] ?? [];
    $documentsInput = $validated['documents'] ?? [];
    unset($validated['questions'], $validated['documents']);

    $validated['description'] = RichText::sanitize($validated['description']);
    if (!$validated['description']) {
      throw ValidationException::withMessages([
        'description' => 'The description field must not be empty.',
      ]);
    }

    $validated['description_ar'] = RichText::sanitize($validated['description_ar'] ?? null);

    $validated['posted_by'] = auth('admin')->id();
        $validated['is_active'] = $validated['status'] === 'active';

    DB::transaction(function () use ($validated, $questionsInput, $documentsInput) {
      $job = Job::create($validated);
      $this->syncJobQuestions($job, $questionsInput);
      $this->syncJobDocuments($job, $documentsInput);
    });

    return redirect()->route('admin.jobs.index')->with('success', 'Job created successfully');
  }

  /**
   * Display the specified job
   */
  public function show(Job $job)
  {
    // Check if Client HR user has access to this job
    if (auth('admin')->user()->isClientHr()) {
        if ($job->client_id !== auth('admin')->user()->client_id) {
            abort(403, 'You do not have permission to view this job.');
        }
    }

    $job->load(['category', 'subCategory', 'postedBy', 'applications.user', 'questions', 'documents', 'client']);
    return view('admin.jobs.show', compact('job'));
  }

  /**
   * Show the form for editing the specified job
   */
  public function edit(Job $job)
  {
    $job->load(['questions', 'documents']);
    $categories = Category::with('subCategories')->get();
    $clients = Client::orderBy('name')->get(['id', 'name']);
    return view('admin.jobs.edit', compact('job', 'categories', 'clients'));
  }

  /**
   * Update the specified job
   */
  public function update(Request $request, Job $job)
  {
    // Validate basic fields first
    $validated = $request->validate([
      'title' => 'required|string|max:255',
      'title_ar' => 'nullable|string|max:255',
      'description' => 'required|string',
      'description_ar' => 'nullable|string',
      'category_id' => 'required|exists:categories,id',
      'sub_category_id' => 'nullable|exists:sub_categories,id',
      'company' => 'required|string|max:255',
      'company_ar' => 'nullable|string|max:255',
      'client_id' => 'required|exists:clients,id',
      'location' => 'required|string|max:255',
      'location_ar' => 'nullable|string|max:255',
      'level' => 'required|in:entry,mid,senior,executive',
      'deadline' => 'required|date',
      'status' => 'required|in:active,inactive,draft',
      'questions' => 'nullable|array',
      'questions.*.question' => 'nullable|string|max:500',
      'questions.*.question_ar' => 'nullable|string|max:500',
      'questions.*.is_required' => 'nullable|boolean',
      'documents' => 'nullable|array',
      'documents.*.name' => 'nullable|string|max:255',
      'documents.*.name_ar' => 'nullable|string|max:255',
      'documents.*.is_required' => 'nullable|boolean',
    ]);

    $questionsInput = $validated['questions'] ?? [];
    $documentsInput = $validated['documents'] ?? [];
    unset($validated['questions'], $validated['documents']);

    $validated['description'] = RichText::sanitize($validated['description']);
    if (!$validated['description']) {
      throw ValidationException::withMessages([
        'description' => 'The description field must not be empty.',
      ]);
    }

    $validated['description_ar'] = RichText::sanitize($validated['description_ar'] ?? null);

    $validated['is_active'] = $validated['status'] === 'active';

        DB::transaction(function () use ($job, $validated, $questionsInput, $documentsInput) {
      $job->update($validated);
      $this->syncJobQuestions($job, $questionsInput);
      $this->syncJobDocuments($job, $documentsInput);
    });

    return redirect()->route('admin.jobs.index')->with('success', 'Job updated successfully');
  }

  /**
   * Remove the specified job
   */
  public function destroy(Job $job)
  {
    $job->delete();
    return redirect()->route('admin.jobs.index')->with('success', 'Job deleted successfully');
  }

    /**
     * Extend the job application deadline by 14 days.
     */
    public function extendDeadline(Job $job)
    {
        // Always extend 14 days from today, not from the old deadline
        $job->deadline = now()->addDays(14);
        $job->save();

        return back()->with('success', 'Job deadline extended by 14 days from today.');
    }

    /**
     * Display a listing of deleted jobs
     */
  public function deleted(Request $request)
  {
    $query = Job::onlyTrashed()->with(['category', 'subCategory', 'postedBy', 'applications', 'client']);

    // Search functionality for deleted jobs
    if ($request->filled('search')) {
      $search = $request->search;
      $query->where(function ($q) use ($search) {
        $q->where('title', 'like', "%{$search}%")
          ->orWhere('title_ar', 'like', "%{$search}%")
          ->orWhere('company', 'like', "%{$search}%")
          ->orWhere('company_ar', 'like', "%{$search}%")
          ->orWhere('location', 'like', "%{$search}%")
          ->orWhere('location_ar', 'like', "%{$search}%");
      });
    }

    // Filter by category
    if ($request->filled('category')) {
      $query->where(function ($q) use ($request) {
        $q->where('category_id', $request->category)
          ->orWhereHas('subCategory', function ($sq) use ($request) {
            $sq->where('category_id', $request->category);
          });
      });
    }

    // Sorting
    $sortBy = $request->get('sort', 'deleted_at');
    $sortDirection = $request->get('direction', 'desc');

    $allowedSorts = ['title', 'company', 'deleted_at', 'created_at'];
    if (in_array($sortBy, $allowedSorts)) {
      $query->orderBy($sortBy, $sortDirection);
    }

    $jobs = $query->paginate(15)->withQueryString();
    $categories = Category::all();

    return view('admin.jobs.deleted', compact('jobs', 'categories'));
  }

  /**
   * Restore the specified deleted job
   */
  public function restore($id)
  {
    $job = Job::onlyTrashed()->findOrFail($id);
    $job->restore();

    return redirect()->route('admin.jobs.deleted')->with('success', 'Job restored successfully');
  }

  /**
   * Permanently delete the specified job
   */
  public function forceDelete($id)
  {
    $job = Job::onlyTrashed()->findOrFail($id);
    $job->forceDelete();

    return redirect()->route('admin.jobs.deleted')->with('success', 'Job permanently deleted');
  }

  /**
   * Restore all deleted jobs
   */
  public function restoreAll()
  {
    Job::onlyTrashed()->restore();

    return redirect()->route('admin.jobs.deleted')->with('success', 'All jobs restored successfully');
  }

  /**
   * Permanently delete all deleted jobs
   */
  public function forceDeleteAll()
  {
    Job::onlyTrashed()->forceDelete();

    return redirect()->route('admin.jobs.deleted')->with('success', 'All jobs permanently deleted');
  }

  /**
   * Sync job questions with incoming request data.
   */
  protected function syncJobQuestions(Job $job, array $questions): void
  {
    $job->questions()->delete();

    $payload = collect($questions)
      ->filter(function ($item) {
        $question = trim($item['question'] ?? '');
        $questionAr = trim($item['question_ar'] ?? '');
        return $question !== '' || $questionAr !== '';
      })
      ->values()
      ->map(function ($item, $index) {
        return [
          'question' => trim($item['question'] ?? ''),
          'question_ar' => trim($item['question_ar'] ?? '') ?: null,
          'is_required' => isset($item['is_required']) ? (bool)$item['is_required'] : false,
          'display_order' => $index,
        ];
      });

    if ($payload->isNotEmpty()) {
      $job->questions()->createMany($payload->toArray());
    }
  }

  /**
   * Sync job required documents with incoming request data.
   */
  protected function syncJobDocuments(Job $job, array $documents): void
  {
    $job->documents()->delete();

    $payload = collect($documents)
      ->filter(function ($item) {
        $name = trim($item['name'] ?? '');
        $nameAr = trim($item['name_ar'] ?? '');
        return $name !== '' || $nameAr !== '';
      })
      ->values()
      ->map(function ($item, $index) {
        return [
          'name' => trim($item['name'] ?? ''),
          'name_ar' => trim($item['name_ar'] ?? '') ?: null,
          'is_required' => isset($item['is_required']) ? (bool)$item['is_required'] : false,
          'display_order' => $index,
        ];
      });

    if ($payload->isNotEmpty()) {
      $job->documents()->createMany($payload->toArray());
    }
  }

  /**
   * Toggle the status of the specified job between active and inactive.
   */
  public function toggleStatus(Job $job)
  {
    $newStatus = match ($job->status) {
      'active' => 'inactive',
      'inactive' => 'active',
      default => 'active',
    };

    $job->status = $newStatus;
    $job->is_active = $newStatus === 'active';
    $job->save();

    $message = match ($newStatus) {
      'active' => 'Job activated successfully.',
      'inactive' => 'Job deactivated successfully.',
      default => 'Job status updated successfully.',
    };

    return back()->with('success', $message);
  }
}
