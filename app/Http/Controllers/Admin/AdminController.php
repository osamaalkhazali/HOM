<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Client;
use App\Notifications\AdminAccountCreated;
use App\Services\Admin\AdminExportService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
  protected AdminExportService $exportService;

  public function __construct(AdminExportService $exportService)
  {
    $this->exportService = $exportService;
  }

  /**
   * Display a listing of admin users.
   */
  public function index(Request $request)
  {
    $query = $this->baseIndexQuery();

    $this->applyIndexFilters($request, $query);
    $this->applyIndexSorting($request, $query);

    $admins = $query->paginate(10)->appends($request->query());
    $exportQuery = $request->except(['page']);

    return view('admin.admins.index', compact('admins', 'exportQuery'));
  }

  protected function baseIndexQuery(): Builder
  {
    return Admin::query();
  }

  protected function applyIndexFilters(Request $request, Builder $query): void
  {
    if ($request->filled('search')) {
      $search = $request->get('search');
      $query->where(function ($q) use ($search) {
        $q->where('name', 'like', "%{$search}%")
          ->orWhere('email', 'like', "%{$search}%");
      });
    }

    if ($request->filled('status')) {
      if ($request->get('status') === 'active') {
        $query->whereNotNull('email_verified_at');
      } elseif ($request->get('status') === 'inactive') {
        $query->whereNull('email_verified_at');
      }
    }

    if ($request->filled('role')) {
      if ($request->get('role') === 'super') {
        $query->where('role', 'super');
      } elseif ($request->get('role') === 'admin') {
        $query->where('role', 'admin');
      } elseif ($request->get('role') === 'client_hr') {
        $query->where('role', 'client_hr');
      }
    }
  }

  protected function applyIndexSorting(Request $request, Builder $query): void
  {
    $sortBy = $request->get('sort_by', 'created_at');
    $sortDirection = $request->get('sort_direction', 'desc');

    $allowedSorts = ['name', 'email', 'created_at', 'last_login_at'];
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

    $admins = $query->get();

    if ($admins->isEmpty()) {
      return redirect()->route('admin.admins.index', $request->except(['page', 'scope']))
        ->with('warning', 'No admin accounts available for export with the selected filters.');
    }

    [$headings, $rows, $meta] = $this->buildAdminExportRows($admins, $request, $scope);

    $fileName = 'admins_' . now()->format('Ymd_His');

    return $this->exportService->download($format, $fileName, $headings, $rows, $meta);
  }

  /**
   * @return array{0: array<int, string>, 1: array<int, array<int, string|int|float|null>>, 2: array<string, mixed>}
   */
  protected function buildAdminExportRows(Collection $admins, Request $request, string $scope): array
  {
    $headings = [
      'Admin ID',
      'Name',
      'Email',
      'Role',
      'Active',
      'Email Verified At',
      'Last Login At',
      'Created At',
      'Updated At',
    ];

    $rows = $admins->map(function (Admin $admin) {
      return $this->mapAdminRow($admin);
    })->all();

    $meta = [
      'title' => 'Admins Export',
      'description' => 'Total admins: ' . $admins->count() . ($scope === 'all' ? ' (full dataset)' : ' (filtered)'),
      'generated_at' => now()->format('Y-m-d H:i'),
      'filters' => $scope === 'all' ? null : $this->summarizeFilters($request),
    ];

    return [$headings, $rows, $meta];
  }

  /**
   * @return array<int, string|int|float|null>
   */
  protected function mapAdminRow(Admin $admin): array
  {
    $role = match($admin->role) {
      'super' => 'Super Admin',
      'client_hr' => 'Client HR',
      default => 'Admin',
    };
    $isActive = $admin->email_verified_at ? 'Yes' : 'No';

    $verifiedAt = $admin->email_verified_at instanceof Carbon
      ? $admin->email_verified_at->format('Y-m-d H:i')
      : ($admin->email_verified_at ? Carbon::parse($admin->email_verified_at)->format('Y-m-d H:i') : '—');

    $lastLogin = $admin->last_login_at instanceof Carbon
      ? $admin->last_login_at->format('Y-m-d H:i')
      : ($admin->last_login_at ? Carbon::parse($admin->last_login_at)->format('Y-m-d H:i') : '—');

    return [
      $admin->id,
      $admin->name ?? '—',
      $admin->email ?? '—',
      $role,
      $isActive,
      $verifiedAt,
      $lastLogin,
      optional($admin->created_at)->format('Y-m-d H:i'),
      optional($admin->updated_at)->format('Y-m-d H:i'),
    ];
  }

  protected function summarizeFilters(Request $request): ?string
  {
    $filters = collect($request->except(['page', 'sort_by', 'sort_direction', 'scope', 'format']))
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
   * Show the form for creating a new admin.
   */
  public function create()
  {
    $clients = Client::where('is_active', true)->orderBy('name')->get();
    return view('admin.admins.create', compact('clients'));
  }

  /**
   * Store a newly created admin in storage.
   */
  public function store(Request $request)
  {
    $request->validate([
      'name' => 'required|string|max:255',
      'email' => 'required|string|email|max:255|unique:admins',
      'password' => 'required|string|min:8|confirmed',
      'role' => 'required|in:admin,super,client_hr',
      'client_id' => 'required_if:role,client_hr|nullable|exists:clients,id',
      'status' => 'required|in:active,inactive',
      'send_email' => 'boolean',
    ]);

    // Store the plain password before hashing (for email)
    $plainPassword = $request->password;

    $admin = Admin::create([
      'name' => $request->name,
      'email' => $request->email,
      'password' => Hash::make($request->password),
      'role' => $request->role,
      'client_id' => $request->role === 'client_hr' ? $request->client_id : null,
      'email_verified_at' => $request->status === 'active' ? now() : null,
    ]);

    // Send email notification with login credentials
    if ($request->boolean('send_email', true)) {
      try {
        $admin->notify(new AdminAccountCreated($admin, $plainPassword));
      } catch (\Exception $e) {
        // Log error but don't stop the process
        \Log::error('Failed to send admin account creation email', [
          'admin_id' => $admin->id,
          'email' => $admin->email,
          'error' => $e->getMessage(),
        ]);
      }
    }

    $roleLabel = match($admin->role) {
      'super' => 'Super Admin',
      'client_hr' => 'Client HR',
      default => 'Admin',
    };

    $message = "{$roleLabel} created successfully.";
    if ($request->boolean('send_email', true)) {
      $message .= ' Login credentials have been sent to their email.';
    }

    return redirect()->route('admin.admins.index')
      ->with('success', $message);
  }

  /**
   * Display the specified admin.
   */
  public function show(Admin $admin)
  {
    return view('admin.admins.show', compact('admin'));
  }

  /**
   * Show the form for editing the specified admin.
   */
  public function edit(Admin $admin)
  {
    $clients = Client::where('is_active', true)->orderBy('name')->get();
    return view('admin.admins.edit', compact('admin', 'clients'));
  }

  /**
   * Update the specified admin in storage.
   */
  public function update(Request $request, Admin $admin)
  {
    $request->validate([
      'name' => 'required|string|max:255',
      'email' => ['required', 'string', 'email', 'max:255', Rule::unique('admins')->ignore($admin->id)],
      'password' => 'nullable|string|min:8|confirmed',
      'role' => 'required|in:admin,super,client_hr',
      'client_id' => 'required_if:role,client_hr|nullable|exists:clients,id',
      'status' => 'required|in:active,inactive',
    ]);

    $updateData = [
      'name' => $request->name,
      'email' => $request->email,
      'role' => $request->role,
      'client_id' => $request->role === 'client_hr' ? $request->client_id : null,
      'email_verified_at' => $request->status === 'active' ? now() : null,
    ];

    if ($request->filled('password')) {
      $updateData['password'] = Hash::make($request->password);
    }

    $admin->update($updateData);

    return redirect()->route('admin.admins.index')
      ->with('success', 'Admin updated successfully.');
  }

  /**
   * Toggle admin status.
   */
  public function toggleStatus(Admin $admin)
  {
    $admin->update([
      'email_verified_at' => $admin->email_verified_at ? null : now()
    ]);

    $status = $admin->email_verified_at ? 'activated' : 'deactivated';
    return redirect()->back()
      ->with('success', "Admin {$status} successfully.");
  }

  /**
   * Remove the specified admin from storage.
   */
  public function destroy(Admin $admin)
  {
    // Prevent deletion of the current admin
    if ($admin->id === auth('admin')->id()) {
      return redirect()->back()
        ->with('error', 'You cannot delete your own account.');
    }

    $admin->delete();

    return redirect()->route('admin.admins.index')
      ->with('success', 'Admin deleted successfully.');
  }
}
