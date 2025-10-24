<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\JobController as AdminJobController;
use App\Http\Controllers\Admin\ApplicationController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Admin\AdminNotificationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/locale', function (Request $request) {
    $validated = $request->validate([
        'locale' => 'required|in:' . implode(',', config('app.available_locales')),
    ]);

    session(['locale' => $validated['locale']]);

    return back();
})->name('locale.switch');

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

// Public Job routes
Route::prefix('jobs')->name('jobs.')->group(function () {
    Route::get('/', [JobController::class, 'index'])->name('index');
    Route::get('/{job}', [JobController::class, 'show'])->name('show');

    // Authentication required for applying
    Route::middleware(['auth', 'verified'])->group(function () {
        Route::get('/{job}/apply', [JobController::class, 'apply'])->name('apply');
        Route::post('/{job}/apply', [JobController::class, 'storeApplication'])->name('apply.store');
    });
});

// Admin routes
Route::prefix('admin')->name('admin.')->group(function () {
    // Auth routes (public routes for admin authentication)
    Route::middleware('guest:admin')->group(function () {
        Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
    });

    // Protected admin routes
    Route::middleware(['admin'])->group(function () {
        Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard.index');
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

        // User management routes
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::get('/users/deleted', [UserController::class, 'deleted'])->name('users.deleted');
        Route::post('/users/{id}/restore', [UserController::class, 'restore'])->name('users.restore');
        Route::delete('/users/{id}/force-delete', [UserController::class, 'forceDelete'])->name('users.force-delete');
        Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
        Route::patch('/users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

        // Job management routes
        Route::get('/jobs', [AdminJobController::class, 'index'])->name('jobs.index');
        Route::get('/jobs/create', [AdminJobController::class, 'create'])->name('jobs.create');
        Route::post('/jobs', [AdminJobController::class, 'store'])->name('jobs.store');
        Route::get('/jobs/deleted', [AdminJobController::class, 'deleted'])->name('jobs.deleted');
        Route::patch('/jobs/restore-all', [AdminJobController::class, 'restoreAll'])->name('jobs.restore-all');
        Route::delete('/jobs/force-delete-all', [AdminJobController::class, 'forceDeleteAll'])->name('jobs.force-delete-all');
        Route::get('/jobs/{job}', [AdminJobController::class, 'show'])->name('jobs.show');
        Route::get('/jobs/{job}/edit', [AdminJobController::class, 'edit'])->name('jobs.edit');
        Route::patch('/jobs/{job}', [AdminJobController::class, 'update'])->name('jobs.update');
        Route::patch('/jobs/{job}/toggle-status', [AdminJobController::class, 'toggleStatus'])->name('jobs.toggle-status');
        Route::patch('/jobs/{job}/extend-deadline', [AdminJobController::class, 'extendDeadline'])->name('jobs.extend-deadline');
        Route::delete('/jobs/{job}', [AdminJobController::class, 'destroy'])->name('jobs.destroy');
        Route::patch('/jobs/{id}/restore', [AdminJobController::class, 'restore'])->name('jobs.restore');
        Route::delete('/jobs/{id}/force-delete', [AdminJobController::class, 'forceDelete'])->name('jobs.force-delete');

        // Application management routes
        Route::get('/applications', [ApplicationController::class, 'index'])->name('applications.index');
        Route::get('/applications/{application}', [ApplicationController::class, 'show'])->name('applications.show');
        Route::get('/applications/{application}/edit', [ApplicationController::class, 'edit'])->name('applications.edit');
        Route::put('/applications/{application}', [ApplicationController::class, 'update'])->name('applications.update');
        Route::patch('/applications/{application}/status', [ApplicationController::class, 'updateStatus'])->name('applications.update-status');
        Route::delete('/applications/{application}', [ApplicationController::class, 'destroy'])->name('applications.destroy');
        Route::patch('/applications/bulk-update-status', [ApplicationController::class, 'bulkUpdateStatus'])->name('applications.bulk-update-status');
        Route::delete('/applications/bulk-delete', [ApplicationController::class, 'bulkDelete'])->name('applications.bulk-delete');

        // Category management routes
        Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
        Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
        Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
        Route::post('/categories/add-subcategories', [CategoryController::class, 'addSubcategories'])->name('categories.add-subcategories');
        Route::get('/categories/{category}/subcategories', [CategoryController::class, 'getSubcategories'])->name('categories.subcategories');
        Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
        Route::patch('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
        Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

        // Deleted categories routes
        Route::get('/categories/deleted', [CategoryController::class, 'deleted'])->name('categories.deleted');
        Route::post('/categories/{id}/restore', [CategoryController::class, 'restore'])->name('categories.restore');
        Route::delete('/categories/{id}/force-delete', [CategoryController::class, 'forceDelete'])->name('categories.force-delete');



        // Admin management routes (Super Admin only)
        Route::get('/admins', [AdminController::class, 'index'])->name('admins.index');
        Route::get('/admins/create', [AdminController::class, 'create'])->name('admins.create');
        Route::post('/admins', [AdminController::class, 'store'])->name('admins.store');
        Route::get('/admins/{admin}', [AdminController::class, 'show'])->name('admins.show');
        Route::get('/admins/{admin}/edit', [AdminController::class, 'edit'])->name('admins.edit');
        Route::patch('/admins/{admin}', [AdminController::class, 'update'])->name('admins.update');
        Route::patch('/admins/{admin}/toggle-status', [AdminController::class, 'toggleStatus'])->name('admins.toggle-status');
        Route::delete('/admins/{admin}', [AdminController::class, 'destroy'])->name('admins.destroy');

        // Settings
        Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
        Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');

        // Admin notifications
        Route::get('/notifications', [AdminNotificationController::class, 'index'])->name('notifications.index');
        Route::post('/notifications/read-all', [AdminNotificationController::class, 'readAll'])->name('notifications.readAll');
        Route::get('/notifications/open/{id}', [AdminNotificationController::class, 'open'])->name('notifications.open');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // User applications routes
    Route::get('/applications', [JobController::class, 'myApplications'])->name('applications.index');

    // User notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/read-all', [NotificationController::class, 'readAll'])->name('notifications.readAll');
    Route::get('/notifications/open/{id}', [NotificationController::class, 'open'])->name('notifications.open');
});

require __DIR__ . '/auth.php';
