<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
  /**
   * Display a listing of admin users.
   */
  public function index(Request $request)
  {
    $query = Admin::query();

    // Search functionality
    if ($request->filled('search')) {
      $search = $request->get('search');
      $query->where(function ($q) use ($search) {
        $q->where('name', 'like', "%{$search}%")
          ->orWhere('email', 'like', "%{$search}%");
      });
    }

    // Filter by status (using email_verified_at)
    if ($request->filled('status')) {
      if ($request->get('status') === 'active') {
        $query->whereNotNull('email_verified_at');
      } elseif ($request->get('status') === 'inactive') {
        $query->whereNull('email_verified_at');
      }
    }

    // Filter by role (using is_super)
    if ($request->filled('role')) {
      if ($request->get('role') === 'super_admin') {
        $query->where('is_super', true);
      } elseif ($request->get('role') === 'admin') {
        $query->where('is_super', false);
      }
    }

    // Sorting
    $sortBy = $request->get('sort_by', 'created_at');
    $sortDirection = $request->get('sort_direction', 'desc');

    $allowedSorts = ['name', 'email', 'created_at', 'last_login_at'];
    if (in_array($sortBy, $allowedSorts)) {
      $query->orderBy($sortBy, $sortDirection);
    }

    $admins = $query->paginate(10)->appends($request->query());

    return view('admin.admins.index', compact('admins'));
  }

  /**
   * Show the form for creating a new admin.
   */
  public function create()
  {
    return view('admin.admins.create');
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
      'role' => 'required|in:admin,super_admin',
      'status' => 'required|in:active,inactive',
    ]);

    Admin::create([
      'name' => $request->name,
      'email' => $request->email,
      'password' => Hash::make($request->password),
      'is_super' => $request->role === 'super_admin',
      'email_verified_at' => $request->status === 'active' ? now() : null,
    ]);

    return redirect()->route('admin.admins.index')
      ->with('success', 'Admin created successfully.');
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
    return view('admin.admins.edit', compact('admin'));
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
      'role' => 'required|in:admin,super_admin',
      'status' => 'required|in:active,inactive',
    ]);

    $updateData = [
      'name' => $request->name,
      'email' => $request->email,
      'is_super' => $request->role === 'super_admin',
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
