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
    'category_id',
    'sub_category_id',
    'company',
    'salary',
    'location',
    'level',
    'deadline',
    'posted_by',
    'is_active',
    'status',
  ];

  /**
   * The attributes that should be cast.
   *
   * @var array<string, string>
   */
  protected $casts = [
    'deadline' => 'date',
    'is_active' => 'boolean',
    'status' => 'string',
  ];

  /**
   * Get the category that owns the job.
   */
  public function category()
  {
    return $this->belongsTo(Category::class);
  }

  /**
   * Get the sub category that owns the job.
   */
  public function subCategory()
  {
    return $this->belongsTo(SubCategory::class);
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

  /**
   * Scope a query to only include active jobs.
   */
  public function scopeActive($query)
  {
    return $query->where('status', 'active');
  }

  /**
   * Scope a query to only include inactive jobs.
   */
  public function scopeInactive($query)
  {
    return $query->where('status', 'inactive');
  }

  /**
   * Scope a query to only include draft jobs.
   */
  public function scopeDraft($query)
  {
    return $query->where('status', 'draft');
  }

  /**
   * Scope a query to only include visible jobs (active and inactive).
   */
  public function scopeVisible($query)
  {
    return $query->whereIn('status', ['active', 'inactive']);
  }

  /**
   * Check if the job is active.
   */
  public function isActive()
  {
    return $this->status === 'active';
  }

  /**
   * Check if the job is inactive.
   */
  public function isInactive()
  {
    return $this->status === 'inactive';
  }

  /**
   * Check if the job is draft.
   */
  public function isDraft()
  {
    return $this->status === 'draft';
  }
}
