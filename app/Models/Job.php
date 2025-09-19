<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Job extends Model
{
  use HasFactory, SoftDeletes;

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'title',
    'description',
    'sub_category_id',
    'company',
    'salary',
    'location',
    'level',
    'deadline',
    'posted_by',
    'is_active',
  ];

  /**
   * The attributes that should be cast.
   *
   * @var array<string, string>
   */
  protected $casts = [
    'salary' => 'decimal:2',
    'deadline' => 'date',
    'is_active' => 'boolean',
  ];

  /**
   * Get the sub category that owns the job.
   */
  public function subCategory()
  {
    return $this->belongsTo(SubCategory::class);
  }

  /**
   * Get the category through sub category.
   */
  public function category()
  {
    return $this->hasOneThrough(Category::class, SubCategory::class, 'id', 'id', 'sub_category_id', 'category_id');
  }

  /**
   * Get the user who posted the job.
   */
  public function postedBy()
  {
    return $this->belongsTo(User::class, 'posted_by');
  }

  /**
   * Get the applications for the job.
   */
  public function applications()
  {
    return $this->hasMany(Application::class);
  }

  /**
   * Check if the job application deadline has passed.
   */
  public function isExpired()
  {
    return $this->deadline < now()->toDateString();
  }

  /**
   * Check if the job is still accepting applications.
   */
  public function isAcceptingApplications()
  {
    return $this->is_active && !$this->isExpired();
  }

  /**
   * Scope a query to only include jobs that are still accepting applications.
   */
  public function scopeAcceptingApplications($query)
  {
    return $query->where('is_active', true)
      ->where('deadline', '>=', now()->toDateString());
  }

  /**
   * Scope a query to only include expired jobs.
   */
  public function scopeExpired($query)
  {
    return $query->where('deadline', '<', now()->toDateString());
  }
}
