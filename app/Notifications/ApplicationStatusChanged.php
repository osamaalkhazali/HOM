<?php

namespace App\Notifications;

use App\Models\Application;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;

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
    $jobTitle = optional($this->application->job)->title ?? 'Unknown Job';

    $resolveLabel = function (string $status, string $locale) {
      $key = 'site.application_statuses.' . $status;
      $translation = trans($key, [], $locale);

      if ($translation === $key) {
        return Str::of($status)->replace('_', ' ')->title();
      }

      return $translation;
    };

    $fromEn = $resolveLabel($this->oldStatus, 'en');
    $fromAr = $resolveLabel($this->oldStatus, 'ar');
    $toEn = $resolveLabel($this->newStatus, 'en');
    $toAr = $resolveLabel($this->newStatus, 'ar');

    $bilingualStatusChange = sprintf(
      '%s (%s) → %s (%s)',
      $fromEn,
      $fromAr,
      $toEn,
      $toAr
    );

    return [
      'title' => 'Application status updated',
      'message' => 'Your application for "' . $jobTitle . '" changed: ' . $bilingualStatusChange . '.',
      'application_id' => $this->application->id,
      'job_id' => $this->application->job_id,
      'job_title' => optional($this->application->job)->title,
      'status' => $this->newStatus,
      'link' => route('applications.index'),
      'created_at' => now()->toISOString(),
    ];
  }
}
