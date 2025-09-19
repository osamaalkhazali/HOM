<?php

namespace Database\Seeders;

use App\Models\Application;
use App\Models\Job;
use App\Models\User;
use Illuminate\Database\Seeder;

class ApplicationSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $jobs = Job::where('is_active', true)->get();
    $users = User::all();

    if ($jobs->isEmpty() || $users->isEmpty()) {
      $this->command->error('Please run Job and User seeders first!');
      return;
    }

    $statuses = ['pending', 'reviewed', 'shortlisted', 'rejected', 'hired'];
    $applicationCount = 0;

    // Create applications for each job
    foreach ($jobs as $job) {
      // Each job gets 1-8 applications
      $applicationsForJob = fake()->numberBetween(1, 8);

      // Get random users for this job (avoid duplicates)
      $selectedUsers = $users->random(min($applicationsForJob, $users->count()));

      foreach ($selectedUsers as $user) {
        $status = $statuses[array_rand($statuses)];

        Application::create([
          'job_id' => $job->id,
          'user_id' => $user->id,
          'cv_path' => 'cvs/' . $user->id . '_' . $job->id . '_cv.pdf',
          'status' => $status,
          'created_at' => fake()->dateTimeBetween($job->created_at, 'now'),
          'updated_at' => now(),
        ]);

        $applicationCount++;
      }
    }

    $this->command->info("Created {$applicationCount} job applications successfully!");
  }
}
