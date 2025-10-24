<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JobController extends Controller
{
  /**
   * Display a listing of jobs with filtering and sorting
   */
  public function index(Request $request)
  {
    $query = Job::with(['category', 'subCategory', 'postedBy', 'applications']);

    // Search functionality
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
          ->orWhere('description_ar', 'like', "%{$search}%");
      });
    }

    // Filter by category
    if ($request->filled('category')) {
      $query->whereHas('subCategory', function ($q) use ($request) {
        $q->where('category_id', $request->category);
      });
    }

    // Filter by subcategory
    if ($request->filled('subcategory')) {
      $query->where('sub_category_id', $request->subcategory);
    }

    // Filter by status
    if ($request->filled('status')) {
      $query->where('status', $request->status);
    }

    // Filter by level
    if ($request->filled('level')) {
      $query->where('level', $request->level);
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

    $allowedSorts = ['title', 'company', 'location', 'level', 'created_at', 'deadline'];
    if (in_array($sortBy, $allowedSorts)) {
      $query->orderBy($sortBy, $sortDirection);
    }

    $jobs = $query->paginate(15)->withQueryString();
    $categories = Category::all();

    return view('admin.jobs.index', compact('jobs', 'categories'));
  }

  /**
   * Show the form for creating a new job
   */
  public function create()
  {
    $categories = Category::with('subCategories')->get();
        $defaultDeadline = now()->addDays(14);
        $defaultDeadlineDays = 14;

        return view('admin.jobs.create', compact('categories', 'defaultDeadline', 'defaultDeadlineDays'));
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
    $job->load(['category', 'subCategory', 'postedBy', 'applications.user', 'questions', 'documents']);
    return view('admin.jobs.show', compact('job'));
  }

  /**
   * Show the form for editing the specified job
   */
  public function edit(Job $job)
  {
    $job->load(['questions', 'documents']);
    $categories = Category::with('subCategories')->get();
    return view('admin.jobs.edit', compact('job', 'categories'));
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
        $job->deadline = $job->deadline
            ? $job->deadline->copy()->addDays(14)
            : now()->addDays(14);
        $job->save();

        return back()->with('success', 'Job deadline extended by 14 days.');
    }

    /**
     * Display a listing of deleted jobs
     */
  public function deleted(Request $request)
  {
    $query = Job::onlyTrashed()->with(['category', 'subCategory', 'postedBy', 'applications']);

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
