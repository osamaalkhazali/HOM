<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Client;
use App\Models\Admin;
use App\Models\User;
use App\Models\Profile;
use App\Models\Job;
use App\Models\SubCategory;
use App\Models\Application;
use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class SecondClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('🏢 Creating second client setup...');

        // 1. Create Second Client
        $client = Client::create([
            'name' => 'TechVision Solutions',
            'slug' => 'techvision-solutions',
            'logo_path' => 'clients/techvision-logo.png',
            'description' => 'Leading software development and IT consulting company specializing in enterprise solutions.',
            'website_url' => 'https://techvision-solutions.com',
            'is_active' => true,
        ]);
        $this->command->info("✓ Created client: {$client->name}");

        // 2. Create Client HR Account
        $clientHR = Admin::create([
            'name' => 'Sarah Johnson',
            'email' => 'o.a.alkhazali@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'client_hr',
            'client_id' => $client->id,
            'email_verified_at' => now(),
        ]);
        $this->command->info("✓ Created Client HR: {$clientHR->email} (password: password)");

        // 3. Get subcategories for jobs
        $itSubCategory = SubCategory::whereHas('category', function($q) {
            $q->where('name', 'Information Technology');
        })->first();

        $marketingSubCategory = SubCategory::whereHas('category', function($q) {
            $q->where('name', 'Marketing');
        })->first();

        // 4. Create Jobs
        $jobs = [];

        $jobs[] = Job::create([
            'title' => 'Senior Full Stack Developer',
            'description' => 'We are seeking an experienced Full Stack Developer to join our development team. You will work on cutting-edge web applications using modern technologies. Requirements: 5+ years of experience in web development, strong knowledge of React, Node.js, and PostgreSQL, experience with cloud platforms (AWS/Azure), excellent problem-solving skills.',
            'location' => 'San Francisco, CA',
            'salary' => 140000,
            'level' => 'senior',
            'status' => 'active',
            'company' => $client->name,
            'deadline' => Carbon::now()->addMonths(2),
            'client_id' => $client->id,
            'sub_category_id' => $itSubCategory?->id,
            'posted_by' => User::first()->id,
            'is_active' => true,
        ]);

        $jobs[] = Job::create([
            'title' => 'DevOps Engineer',
            'description' => 'Join our infrastructure team to build and maintain our cloud infrastructure and CI/CD pipelines. Requirements: 3+ years of DevOps experience, strong knowledge of Docker and Kubernetes, experience with AWS or Azure, proficiency in scripting (Python, Bash). Remote work available with flexible hours.',
            'location' => 'Remote',
            'salary' => 120000,
            'level' => 'mid',
            'status' => 'active',
            'company' => $client->name,
            'deadline' => Carbon::now()->addMonths(1),
            'client_id' => $client->id,
            'sub_category_id' => $itSubCategory?->id,
            'posted_by' => User::first()->id,
            'is_active' => true,
        ]);

        $jobs[] = Job::create([
            'title' => 'Digital Marketing Manager',
            'description' => 'Lead our digital marketing efforts to drive brand awareness and customer acquisition. Requirements: 4+ years in digital marketing, experience with SEO, SEM, and social media, strong analytical skills, proven track record of successful campaigns. Competitive salary with performance bonuses.',
            'location' => 'New York, NY',
            'salary' => 100000,
            'level' => 'mid',
            'status' => 'active',
            'company' => $client->name,
            'deadline' => Carbon::now()->addMonth(),
            'client_id' => $client->id,
            'sub_category_id' => $marketingSubCategory?->id,
            'posted_by' => User::first()->id,
            'is_active' => true,
        ]);

        $this->command->info("✓ Created " . count($jobs) . " jobs for {$client->name}");

        // 5. Get existing users for applications
        $existingUsers = User::whereDoesntHave('employees')
            ->orWhereHas('employees', function($q) {
                $q->where('status', '!=', 'active');
            })
            ->limit(5)
            ->get();

        if ($existingUsers->count() < 3) {
            $this->command->warn("Not enough users found. Using any available users.");
            $existingUsers = User::limit(5)->get();
        }

        $this->command->info("✓ Using " . $existingUsers->count() . " existing users");

        // 6. Create Applications and Hire Employees

        if ($existingUsers->count() >= 3) {
            // Application 1: Full Stack Developer - Hired (Active)
            $user1 = $existingUsers[0];
            $app1 = Application::create([
                'user_id' => $user1->id,
                'job_id' => $jobs[0]->id,
                'status' => 'hired',
                'cover_letter' => 'I am excited to apply for the Senior Full Stack Developer position. With my experience in web development, I am confident I can contribute significantly to your team.',
                'cv_path' => $user1->profile?->cv_path ?? 'cvs/default-cv.pdf',
                'created_at' => Carbon::now()->subMonths(2),
                'updated_at' => Carbon::now()->subMonths(1),
            ]);

            Employee::create([
                'user_id' => $user1->id,
                'job_id' => $jobs[0]->id,
                'application_id' => $app1->id,
                'position_title' => 'Senior Full Stack Developer',
                'status' => 'active',
                'hire_date' => Carbon::now()->subMonth(),
                'end_date' => null,
                'notes' => 'Excellent technical skills. Quick learner and great team fit.',
            ]);

            // Application 2: DevOps - Hired but Resigned
            $user2 = $existingUsers[1];
            $app2 = Application::create([
                'user_id' => $user2->id,
                'job_id' => $jobs[1]->id,
                'status' => 'hired',
                'cover_letter' => 'I would love to join TechVision as a DevOps Engineer. My experience aligns perfectly with your needs.',
                'cv_path' => $user2->profile?->cv_path ?? 'cvs/default-cv.pdf',
                'created_at' => Carbon::now()->subMonths(6),
                'updated_at' => Carbon::now()->subMonths(5),
            ]);

            Employee::create([
                'user_id' => $user2->id,
                'job_id' => $jobs[1]->id,
                'application_id' => $app2->id,
                'position_title' => 'DevOps Engineer',
                'status' => 'resigned',
                'hire_date' => Carbon::now()->subMonths(5),
                'end_date' => Carbon::now()->subWeeks(2),
                'notes' => 'Left for a senior position at another company. Good performance during employment.',
            ]);

            // Application 3: Marketing Manager - Hired (Active)
            $user3 = $existingUsers[2];
            $app3 = Application::create([
                'user_id' => $user3->id,
                'job_id' => $jobs[2]->id,
                'status' => 'hired',
                'cover_letter' => 'I am thrilled to apply for the Digital Marketing Manager role. My track record includes proven success in digital campaigns.',
                'cv_path' => $user3->profile?->cv_path ?? 'cvs/default-cv.pdf',
                'created_at' => Carbon::now()->subMonths(3),
                'updated_at' => Carbon::now()->subMonths(2),
            ]);

            Employee::create([
                'user_id' => $user3->id,
                'job_id' => $jobs[2]->id,
                'application_id' => $app3->id,
                'position_title' => 'Digital Marketing Manager',
                'status' => 'active',
                'hire_date' => Carbon::now()->subMonths(2),
                'end_date' => null,
                'notes' => 'Strong marketing strategy skills. Already showing positive results.',
            ]);
        }

        // Create a few more applications (not hired) for realism
        $remainingUsers = User::whereNotIn('id', $existingUsers->pluck('id')->toArray())->limit(3)->get();
        foreach ($remainingUsers as $user) {
            if (count($jobs) > 0) {
                Application::create([
                    'user_id' => $user->id,
                    'job_id' => $jobs[rand(0, 2)]->id,
                    'status' => ['pending', 'under_reviewing', 'reviewed', 'shortlisted'][rand(0, 3)],
                    'cover_letter' => 'I am interested in joining your team and believe my skills would be a great fit.',
                    'cv_path' => $user->profile?->cv_path ?? 'cvs/default-cv.pdf',
                    'created_at' => Carbon::now()->subDays(rand(5, 30)),
                ]);
            }
        }

        $this->command->info('🎉 Second client setup completed!');
        $this->command->line('');
        $this->command->info("📋 Summary:");
        $this->command->line("   Client: {$client->name}");
        $this->command->line("   HR Login: hr@techvision.com / password");
        $this->command->line("   Jobs: " . count($jobs));
        $this->command->line("   Active Employees: 2");
        $this->command->line("   Former Employees: 1 (resigned)");
        $totalApps = Application::where('job_id', $jobs[0]->id)
            ->orWhere('job_id', $jobs[1]->id)
            ->orWhere('job_id', $jobs[2]->id)
            ->count();
        $this->command->line("   Applications: " . $totalApps);
    }
}
