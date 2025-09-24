<?php

namespace App\Notifications;

use App\Models\Application;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ApplicationStatusChanged extends Notification
{
  use Queueable;

  public function __construct(public Application $application, public string $oldStatus, public string $newStatus) {}

  public function via(object $notifiable): array
  {
    return ['database'];
  }

  public function toArray(object $notifiable): array
  {
    return [
      'title' => 'Application status updated',
      'message' => 'Your application for "' . $this->application->job->title . '" changed from ' . ucfirst($this->oldStatus) . ' to ' . ucfirst($this->newStatus) . '.',
      'application_id' => $this->application->id,
      'job_id' => $this->application->job_id,
      'job_title' => optional($this->application->job)->title,
      'status' => $this->newStatus,
      'link' => route('applications.index'),
      'created_at' => now()->toISOString(),
    ];
  }
}
