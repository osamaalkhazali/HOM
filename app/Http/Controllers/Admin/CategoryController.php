<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Job;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
  /**
   * Display a listing of categories with simple filtering and sorting
   */
  public function index(Request $request)
  {
    $query = Category::withCount(['subCategories']);

    // Simple search functionality
    if ($request->filled('search')) {
      $search = $request->search;
      $query->where(function ($q) use ($search) {
        $q->where('name', 'like', "%{$search}%")
          ->orWhereHas('subCategories', function ($subQuery) use ($search) {
            $subQuery->where('name', 'like', "%{$search}%");
          });
      });
    }

    // Simple sorting
    $query->orderBy('name', 'asc');

    $categories = $query->paginate(15)->withQueryString();

    // Get subcategories with job counts
    $subCategories = SubCategory::with(['category', 'jobs'])
      ->withCount('jobs')
      ->when($request->filled('search'), function ($q) use ($request) {
        $q->where('name', 'like', "%{$request->search}%");
      })
      ->orderBy('name')
      ->get()
      ->groupBy('category_id');

    // Simple statistics
    $stats = [
      'total_categories' => Category::count(),
      'total_subcategories' => SubCategory::count(),
      'categories_with_jobs' => Category::whereHas('subCategories.jobs')->count(),
    ];

    return view('admin.categories.index', compact('categories', 'subCategories', 'stats'));
  }

  /**
   * Show the form for creating a new category
   */
  public function create()
  {
    $categories = Category::withCount('subCategories')->orderBy('name')->get();
    return view('admin.categories.create', compact('categories'));
  }

  /**
   * Store a newly created category
   */
  public function store(Request $request)
  {
    $validated = $request->validate([
      'name' => 'required|string|max:255|unique:categories,name',
      'subcategories' => 'array',
      'subcategories.*' => 'string|max:255'
    ]);

    $category = Category::create([
      'name' => $validated['name']
    ]);

    // Create subcategories if provided
    if (!empty($validated['subcategories'])) {
      foreach ($validated['subcategories'] as $subCategoryName) {
        if (!empty(trim($subCategoryName))) {
          SubCategory::create([
            'name' => trim($subCategoryName),
            'category_id' => $category->id
          ]);
        }
      }
    }

    return redirect()->route('admin.categories.index')->with('success', 'Category created successfully');
  }

  /**
   * Add subcategories to existing category
   */
  public function addSubcategories(Request $request)
  {
    $validated = $request->validate([
      'category_id' => 'required|exists:categories,id',
      'new_subcategories' => 'required|array|min:1',
      'new_subcategories.*' => 'string|max:255'
    ]);

    $category = Category::findOrFail($validated['category_id']);

    $addedCount = 0;
    foreach ($validated['new_subcategories'] as $subCategoryName) {
      $trimmedName = trim($subCategoryName);
      if (!empty($trimmedName)) {
        // Check if subcategory already exists for this category
        $exists = SubCategory::where('category_id', $category->id)
          ->where('name', $trimmedName)
          ->exists();

        if (!$exists) {
          SubCategory::create([
            'name' => $trimmedName,
            'category_id' => $category->id
          ]);
          $addedCount++;
        }
      }
    }

    $message = $addedCount > 0
      ? "Successfully added {$addedCount} new subcategories to '{$category->name}'"
      : "No new subcategories were added (duplicates or empty names)";

    return redirect()->route('admin.categories.index')->with('success', $message);
  }

  /**
   * Get subcategories for a category (AJAX)
   */
  public function getSubcategories(Category $category)
  {
    $subcategories = $category->subCategories()
      ->withCount('jobs')
      ->orderBy('name')
      ->get(['id', 'name']);

    return response()->json([
      'subcategories' => $subcategories->map(function ($sub) {
        return [
          'id' => $sub->id,
          'name' => $sub->name,
          'jobs_count' => $sub->jobs_count
        ];
      })
    ]);
  }

  /**
   * Show the form for editing the specified category
   */
  public function edit(Category $category)
  {
    $category->load('subCategories');
    return view('admin.categories.edit', compact('category'));
  }

  /**
   * Update the specified category
   */
  public function update(Request $request, Category $category)
  {
    $validated = $request->validate([
      'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
      'existing_subcategories' => 'array',
      'existing_subcategories.*.id' => 'required|exists:sub_categories,id',
      'existing_subcategories.*.name' => 'required|string|max:255',
      'new_subcategories' => 'array',
      'new_subcategories.*' => 'string|max:255',
      'delete_subcategories' => 'array',
      'delete_subcategories.*' => 'exists:sub_categories,id'
    ]);

    // Update category name
    $category->update([
      'name' => $validated['name']
    ]);

    // Handle existing subcategories updates
    if (isset($validated['existing_subcategories'])) {
      foreach ($validated['existing_subcategories'] as $subCatData) {
        $subCategory = SubCategory::find($subCatData['id']);
        if ($subCategory && $subCategory->category_id === $category->id) {
          $subCategory->update([
            'name' => trim($subCatData['name'])
          ]);
        }
      }
    }

    // Handle subcategory deletions (only those without jobs)
    if (isset($validated['delete_subcategories'])) {
      foreach ($validated['delete_subcategories'] as $subCatId) {
        $subCategory = SubCategory::find($subCatId);
        if ($subCategory && $subCategory->category_id === $category->id) {
          // Only delete if no jobs are associated
          if ($subCategory->jobs()->count() === 0) {
            $subCategory->delete();
          }
        }
      }
    }

    // Handle new subcategories
    if (isset($validated['new_subcategories'])) {
      foreach ($validated['new_subcategories'] as $subCategoryName) {
        if (!empty(trim($subCategoryName))) {
          SubCategory::create([
            'name' => trim($subCategoryName),
            'category_id' => $category->id
          ]);
        }
      }
    }

    return redirect()->route('admin.categories.index')->with('success', 'Category and subcategories updated successfully');
  }

  /**
   * Remove the specified category
   */
  public function destroy(Category $category)
  {
    // Check if category has jobs through subcategories
    $jobsCount = $category->subCategories()
      ->withCount('jobs')
      ->get()
      ->sum('jobs_count');

    if ($jobsCount > 0) {
      return redirect()->back()->with('error', "Cannot delete category with {$jobsCount} existing jobs. Please move or delete the jobs first.");
    }

    $categoryName = $category->name;
    $category->delete();

    return redirect()->route('admin.categories.index')->with('success', "Category '{$categoryName}' deleted successfully");
  }

  /**
   * Display deleted categories
   */
  public function deleted(Request $request)
  {
    $query = Category::onlyTrashed()->withCount(['subCategories']);

    // Search functionality for deleted categories
    if ($request->filled('search')) {
      $search = $request->search;
      $query->where('name', 'like', "%{$search}%");
    }

    // Sort by deletion date (most recent first)
    $query->orderBy('deleted_at', 'desc');

    $deletedCategories = $query->paginate(15)->withQueryString();

    // Statistics for deleted categories
    $stats = [
      'total_deleted' => Category::onlyTrashed()->count(),
      'deleted_this_month' => Category::onlyTrashed()
        ->whereMonth('deleted_at', now()->month)
        ->whereYear('deleted_at', now()->year)
        ->count(),
    ];

    return view('admin.categories.deleted', compact('deletedCategories', 'stats'));
  }

  /**
   * Restore a deleted category
   */
  public function restore($id)
  {
    $category = Category::onlyTrashed()->findOrFail($id);
    $categoryName = $category->name;

    $category->restore();

    return redirect()->back()->with('success', "Category '{$categoryName}' restored successfully");
  }

  /**
   * Permanently delete a category
   */
  public function forceDelete($id)
  {
    $category = Category::onlyTrashed()->findOrFail($id);
    $categoryName = $category->name;

    // Force delete all associated subcategories
    $category->subCategories()->forceDelete();

    $category->forceDelete();

    return redirect()->back()->with('success', "Category '{$categoryName}' permanently deleted");
  }
}
