<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Employee;
use App\Models\User;
use App\Models\Job;
use App\Models\Application;
use Carbon\Carbon;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get some hired applications
        $hiredApplications = Application::where('status', 'hired')->get();

        if ($hiredApplications->isEmpty()) {
            // If no hired applications exist, create some sample employees directly
            $users = User::limit(10)->get();
            $jobs = Job::limit(5)->get();

            if ($users->isEmpty() || $jobs->isEmpty()) {
                $this->command->warn('No users or jobs found. Please seed users and jobs first.');
                return;
            }

            $statuses = ['active', 'on_leave', 'resigned', 'terminated'];

            foreach ($users as $index => $user) {
                $job = $jobs->random();
                $status = $statuses[array_rand($statuses)];

                // Random hire date within the last 2 years
                $hireDate = Carbon::now()->subDays(rand(1, 730));

                // Set end date for resigned/terminated employees
                $endDate = null;
                if (in_array($status, ['resigned', 'terminated'])) {
                    $endDate = $hireDate->copy()->addDays(rand(30, 365));
                }

                Employee::create([
                    'user_id' => $user->id,
                    'job_id' => $job->id,
                    'application_id' => null,
                    'position_title' => $job->title,
                    'status' => $status,
                    'hire_date' => $hireDate,
                    'end_date' => $endDate,
                    'notes' => $this->getRandomNotes($status),
                ]);

                $this->command->info("Created employee record for {$user->name}");
            }
        } else {
            // Create employee records for hired applications
            foreach ($hiredApplications as $application) {
                // Check if employee already exists
                if (Employee::where('application_id', $application->id)->exists()) {
                    continue;
                }

                $status = 'active';
                $hireDate = Carbon::parse($application->updated_at);
                $endDate = null;

                // Randomly assign some as resigned or terminated for testing
                if (rand(1, 10) > 7) { // 30% chance
                    $status = rand(0, 1) ? 'resigned' : 'terminated';
                    $endDate = $hireDate->copy()->addDays(rand(30, 365));
                }

                Employee::create([
                    'user_id' => $application->user_id,
                    'job_id' => $application->job_id,
                    'application_id' => $application->id,
                    'position_title' => $application->job->title,
                    'status' => $status,
                    'hire_date' => $hireDate,
                    'end_date' => $endDate,
                    'notes' => $this->getRandomNotes($status),
                ]);

                $this->command->info("Created employee record for application #{$application->id}");
            }
        }

        $this->command->info('Employee seeding completed successfully!');
    }

    /**
     * Get random notes based on status
     */
    private function getRandomNotes(string $status): ?string
    {
        $notes = [
            'active' => [
                'Excellent performer, consistently meets targets.',
                'Great team player, always willing to help.',
                'Shows strong leadership potential.',
                'Highly skilled and motivated employee.',
                null, // Some employees may not have notes
            ],
            'on_leave' => [
                'On maternity leave until further notice.',
                'Medical leave - expected return in 3 months.',
                'Sabbatical leave approved for 6 months.',
                'Family emergency leave.',
            ],
            'resigned' => [
                'Resigned for career advancement opportunity.',
                'Left for higher education pursuits.',
                'Relocating to another city.',
                'Accepted position at another company.',
            ],
            'terminated' => [
                'Performance issues - multiple warnings issued.',
                'Violation of company policies.',
                'Position eliminated due to restructuring.',
                'Contract not renewed.',
            ],
        ];

        $statusNotes = $notes[$status] ?? [null];
        return $statusNotes[array_rand($statusNotes)];
    }
}
