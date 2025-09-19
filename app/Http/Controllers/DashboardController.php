<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
  /**
   * Display the user dashboard
   */
  public function index()
  {
    $user = Auth::user();

    // Get recent applications with job data, ordered by created_at desc
    $recentApplications = $user->applications()
      ->with(['job' => function ($query) {
        $query->select('id', 'title', 'company', 'salary', 'location');
      }])
      ->orderBy('created_at', 'desc')
      ->take(5)
      ->get();

    // Get application statistics
    $stats = [
      'total' => $user->applications->count(),
      'pending' => $user->applications->where('status', 'pending')->count(),
      'accepted' => $user->applications->where('status', 'accepted')->count(),
      'reviewed' => $user->applications->where('status', 'reviewed')->count(),
    ];

    // Check if user has uploaded CV
    $hasCv = $user->profile && $user->profile->cv_path;

    return view('dashboard', compact('recentApplications', 'stats', 'hasCv'));
  }
}
