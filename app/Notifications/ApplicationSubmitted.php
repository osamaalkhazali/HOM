<?php

namespace App\Notifications;

use App\Models\Application;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ApplicationSubmitted extends Notification
{
    use Queueable;

    public function __construct(public Application $application) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Application submitted successfully',
            'message' => 'Your application for "' . $this->application->job->title . '" was submitted.',
            'application_id' => $this->application->id,
            'job_id' => $this->application->job_id,
            'job_title' => optional($this->application->job)->title,
            'link' => route('applications.index'),
            'created_at' => now()->toISOString(),
        ];
    }
}
