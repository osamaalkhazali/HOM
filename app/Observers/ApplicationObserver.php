<?php

namespace App\Observers;

use App\Models\Application;
use App\Models\Employee;
use Carbon\Carbon;

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
            }
        }
    }
}
