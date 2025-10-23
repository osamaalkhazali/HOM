<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_id',
        'name',
        'name_ar',
        'is_required',
        'display_order',
    ];

    protected $casts = [
        'is_required' => 'boolean',
    ];

    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    public function applicationDocuments()
    {
        return $this->hasMany(ApplicationDocument::class);
    }

    public function getLabelAttribute(): string
    {
        $locale = app()->getLocale();

        return $locale === 'ar' && $this->name_ar
            ? $this->name_ar
            : $this->name;
    }
}
