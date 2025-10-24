<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
  /**
   * Display a listing of users with filtering and sorting
   */
  public function index(Request $request)
  {
    $query = User::with(['profile', 'applications.job']);

    // Enhanced search functionality - searches across user, profile, and application data
    if ($request->filled('search')) {
      $search = $request->search;
      $query->where(function ($q) use ($search) {
        // Search in user basic fields
        $q->where('name', 'like', "%{$search}%")
          ->orWhere('email', 'like', "%{$search}%")
          ->orWhere('phone', 'like', "%{$search}%")
          // Search in profile fields
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
          // Search in applied jobs
          ->orWhereHas('applications.job', function ($jobQuery) use ($search) {
            $jobQuery->where('title', 'like', "%{$search}%")
              ->orWhere('title_ar', 'like', "%{$search}%")
              ->orWhere('company', 'like', "%{$search}%")
              ->orWhere('company_ar', 'like', "%{$search}%");
          });
      });
    }

    // Filter by account status (active/inactive)
    if ($request->filled('status')) {
      if ($request->status === 'active') {
        $query->where('is_active', true);
      } elseif ($request->status === 'inactive') {
        $query->where('is_active', false);
      }
    }

    // Filter by email verification
    if ($request->filled('verified')) {
      if ($request->verified === 'yes') {
        $query->whereNotNull('email_verified_at');
      } elseif ($request->verified === 'no') {
        $query->whereNull('email_verified_at');
      }
    }

    // Filter by profile existence
    if ($request->filled('profile')) {
      if ($request->profile === 'with_profile') {
        $query->has('profile');
      } elseif ($request->profile === 'without_profile') {
        $query->doesntHave('profile');
      }
    }

    // Filter by CV existence
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

    // Filter by users with applications
    if ($request->filled('has_applications')) {
      if ($request->has_applications === 'yes') {
        $query->has('applications');
      } elseif ($request->has_applications === 'no') {
        $query->doesntHave('applications');
      }
    }

    // Filter by experience years range
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

    // Filter by registration date range
    if ($request->filled('date_from')) {
      $query->whereDate('created_at', '>=', $request->date_from);
    }
    if ($request->filled('date_to')) {
      $query->whereDate('created_at', '<=', $request->date_to);
    }

    // Sorting
    $sortBy = $request->get('sort', 'created_at');
    $sortDirection = $request->get('direction', 'desc');

    $allowedSorts = ['name', 'email', 'created_at', 'email_verified_at'];
    if (in_array($sortBy, $allowedSorts)) {
      $query->orderBy($sortBy, $sortDirection);
    }

    $users = $query->withCount('applications')->paginate(15)->withQueryString();

    return view('admin.users.index', compact('users'));
  }

  /**
   * Display the specified user
   */
  public function show(User $user)
  {
    $user->load(['profile', 'applications.job', 'jobs']);
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
    \Log::info('UserController@deleted method called');

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
