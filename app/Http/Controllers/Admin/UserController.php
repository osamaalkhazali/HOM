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
    $query = User::with(['profile', 'applications']);

    // Search functionality - enhanced to include profile data
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
              ->orWhere('location', 'like', "%{$search}%");
          });
      });
    }

    // Filter by verification status
    if ($request->filled('status')) {
      if ($request->status === 'verified') {
        $query->whereNotNull('email_verified_at');
      } elseif ($request->status === 'unverified') {
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

    // Sorting
    $sortBy = $request->get('sort', 'created_at');
    $sortDirection = $request->get('direction', 'desc');

    $allowedSorts = ['name', 'email', 'created_at', 'email_verified_at'];
    if (in_array($sortBy, $allowedSorts)) {
      $query->orderBy($sortBy, $sortDirection);
    }

    $users = $query->paginate(15)->withQueryString();

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
   * Toggle user email verification status
   */
  public function toggleStatus(User $user)
  {
    if ($user->email_verified_at) {
      $user->email_verified_at = null;
      $message = 'User email verification removed';
    } else {
      $user->email_verified_at = now();
      $message = 'User email verified';
    }

    $user->save();

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
