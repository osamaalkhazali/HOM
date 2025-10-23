<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Concerns\HasLocalizedAttributes;

class SubCategory extends Model
{
  use HasFactory, SoftDeletes, HasLocalizedAttributes;

  protected $appends = [
    'admin_label',
  ];

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'category_id',
    'name',
    'name_ar',
  ];

  /**
   * Get the category that owns the sub category.
   */
  public function category()
  {
    return $this->belongsTo(Category::class);
  }

  /**
   * Get the jobs for the sub category.
   */
  public function jobs()
  {
    return $this->hasMany(Job::class);
  }

  public function getDisplayNameAttribute(): ?string
  {
    return $this->getLocalizedValue('name');
  }

  public function getAdminLabelAttribute(): string
  {
    return $this->formatBilingualLabel('name');
  }

  protected function formatBilingualLabel(string $attribute): string
  {
    $english = $this->getAttribute("{$attribute}_en") ?? $this->getAttribute($attribute) ?? '';
    $arabic = $this->getAttribute("{$attribute}_ar") ?? '';

    if ($english && $arabic && $english !== $arabic) {
      return "{$english} ({$arabic})";
    }

    return $english ?: $arabic ?: '';
  }
}
