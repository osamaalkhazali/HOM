<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationDocumentRequest extends Model
{
  use HasFactory;

  protected $fillable = [
    'application_id',
    'name',
    'name_ar',
    'notes',
    'is_submitted',
    'submitted_at',
    'file_path',
    'original_name',
  ];

  protected $casts = [
    'is_submitted' => 'boolean',
    'submitted_at' => 'datetime',
  ];

  public function application()
  {
    return $this->belongsTo(Application::class);
  }

  public function getNameLocalizedAttribute()
  {
    return app()->getLocale() === 'ar' && !empty($this->name_ar) ? $this->name_ar : $this->name;
  }
}
