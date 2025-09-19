<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;

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
          ->orWhere('company', 'like', "%{$search}%")
          ->orWhere('location', 'like', "%{$search}%")
          ->orWhere('description', 'like', "%{$search}%");
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
      if ($request->status === 'active') {
        $query->where('is_active', true);
      } elseif ($request->status === 'inactive') {
        $query->where('is_active', false);
      }
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

    // Filter by salary range
    if ($request->filled('min_salary')) {
      $query->where('salary', '>=', $request->min_salary);
    }
    if ($request->filled('max_salary')) {
      $query->where('salary', '<=', $request->max_salary);
    }

    // Sorting
    $sortBy = $request->get('sort', 'created_at');
    $sortDirection = $request->get('direction', 'desc');

    $allowedSorts = ['title', 'company', 'salary', 'location', 'level', 'created_at', 'deadline'];
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
    return view('admin.jobs.create', compact('categories'));
  }

  /**
   * Store a newly created job
   */
  public function store(Request $request)
  {
    // Validate basic fields first
    $validated = $request->validate([
      'title' => 'required|string|max:255',
      'description' => 'required|string',
      'sub_category_id' => 'required|exists:sub_categories,id',
      'company' => 'required|string|max:255',
      'salary_type' => 'required|in:negotiable,fixed',
      'location' => 'required|string|max:255',
      'level' => 'required|in:entry,mid,senior,executive',
      'deadline' => 'required|date|after:today',
      'is_active' => 'boolean'
    ]);

    // Handle salary based on type
    if ($validated['salary_type'] === 'fixed') {
      $salaryValidation = $request->validate([
        'salary' => 'required|numeric|min:1'
      ]);
      $validated['salary'] = $salaryValidation['salary'];
    } else {
      $validated['salary'] = 0; // Set to 0 for negotiable
    }

    // Remove salary_type from validated data as it's not a database field
    unset($validated['salary_type']);

    $validated['posted_by'] = auth('admin')->id();
    $validated['is_active'] = $request->boolean('is_active', true);

    Job::create($validated);

    return redirect()->route('admin.jobs.index')->with('success', 'Job created successfully');
  }

  /**
   * Display the specified job
   */
  public function show(Job $job)
  {
    $job->load(['category', 'subCategory', 'postedBy', 'applications.user']);
    return view('admin.jobs.show', compact('job'));
  }

  /**
   * Show the form for editing the specified job
   */
  public function edit(Job $job)
  {
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
      'description' => 'required|string',
      'sub_category_id' => 'required|exists:sub_categories,id',
      'company' => 'required|string|max:255',
      'salary_type' => 'required|in:negotiable,fixed',
      'location' => 'required|string|max:255',
      'level' => 'required|in:entry,mid,senior,executive',
      'deadline' => 'required|date',
      'is_active' => 'boolean'
    ]);

    // Handle salary based on type
    if ($validated['salary_type'] === 'fixed') {
      $salaryValidation = $request->validate([
        'salary' => 'required|numeric|min:1'
      ]);
      $validated['salary'] = $salaryValidation['salary'];
    } else {
      $validated['salary'] = 0; // Set to 0 for negotiable
    }

    // Remove salary_type from validated data as it's not a database field
    unset($validated['salary_type']);

    $validated['is_active'] = $request->boolean('is_active');

    $job->update($validated);

    return redirect()->route('admin.jobs.index')->with('success', 'Job updated successfully');
  }

  /**
   * Toggle job active status
   */
  public function toggleStatus(Job $job)
  {
    $job->is_active = !$job->is_active;
    $job->save();

    $status = $job->is_active ? 'activated' : 'deactivated';
    return redirect()->back()->with('success', "Job {$status} successfully");
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
          ->orWhere('company', 'like', "%{$search}%")
          ->orWhere('location', 'like', "%{$search}%");
      });
    }

    // Filter by category
    if ($request->filled('category')) {
      $query->whereHas('subCategory', function ($q) use ($request) {
        $q->where('category_id', $request->category);
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
}
