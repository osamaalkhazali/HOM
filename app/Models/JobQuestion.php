<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_id',
        'question',
        'question_ar',
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

    public function applicationAnswers()
    {
        return $this->hasMany(ApplicationQuestionAnswer::class);
    }

    public function getPromptAttribute(): string
    {
        $locale = app()->getLocale();

        return $locale === 'ar' && $this->question_ar
            ? $this->question_ar
            : $this->question;
    }
}
