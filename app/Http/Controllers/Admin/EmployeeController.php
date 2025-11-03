<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\User;
use App\Models\Job;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeeController extends Controller
{
    /**
     * Display a listing of employees.
     */
    public function index(Request $request)
    {
        $admin = Auth::guard('admin')->user();

        // Base query with relationships
        $query = Employee::with(['user.profile', 'job.client', 'documents'])
            ->latest('hire_date');

        // Filter by client for Client HR
        if ($admin->isClientHr()) {
            $query->whereHas('job', function ($q) use ($admin) {
                $q->where('client_id', $admin->client_id);
            });
        }

        // Search filter
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($userQuery) use ($search) {
                    $userQuery->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                })
                ->orWhere('position_title', 'like', "%{$search}%")
                ->orWhereHas('job', function ($jobQuery) use ($search) {
                    $jobQuery->where('title', 'like', "%{$search}%");
                });
            });
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        // Client filter (for super admin and admin)
        if ($request->filled('client_id') && !$admin->isClientHr()) {
            $query->whereHas('job', function ($q) use ($request) {
                $q->where('client_id', $request->input('client_id'));
            });
        }

        // Job filter
        if ($request->filled('job_id')) {
            $query->where('job_id', $request->input('job_id'));
        }

        // Date range filter
        if ($request->filled('date_from')) {
            $query->where('hire_date', '>=', $request->input('date_from'));
        }
        if ($request->filled('date_to')) {
            $query->where('hire_date', '<=', $request->input('date_to'));
        }

        // Document type filter - employees who have documents of specific type
        if ($request->filled('document_type')) {
            $query->whereHas('documents', function ($q) use ($request) {
                $q->where('document_type', $request->input('document_type'));
            });
        }

        // Get all matching employees
        $allEmployees = $query->get();

        // Group by user_id and get unique users
        $groupedEmployees = $allEmployees->groupBy('user_id')->map(function ($userEmployees) {
            return [
                'user' => $userEmployees->first()->user,
                'employees' => $userEmployees->sortByDesc('hire_date'),
                'total_documents' => $userEmployees->sum(function($emp) {
                    return $emp->documents->count();
                })
            ];
        });

        // Convert to collection for pagination
        $page = $request->get('page', 1);
        $perPage = 15;
        $total = $groupedEmployees->count();
        $items = $groupedEmployees->slice(($page - 1) * $perPage, $perPage)->values();

        $users = new \Illuminate\Pagination\LengthAwarePaginator(
            $items,
            $total,
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        // Get filter options
        $jobs = Job::orderBy('title')->get();
        $clients = $admin->isClientHr()
            ? Client::where('id', $admin->client_id)->get()
            : Client::orderBy('name')->get();

        // Get document types from EmployeeDocument model
        $documentTypes = \App\Models\EmployeeDocument::getDocumentTypes();

        return view('admin.employees.index', compact('users', 'jobs', 'clients', 'documentTypes'));
    }

    /**
     * Show the form for creating a new employee.
     */
    public function create()
    {
        $admin = Auth::guard('admin')->user();

        // Only Client HR can create employees
        if (!$admin->isClientHr()) {
            abort(403, 'Unauthorized action.');
        }

        // Get available users and jobs
        $users = User::orderBy('name')->get();
        $jobs = $admin->isClientHr()
            ? Job::where('client_id', $admin->client_id)->orderBy('title')->get()
            : Job::orderBy('title')->get();

        return view('admin.employees.create', compact('users', 'jobs'));
    }

    /**
     * Store a newly created employee in storage.
     */
    public function store(Request $request)
    {
        $admin = Auth::guard('admin')->user();

        // Only Client HR can create employees
        if (!$admin->isClientHr()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'job_id' => 'required|exists:jobs,id',
            'position_title' => 'nullable|string|max:255',
            'status' => 'required|in:active,terminated,resigned,transferred',
            'hire_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:hire_date',
            'notes' => 'nullable|string',
        ]);

        // Get job details
        $job = Job::findOrFail($validated['job_id']);

        // Check authorization for Client HR
        if ($admin->isClientHr() && $job->client_id !== $admin->client_id) {
            abort(403, 'Unauthorized action.');
        }

        // If position_title is not provided, use job title
        if (empty($validated['position_title'])) {
            $validated['position_title'] = $job->title;
        }

        $employee = Employee::create($validated);

        return redirect()
            ->route('admin.employees.show', $employee)
            ->with('success', 'Employee record created successfully.');
    }

    /**
     * Display the specified employee.
     */
    public function show(Employee $employee)
    {
        $admin = Auth::guard('admin')->user();

        // Check authorization for Client HR
        if ($admin->isClientHr() && $employee->client_id !== $admin->client_id) {
            abort(403, 'Unauthorized action.');
        }

        $employee->load(['user.profile', 'job.client', 'application', 'documents']);

        return view('admin.employees.show', compact('employee'));
    }

    /**
     * Show the form for editing the specified employee.
     */
    public function edit(Employee $employee)
    {
        $admin = Auth::guard('admin')->user();

        // Only Client HR can edit employees
        if (!$admin->isClientHr()) {
            abort(403, 'Unauthorized action.');
        }

        // Check authorization for Client HR
        if ($admin->isClientHr() && $employee->client_id !== $admin->client_id) {
            abort(403, 'Unauthorized action.');
        }

        $users = User::orderBy('name')->get();
        $jobs = $admin->isClientHr()
            ? Job::where('client_id', $admin->client_id)->orderBy('title')->get()
            : Job::orderBy('title')->get();

        return view('admin.employees.edit', compact('employee', 'users', 'jobs'));
    }

    /**
     * Update the specified employee in storage.
     */
    public function update(Request $request, Employee $employee)
    {
        $admin = Auth::guard('admin')->user();

        // Only Client HR can update employees
        if (!$admin->isClientHr()) {
            abort(403, 'Unauthorized action.');
        }

        // Check authorization for Client HR
        if ($admin->isClientHr() && $employee->client_id !== $admin->client_id) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'position_title' => 'nullable|string|max:255',
            'status' => 'required|in:active,terminated,resigned,transferred',
            'hire_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:hire_date',
            'notes' => 'nullable|string',
        ]);

        $employee->update($validated);

        return redirect()
            ->route('admin.employees.show', $employee)
            ->with('success', 'Employee record updated successfully.');
    }

    /**
     * Remove the specified employee from storage.
     */
    public function destroy(Employee $employee)
    {
        $admin = Auth::guard('admin')->user();

        // Only Client HR can delete employees
        if (!$admin->isClientHr()) {
            abort(403, 'Unauthorized action.');
        }

        // Check authorization for Client HR
        if ($admin->isClientHr() && $employee->client_id !== $admin->client_id) {
            abort(403, 'Unauthorized action.');
        }

        $employee->delete();

        return redirect()
            ->route('admin.employees.index')
            ->with('success', 'Employee record deleted successfully.');
    }
}
