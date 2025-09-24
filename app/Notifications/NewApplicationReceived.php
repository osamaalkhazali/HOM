<?php

namespace App\Notifications;

use App\Models\Application;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewApplicationReceived extends Notification
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
      'title' => 'New application received',
      'message' => 'A new application was submitted for "' . $this->application->job->title . '" by ' . $this->application->user->name . '.',
      'application_id' => $this->application->id,
      'job_id' => $this->application->job_id,
      'job_title' => optional($this->application->job)->title,
      'link' => route('admin.applications.show', $this->application),
      'created_at' => now()->toISOString(),
    ];
  }
}
