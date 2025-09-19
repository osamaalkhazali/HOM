<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubCategory extends Model
{
  use HasFactory, SoftDeletes;

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'category_id',
    'name',
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
}
