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
        $users = User::limit(8)->get();
        $jobs = Job::limit(6)->get();

        if ($users->isEmpty() || $jobs->isEmpty()) {
            $this->command->warn('No users or jobs found. Please seed users and jobs first.');
            return;
        }

        // Scenario 1: Create 3 users with single active employment
        for ($i = 0; $i < 3 && $i < $users->count(); $i++) {
            $user = $users[$i];
            $job = $jobs->random();
            $hireDate = Carbon::now()->subMonths(rand(3, 18));

            Employee::create([
                'user_id' => $user->id,
                'job_id' => $job->id,
                'application_id' => Application::where('user_id', $user->id)->where('job_id', $job->id)->first()?->id,
                'position_title' => $job->title,
                'status' => 'active',
                'hire_date' => $hireDate,
                'end_date' => null,
                'notes' => $this->getRandomNotes('active'),
            ]);

            $this->command->info("✓ Created active employee: {$user->name} - {$job->title}");
        }

        // Scenario 2: Create 2 users hired twice (first resigned/terminated, second active)
        for ($i = 3; $i < 5 && $i < $users->count(); $i++) {
            $user = $users[$i];

            // First employment (resigned or terminated)
            $firstJob = $jobs->random();
            $firstHireDate = Carbon::now()->subMonths(rand(24, 36));
            $firstStatus = rand(0, 1) ? 'resigned' : 'terminated';
            $firstEndDate = $firstHireDate->copy()->addMonths(rand(6, 18));

            Employee::create([
                'user_id' => $user->id,
                'job_id' => $firstJob->id,
                'application_id' => null,
                'position_title' => $firstJob->title,
                'status' => $firstStatus,
                'hire_date' => $firstHireDate,
                'end_date' => $firstEndDate,
                'notes' => $this->getRandomNotes($firstStatus),
            ]);

            // Second employment (active)
            $secondJob = $jobs->where('id', '!=', $firstJob->id)->random();
            $secondHireDate = $firstEndDate->copy()->addMonths(rand(1, 3));

            Employee::create([
                'user_id' => $user->id,
                'job_id' => $secondJob->id,
                'application_id' => Application::where('user_id', $user->id)->where('job_id', $secondJob->id)->first()?->id,
                'position_title' => $secondJob->title,
                'status' => 'active',
                'hire_date' => $secondHireDate,
                'end_date' => null,
                'notes' => 'Re-hired after previous employment. Excellent performance.',
            ]);

            $this->command->info("✓ Created dual employment: {$user->name} - {$firstStatus} → active");
        }

        // Scenario 3: Create 2 users with resigned status
        for ($i = 5; $i < 7 && $i < $users->count(); $i++) {
            $user = $users[$i];
            $job = $jobs->random();
            $hireDate = Carbon::now()->subMonths(rand(12, 30));
            $endDate = $hireDate->copy()->addMonths(rand(6, 20));

            Employee::create([
                'user_id' => $user->id,
                'job_id' => $job->id,
                'application_id' => null,
                'position_title' => $job->title,
                'status' => 'resigned',
                'hire_date' => $hireDate,
                'end_date' => $endDate,
                'notes' => $this->getRandomNotes('resigned'),
            ]);

            $this->command->info("✓ Created resigned employee: {$user->name} - {$job->title}");
        }

        // Scenario 4: Create 1 user with transferred status
        if ($users->count() > 7) {
            $user = $users[7];
            $job = $jobs->random();
            $hireDate = Carbon::now()->subMonths(rand(6, 15));

            Employee::create([
                'user_id' => $user->id,
                'job_id' => $job->id,
                'application_id' => null,
                'position_title' => $job->title,
                'status' => 'transferred',
                'hire_date' => $hireDate,
                'end_date' => null,
                'notes' => 'Transferred to another department/location.',
            ]);

            $this->command->info("✓ Created transferred employee: {$user->name} - {$job->title}");
        }

        $totalEmployees = Employee::count();
        $this->command->info("🎉 Employee seeding completed! Total records: {$totalEmployees}");
    }

    /**
     * Get random notes based on status
     */
    private function getRandomNotes(string $status): ?string
    {
        $notes = [
            'active' => [
                'Excellent performer, consistently exceeds targets.',
                'Great team player with strong communication skills.',
                'Shows leadership potential and initiative.',
                'Highly skilled and self-motivated.',
                null, // Some without notes
            ],
            'resigned' => [
                'Resigned for career advancement opportunity.',
                'Left to pursue higher education.',
                'Relocated to another city for family reasons.',
                'Accepted better opportunity at competitor.',
                'Left on good terms, eligible for rehire.',
            ],
            'terminated' => [
                'Performance did not meet expectations after warnings.',
                'Violation of company policy.',
                'Position eliminated due to restructuring.',
                'Contract not renewed at end of term.',
            ],
            'transferred' => [
                'Transferred to head office.',
                'Moved to new branch location.',
                'Transferred to sister company.',
            ],
        ];

        $statusNotes = $notes[$status] ?? [null];
        return $statusNotes[array_rand($statusNotes)];
    }
}
