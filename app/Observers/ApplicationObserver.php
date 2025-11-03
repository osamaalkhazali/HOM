<?php

namespace App\Observers;

use App\Models\Application;
use App\Models\Employee;
use App\Models\Admin;
use App\Notifications\ApplicationStatusNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Log;

class ApplicationObserver
{
    /**
     * Handle the Application "updated" event.
     */
    public function updated(Application $application): void
    {
        // Check if status was changed to 'hired'
        if ($application->isDirty('status') && $application->status === 'hired') {
            // Check if an employee record already exists for this application
            $existingEmployee = Employee::where('application_id', $application->id)->first();

            if (!$existingEmployee) {
                // Create new employee record
                Employee::create([
                    'user_id' => $application->user_id,
                    'application_id' => $application->id,
                    'job_id' => $application->job_id,
                    'position_title' => $application->job->title ?? null,
                    'status' => 'active',
                    'hire_date' => Carbon::today(),
                    'notes' => 'Automatically created from application #' . $application->id,
                ]);

                // Send notification to Client HR
                $this->notifyClientHR($application);
            }
        }
    }

    /**
     * Notify the Client HR about the new hire
     */
    protected function notifyClientHR(Application $application): void
    {
        try {
            $application->loadMissing(['job', 'user']);

            // Get the client_id from the job
            $clientId = $application->job?->client_id;

            if ($clientId) {
                // Find the Client HR for this client
                $clientHR = Admin::where('role', 'client_hr')
                    ->where('client_id', $clientId)
                    ->whereNotNull('email_verified_at')
                    ->first();

                if ($clientHR) {
                    // Send notification to Client HR
                    Notification::send(
                        $clientHR,
                        new ApplicationStatusNotification($application, 'hired', 'admin')
                    );

                    Log::info('Notified Client HR about new hire', [
                        'client_hr_id' => $clientHR->id,
                        'client_hr_email' => $clientHR->email,
                        'application_id' => $application->id,
                        'user_id' => $application->user_id,
                        'job_id' => $application->job_id,
                    ]);
                }
            }
        } catch (\Throwable $e) {
            // Log the error but don't stop the employee creation process
            Log::error('Failed to notify Client HR about new hire', [
                'application_id' => $application->id ?? null,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            report($e);
        }
    }
}
