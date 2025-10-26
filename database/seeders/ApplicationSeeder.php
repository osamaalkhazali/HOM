<?php

namespace Database\Seeders;

use App\Models\Application;
use App\Models\Job;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Event;

class ApplicationSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    // Disable all event listeners to prevent sending emails
    Event::fake();

    $jobs = Job::where('status', 'active')->get();
    $users = User::all(); // All users (admins are in separate 'admins' table)

    if ($jobs->isEmpty() || $users->isEmpty()) {
      $this->command->error('Please run Job and User seeders first!');
      return;
    }

    $statuses = [
      'pending' => 35,           // 35%
      'under_reviewing' => 25,   // 25%
      'reviewed' => 15,          // 15%
      'shortlisted' => 10,       // 10%
      'rejected' => 10,          // 10%
      'hired' => 5,              // 5%
    ];

    $applicationCount = 0;

    // Create 2-4 applications per user
    foreach ($users as $user) {
      $applicationsToCreate = fake()->numberBetween(2, 4);

      // Get random jobs for this user (avoid duplicates)
      $availableJobs = $jobs->shuffle();
      $selectedJobs = $availableJobs->take(min($applicationsToCreate, $availableJobs->count()));

      foreach ($selectedJobs as $job) {
        // Select status based on weighted probability
        $roll = fake()->numberBetween(1, 100);
        $cumulative = 0;
        $selectedStatus = 'pending';

        foreach ($statuses as $status => $weight) {
          $cumulative += $weight;
          if ($roll <= $cumulative) {
            $selectedStatus = $status;
            break;
          }
        }

        // Create application date between job creation and now (or deadline if expired)
        $maxDate = $job->deadline->isPast() ? $job->deadline : now();
        $applicationDate = fake()->dateTimeBetween($job->created_at, $maxDate);

        // Get CV path from profile or generate a dummy one
        $cvPath = $user->profile && $user->profile->cv_path
          ? $user->profile->cv_path
          : 'cvs/' . $user->id . '_' . $job->id . '_cv.pdf';

        Application::create([
          'job_id' => $job->id,
          'user_id' => $user->id,
          'cv_path' => $cvPath,
          'cover_letter' => fake()->boolean(60) ? fake()->paragraph(3) : null,
          'status' => $selectedStatus,
          'created_at' => $applicationDate,
          'updated_at' => fake()->dateTimeBetween($applicationDate, 'now'),
        ]);

        $applicationCount++;
      }
    }

    $this->command->info("Created {$applicationCount} job applications successfully!");
    $this->command->info("No emails were sent during seeding.");
  }
}
