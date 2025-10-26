<?php

namespace App\Http\Controllers\Concerns;

use App\Models\Admin;
use App\Models\Application;
use App\Notifications\ApplicationStatusNotification;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

trait SendsApplicationStatusNotifications
{
  protected function sendStatusNotifications(Application $application, string $status, ?Collection $admins = null): void
  {
    try {
      $application->loadMissing(['job', 'user']);

      // Send notification to user
      if ($application->user) {
        try {
          Notification::send(
            $application->user,
            new ApplicationStatusNotification($application, $status, 'user')
          );
        } catch (\Throwable $userNotificationError) {
          // Log the error but don't stop the process
          Log::error('Failed to send notification to user', [
            'user_id' => $application->user->id,
            'application_id' => $application->id,
            'status' => $status,
            'error' => $userNotificationError->getMessage(),
            'trace' => $userNotificationError->getTraceAsString(),
          ]);

          // Report to error tracking (Sentry, etc.) but continue
          report($userNotificationError);
        }
      }

      // Send notification to admins (only those who opt-in)
      $adminRecipients = ($admins ?? Admin::active()->get())
        ->filter(fn(Admin $admin) => $admin->wantsApplicationEmails());
      if ($adminRecipients->isNotEmpty()) {
        try {
          Notification::send(
            $adminRecipients,
            new ApplicationStatusNotification($application, $status, 'admin')
          );
        } catch (\Throwable $adminNotificationError) {
          // Log the error but don't stop the process
          Log::error('Failed to send notification to admins', [
            'admin_count' => $adminRecipients->count(),
            'application_id' => $application->id,
            'status' => $status,
            'error' => $adminNotificationError->getMessage(),
            'trace' => $adminNotificationError->getTraceAsString(),
          ]);

          // Report to error tracking but continue
          report($adminNotificationError);
        }
      }
    } catch (\Throwable $e) {
      // Catch any other unexpected errors
      Log::error('Unexpected error in sendStatusNotifications', [
        'application_id' => $application->id ?? null,
        'status' => $status,
        'error' => $e->getMessage(),
        'trace' => $e->getTraceAsString(),
      ]);

      report($e);
    }
  }
}
