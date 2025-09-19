<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Job;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
  /**
   * Display a listing of applications with filtering and sorting
   */
  public function index(Request $request)
  {
    $query = Application::with(['user', 'job.subCategory.category']);

    // Search functionality
    if ($request->filled('search')) {
      $search = $request->search;
      $query->where(function ($q) use ($search) {
        $q->whereHas('user', function ($userQuery) use ($search) {
          $userQuery->where('name', 'like', "%{$search}%")
            ->orWhere('email', 'like', "%{$search}%");
        })->orWhereHas('job', function ($jobQuery) use ($search) {
          $jobQuery->where('title', 'like', "%{$search}%")
            ->orWhere('company', 'like', "%{$search}%");
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

    return view('admin.applications.index', compact('applications', 'jobs'));
  }

  /**
   * Display the specified application
   */
  public function show(Application $application)
  {
    $application->load(['user.profile', 'job.subCategory.category']);
    return view('admin.applications.show', compact('application'));
  }

  /**
   * Show the form for editing the specified application
   */
  public function edit(Application $application)
  {
    $application->load(['user.profile', 'job.subCategory.category']);
    return view('admin.applications.edit', compact('application'));
  }

  /**
   * Update the specified application
   */
  public function update(Request $request, Application $application)
  {
    $validated = $request->validate([
      'status' => 'required|in:pending,reviewed,shortlisted,rejected,hired',
      'notes' => 'nullable|string|max:1000',
      'interview_date' => 'nullable|date|after:today',
      'interview_notes' => 'nullable|string|max:1000'
    ]);

    $application->update($validated);

    return redirect()->route('admin.applications.show', $application)
      ->with('success', 'Application updated successfully');
  }

  /**
   * Update the application status
   */
  public function updateStatus(Request $request, Application $application)
  {
    $validated = $request->validate([
      'status' => 'required|in:pending,reviewed,shortlisted,rejected,hired'
    ]);

    $application->update($validated);

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
      'status' => 'required|in:pending,reviewed,shortlisted,rejected,hired'
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
}
