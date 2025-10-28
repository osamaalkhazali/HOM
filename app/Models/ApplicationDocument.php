<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'application_id',
        'job_document_id',
        'file_path',
        'original_name',
    ];

    public function application()
    {
        return $this->belongsTo(Application::class);
    }

    public function jobDocument()
    {
        return $this->belongsTo(JobDocument::class);
    }

    public function getDownloadUrlAttribute(): string
    {
        if (!$this->file_path) {
            return '';
        }

        $application = $this->application;

        if (!$application) {
            return '';
        }

        if (auth('admin')->check()) {
            return route('admin.applications.documents.download', [$application, $this]);
        }

        if (auth()->check() && auth()->id() === $application->user_id) {
            return route('applications.documents.download', [$application, $this]);
        }

        // Default to admin route for background tasks/exports where guard isn't set.
        return route('admin.applications.documents.download', [$application, $this]);
    }
}
