<?php

namespace Database\Seeders;

use App\Models\Job;
use App\Models\User;
use App\Models\SubCategory;
use Illuminate\Database\Seeder;

class JobSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $companies = [
      'Google',
      'Microsoft',
      'Apple',
      'Amazon',
      'Meta',
      'Netflix',
      'Tesla',
      'Spotify',
      'Uber',
      'Airbnb',
      'Stripe',
      'Shopify',
      'Salesforce',
      'Adobe',
      'Oracle',
      'Intel',
      'NVIDIA',
      'IBM',
      'Cisco',
      'Twitter',
      'LinkedIn',
      'GitHub',
      'Slack',
      'Zoom',
      'Dropbox',
      'Square',
      'PayPal',
      'eBay',
      'Etsy',
      'Pinterest',
      'Snapchat',
      'TikTok'
    ];

    $locations = [
      'San Francisco, CA',
      'New York, NY',
      'Seattle, WA',
      'Austin, TX',
      'Chicago, IL',
      'Boston, MA',
      'Los Angeles, CA',
      'Denver, CO',
      'Atlanta, GA',
      'Miami, FL',
      'Remote',
      'Hybrid - New York',
      'Hybrid - San Francisco',
      'Toronto, ON',
      'Vancouver, BC',
      'London, UK',
      'Berlin, Germany',
      'Amsterdam, Netherlands'
    ];

    $levels = ['entry', 'mid', 'senior', 'executive'];

    $jobTitles = [
      'Software Engineer' => [
        'Software Engineer',
        'Senior Software Engineer',
        'Staff Software Engineer',
        'Principal Software Engineer',
        'Lead Software Engineer'
      ],
      'Web Development' => [
        'Frontend Developer',
        'Backend Developer',
        'Full Stack Developer',
        'React Developer',
        'Vue.js Developer',
        'Angular Developer'
      ],
      'Mobile App Development' => [
        'iOS Developer',
        'Android Developer',
        'React Native Developer',
        'Flutter Developer',
        'Mobile App Developer'
      ],
      'Data Science & Analytics' => [
        'Data Scientist',
        'Data Analyst',
        'Machine Learning Engineer',
        'Data Engineer',
        'Business Intelligence Analyst'
      ],
      'DevOps' => [
        'DevOps Engineer',
        'Site Reliability Engineer',
        'Cloud Engineer',
        'Infrastructure Engineer',
        'Platform Engineer'
      ],
      'Product Manager' => [
        'Product Manager',
        'Senior Product Manager',
        'Principal Product Manager',
        'Associate Product Manager',
        'Technical Product Manager'
      ],
      'UI/UX Design' => [
        'UX Designer',
        'UI Designer',
        'Product Designer',
        'UX Researcher',
        'Design Lead'
      ]
    ];

    $descriptions = [
      'Join our dynamic team and help build cutting-edge software solutions that impact millions of users worldwide. We are looking for passionate developers who thrive in collaborative environments.',
      'We are seeking a talented professional to contribute to our innovative projects. This role offers excellent growth opportunities and the chance to work with the latest technologies.',
      'Be part of a team that values creativity, innovation, and technical excellence. We offer competitive compensation and a supportive work environment.',
      'We are looking for someone who is passionate about technology and eager to make a difference. Join us in building the future of our industry.',
      'This is an exciting opportunity to work on challenging projects with a world-class team. We value diversity, inclusion, and continuous learning.',
    ];

    // Get all subcategories and users
    $subCategories = SubCategory::all();
    $users = User::all();

    if ($subCategories->isEmpty() || $users->isEmpty()) {
      $this->command->error('Please run Category, SubCategory, and User seeders first!');
      return;
    }

    $jobCount = 0;

    foreach ($subCategories as $subCategory) {
      // Create 2-5 jobs per subcategory
      $jobsToCreate = fake()->numberBetween(2, 5);

      for ($i = 0; $i < $jobsToCreate; $i++) {
        $level = $levels[array_rand($levels)];
        $company = $companies[array_rand($companies)];
        $location = $locations[array_rand($locations)];

        // Get appropriate job titles for this subcategory
        $titleKey = $subCategory->name;
        $availableTitles = $jobTitles[$titleKey] ?? ['Software Engineer', 'Developer', 'Specialist'];
        $title = $availableTitles[array_rand($availableTitles)];

        // Salary based on level
        $salaryRanges = [
          'entry' => [40000, 60000],
          'mid' => [80000, 120000],
          'senior' => [120000, 180000],
          'executive' => [180000, 300000],
        ];

        $salaryRange = $salaryRanges[$level];
        $salary = fake()->numberBetween($salaryRange[0], $salaryRange[1]);

        Job::create([
          'title' => $title,
          'description' => $descriptions[array_rand($descriptions)],
          'sub_category_id' => $subCategory->id,
          'company' => $company,
          'salary' => $salary,
          'location' => $location,
          'level' => $level,
          'deadline' => fake()->dateTimeBetween('now', '+3 months'),
          'posted_by' => $users->random()->id,
          'is_active' => fake()->boolean(85), // 85% chance of being active
          'created_at' => fake()->dateTimeBetween('-2 months', 'now'),
          'updated_at' => now(),
        ]);

        $jobCount++;
      }
    }

    $this->command->info("Created {$jobCount} job postings successfully!");
  }
}
