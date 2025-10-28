<?php

namespace App\Models;

use App\Models\Application;
use App\Models\Job;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Client extends Model
{
  use HasFactory, SoftDeletes;

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'name',
    'slug',
    'description',
    'logo_path',
    'website_url',
    'is_active',
  ];

  /**
   * The attributes that should be cast.
   *
   * @var array<string, string>
   */
  protected $casts = [
    'is_active' => 'boolean',
  ];

  /**
   * Additional attributes to append.
   *
   * @var array<int, string>
   */
  protected $appends = [
    'logo_url',
  ];

  public function jobs()
  {
    return $this->hasMany(Job::class);
  }

  public function applications()
  {
    return $this->hasManyThrough(Application::class, Job::class);
  }

  /**
   * Scope a query to only include active clients.
   */
  public function scopeActive($query)
  {
    return $query->where('is_active', true);
  }

  /**
   * Accessor for the public logo URL.
   */
  public function getLogoUrlAttribute(): ?string
  {
    if (empty($this->logo_path)) {
      return null;
    }

    $disk = Storage::disk('public');

    if (method_exists($disk, 'url')) {
      return $disk->url($this->logo_path);
    }

    return Storage::url($this->logo_path);
  }
}
