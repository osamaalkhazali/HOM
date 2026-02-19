<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\Admin\AdminExportService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use App\Support\SecureStorage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class UserController extends Controller
{
  protected AdminExportService $exportService;

  public function __construct(AdminExportService $exportService)
  {
    $this->exportService = $exportService;
  }

  /**
   * Display a listing of users with filtering and sorting
   */
  public function index(Request $request)
  {
    $query = $this->baseIndexQuery();

    $this->applyIndexFilters($request, $query);
    $this->applyIndexSorting($request, $query);

    $users = $query->withCount('applications')->paginate(15)->withQueryString();
    $exportQuery = $request->except(['page']);

    return view('admin.users.index', compact('users', 'exportQuery'));
  }

  protected function baseIndexQuery(): Builder
  {
    return User::with([
      'profile',
      'applications.job',
      'applications.job.category',
      'applications.job.subCategory',
    ]);
  }

  protected function applyIndexFilters(Request $request, Builder $query): void
  {
    if ($request->filled('search')) {
      $search = $request->search;
      $query->where(function ($q) use ($search) {
        $q->where('name', 'like', "%{$search}%")
          ->orWhere('email', 'like', "%{$search}%")
          ->orWhere('phone', 'like', "%{$search}%")
          ->orWhereHas('profile', function ($profileQuery) use ($search) {
            $profileQuery->where('headline', 'like', "%{$search}%")
              ->orWhere('current_position', 'like', "%{$search}%")
              ->orWhere('skills', 'like', "%{$search}%")
              ->orWhere('location', 'like', "%{$search}%")
              ->orWhere('about', 'like', "%{$search}%")
              ->orWhere('education', 'like', "%{$search}%")
              ->orWhere('website', 'like', "%{$search}%")
              ->orWhere('linkedin_url', 'like', "%{$search}%")
              ->orWhere('experience_years', 'like', "%{$search}%");
        })
          ->orWhereHas('applications.job', function ($jobQuery) use ($search) {
            $jobQuery->where('title', 'like', "%{$search}%")
              ->orWhere('title_ar', 'like', "%{$search}%")
              ->orWhere('company', 'like', "%{$search}%")
              ->orWhere('company_ar', 'like', "%{$search}%");
          });
      });
    }

    if ($request->filled('status')) {
      if ($request->status === 'active') {
        $query->where('is_active', true);
      } elseif ($request->status === 'inactive') {
        $query->where('is_active', false);
      }
    }

    if ($request->filled('verified')) {
      if ($request->verified === 'yes') {
        $query->whereNotNull('email_verified_at');
      } elseif ($request->verified === 'no') {
        $query->whereNull('email_verified_at');
      }
    }

    if ($request->filled('profile')) {
      if ($request->profile === 'with_profile') {
        $query->has('profile');
      } elseif ($request->profile === 'without_profile') {
        $query->doesntHave('profile');
      }
    }

    if ($request->filled('has_cv')) {
      if ($request->has_cv === 'yes') {
        $query->whereHas('profile', function ($q) {
          $q->whereNotNull('cv_path');
        });
      } elseif ($request->has_cv === 'no') {
        $query->whereDoesntHave('profile', function ($q) {
          $q->whereNotNull('cv_path');
        })->orWhereHas('profile', function ($q) {
          $q->whereNull('cv_path');
        });
      }
    }

    if ($request->filled('has_applications')) {
      if ($request->has_applications === 'yes') {
        $query->has('applications');
      } elseif ($request->has_applications === 'no') {
        $query->doesntHave('applications');
      }
    }

    if ($request->filled('experience_min')) {
      $query->whereHas('profile', function ($q) use ($request) {
        $q->where('experience_years', '>=', $request->experience_min);
      });
    }

    if ($request->filled('experience_max')) {
      $query->whereHas('profile', function ($q) use ($request) {
        $q->where('experience_years', '<=', $request->experience_max);
      });
    }

    if ($request->filled('date_from')) {
      $query->whereDate('created_at', '>=', $request->date_from);
    }

    if ($request->filled('date_to')) {
      $query->whereDate('created_at', '<=', $request->date_to);
    }
  }

  protected function applyIndexSorting(Request $request, Builder $query): void
  {
    $sortBy = $request->get('sort', 'created_at');
    $sortDirection = $request->get('direction', 'desc');

    $allowedSorts = ['name', 'email', 'created_at', 'email_verified_at'];
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

    $users = $query->withCount('applications')->get();

    if ($users->isEmpty()) {
      return redirect()->route('admin.users.index', $request->except(['page', 'scope']))
        ->with('warning', 'No users available for export with the selected filters.');
    }

    [$headings, $rows, $meta] = $this->buildUserExportRows($users, $request, $scope);

    $fileName = 'users_' . now()->format('Ymd_His');

    return $this->exportService->download($format, $fileName, $headings, $rows, $meta);
  }

  /**
   * @return array{0: array<int, string>, 1: array<int, array<int, string|int|float|null>>, 2: array<string, mixed>}
   */
  protected function buildUserExportRows(Collection $users, Request $request, string $scope): array
  {
    $headings = [
      'User ID',
      'Name',
      'Email',
      'Phone',
      'Preferred Language',
      'Active',
      'Email Verified',
      'Registered At',
      'Updated At',
      'Deleted At',
      'Applications Count',
      'Applications Breakdown',
      'Applications Detail',
      'Profile Headline',
      'Current Position',
      'Experience (Years)',
      'Skills',
      'Location',
      'About',
      'Education',
      'Website',
      'LinkedIn',
      'CV Path',
      'CV URL',
      'Profile Created At',
      'Profile Updated At',
    ];

    $rows = $users->map(function (User $user) {
      return $this->mapUserRow($user);
    })->all();

    $meta = [
      'title' => 'Users Export',
      'description' => 'Total users: ' . $users->count() . ($scope === 'all' ? ' (full dataset)' : ' (filtered)'),
      'generated_at' => now()->format('Y-m-d H:i'),
      'filters' => $scope === 'all' ? null : $this->summarizeFilters($request),
    ];

    return [$headings, $rows, $meta];
  }

  /**
   * @return array<int, string|int|float|null>
   */
  protected function mapUserRow(User $user): array
  {
    $profile = $user->profile;
    $cvPath = $profile?->cv_path;
    $cvUrl = ($cvPath && SecureStorage::exists($cvPath))
      ? route('admin.users.cv.view', $user)
      : null;

    $applicationsBreakdown = $user->applications->groupBy('status')->map(function ($group, $status) {
      return Str::headline($status) . ': ' . $group->count();
    })->values()->join(PHP_EOL);

    $applicationsDetail = $user->applications->map(function ($application) {
      $job = $application->job;
      $jobLabel = $job ? ($job->title . ' (' . ($job->company ?? 'Company') . ')') : 'Deleted Job';
      $status = Str::headline($application->status ?? '');
      $appliedAt = $application->created_at ? Carbon::parse($application->created_at)->format('Y-m-d') : 'N/A';
      return $jobLabel . ' - ' . $status . ' [' . $appliedAt . ']';
    })->filter()->join(PHP_EOL);

    $emailVerified = $user->email_verified_at instanceof Carbon
      ? $user->email_verified_at->format('Y-m-d H:i')
      : ($user->email_verified_at ? Carbon::parse($user->email_verified_at)->format('Y-m-d H:i') : null);

    $profileCreatedAt = $profile && $profile->created_at
      ? Carbon::parse($profile->created_at)->format('Y-m-d H:i')
      : null;
    $profileUpdatedAt = $profile && $profile->updated_at
      ? Carbon::parse($profile->updated_at)->format('Y-m-d H:i')
      : null;

    return [
      $user->id,
      $user->name ?? '—',
      $user->email ?? '—',
      $user->phone ?? '—',
      $user->preferred_language ?? '—',
      $user->is_active ? 'Yes' : 'No',
      $emailVerified ?? 'No',
      optional($user->created_at)->format('Y-m-d H:i'),
      optional($user->updated_at)->format('Y-m-d H:i'),
      optional($user->deleted_at)->format('Y-m-d H:i'),
      $user->applications_count ?? $user->applications->count(),
      $applicationsBreakdown ?: '—',
      $applicationsDetail ?: '—',
      optional($profile)->headline ?? '—',
      optional($profile)->current_position ?? '—',
      optional($profile)->experience_years ?? '—',
      optional($profile)->skills ?? '—',
      optional($profile)->location ?? '—',
      optional($profile)->about ?? '—',
      optional($profile)->education ?? '—',
      optional($profile)->website ?? '—',
      optional($profile)->linkedin_url ?? '—',
      $cvPath ?? '—',
      $cvUrl ?? '—',
      $profileCreatedAt ?? '—',
      $profileUpdatedAt ?? '—',
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
   * Display the specified user
   */
  public function show(User $user)
  {
    // Check if Client HR user has access to this user (only if user applied to their client's jobs)
    if (auth('admin')->user()->isClientHr()) {
        $hasAccess = $user->applications()
            ->whereHas('job', function ($query) {
                $query->where('client_id', auth('admin')->user()->client_id);
            })
            ->exists();

        if (!$hasAccess) {
            abort(403, 'You do not have permission to view this user.');
        }
    }

    $user->load(['profile', 'applications.job']);
    return view('admin.users.show', compact('user'));
  }

  /**
   * Toggle user active status
   */
  public function toggleStatus(User $user)
  {
    $user->is_active = !$user->is_active;
    $user->save();

    $message = $user->is_active ? 'User activated successfully' : 'User deactivated successfully';

    return redirect()->back()->with('success', $message);
  }

  /**
   * Remove the specified user
   */
  public function destroy(User $user)
  {
    $user->delete();
    return redirect()->route('admin.users.index')->with('success', 'User deleted successfully');
  }

  /**
   * Display deleted users
   */
  public function deleted(Request $request)
  {
    // Debug: Let's see if this method is being called
    Log::info('UserController@deleted method called');

    $query = User::onlyTrashed()->with(['profile', 'applications']);

    // Search functionality for deleted users
    if ($request->filled('search')) {
      $search = $request->search;
      $query->where(function ($q) use ($search) {
        $q->where('name', 'like', "%{$search}%")
          ->orWhere('email', 'like', "%{$search}%")
          ->orWhere('phone', 'like', "%{$search}%");
      });
    }

    // Sorting
    $sortBy = $request->get('sort', 'deleted_at');
    $sortDirection = $request->get('direction', 'desc');

    $allowedSorts = ['name', 'email', 'created_at', 'deleted_at'];
    if (in_array($sortBy, $allowedSorts)) {
      $query->orderBy($sortBy, $sortDirection);
    }

    $users = $query->paginate(15)->withQueryString();

    return view('admin.users.deleted', compact('users'));
  }

  /**
   * Restore a deleted user
   */
  public function restore($id)
  {
    $user = User::onlyTrashed()->findOrFail($id);
    $user->restore();

    return redirect()->back()->with('success', 'User restored successfully');
  }

  /**
   * Permanently delete a user
   */
  public function forceDelete($id)
  {
    $user = User::onlyTrashed()->findOrFail($id);

    // Delete user's profile if it exists
    if ($user->profile) {
      $user->profile->forceDelete();
    }

    $user->forceDelete();

    return redirect()->back()->with('success', 'User permanently deleted');
  }
}
