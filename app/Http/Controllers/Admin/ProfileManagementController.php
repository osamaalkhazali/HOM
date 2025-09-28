<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use Illuminate\Http\Request;

class ProfileManagementController extends Controller
{
  /**
   * Display a listing of profiles with filtering and sorting
   */
  public function index(Request $request)
  {
    $query = Profile::with('user');

    // Search functionality
    if ($request->filled('search')) {
      $search = $request->search;
      $query->where(function ($q) use ($search) {
        $q->where('headline', 'like', "%{$search}%")
          ->orWhere('skills', 'like', "%{$search}%")
          ->orWhere('current_position', 'like', "%{$search}%")
          ->orWhere('location', 'like', "%{$search}%")
          ->orWhereHas('user', function ($userQuery) use ($search) {
            $userQuery->where('name', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%");
          });
      });
    }

    // Filter by experience years (string ranges)
    if ($request->filled('experience')) {
      $map = [
        '0-1' => ['0-1'],
        '0-2' => ['0-1', '2-3'], // keep compatibility if UI sends 0-2
        '2-3' => ['2-3'],
        '3-5' => ['4-5'], // compatibility mapping
        '4-5' => ['4-5'],
        '6-10' => ['6-10'],
        '10+' => ['10+'],
      ];
      $values = $map[$request->experience] ?? [$request->experience];
      $query->where(function ($q) use ($values) {
        foreach ($values as $val) {
          $q->orWhere('experience_years', $val);
        }
      });
    }

    // Filter by location
    if ($request->filled('location')) {
      $query->where('location', 'like', "%{$request->location}%");
    }

    // Filter by CV availability
    if ($request->filled('cv_status')) {
      if ($request->cv_status === 'with_cv') {
        $query->whereNotNull('cv_path');
      } elseif ($request->cv_status === 'without_cv') {
        $query->whereNull('cv_path');
      }
    }

    // Sorting
    $sortBy = $request->get('sort', 'created_at');
    $sortDirection = $request->get('direction', 'desc');

    // Sorting: for string ranges, default sorting lexicographically is OK or we can map order later
    $allowedSorts = ['created_at', 'experience_years', 'current_position', 'location'];
    if (in_array($sortBy, $allowedSorts)) {
      $query->orderBy($sortBy, $sortDirection);
    } elseif ($sortBy === 'user_name') {
      $query->join('users', 'profiles.user_id', '=', 'users.id')
        ->orderBy('users.name', $sortDirection)
        ->select('profiles.*');
    }

    $profiles = $query->paginate(15)->withQueryString();

    return view('admin.profiles.index', compact('profiles'));
  }

  /**
   * Display the specified profile
   */
  public function show(Profile $profile)
  {
    $profile->load(['user.applications.job']);
    return view('admin.profiles.show', compact('profile'));
  }

  /**
   * Remove the specified profile
   */
  public function destroy(Profile $profile)
  {
    // Delete CV file if exists
    if ($profile->cv_path && file_exists(storage_path('app/public/' . $profile->cv_path))) {
      unlink(storage_path('app/public/' . $profile->cv_path));
    }

    $profile->delete();
    return redirect()->route('admin.profiles.index')->with('success', 'Profile deleted successfully');
  }
}
