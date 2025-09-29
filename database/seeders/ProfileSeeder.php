<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Profile;
use Illuminate\Database\Seeder;

class ProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $educationOptions = [
            'Harvard University',
            'Stanford University',
            'MIT',
            'University of California Berkeley',
            'Yale University',
            'Princeton University',
            'Columbia University',
            'University of Oxford',
            'Cambridge University',
            'University of Toronto',
            'University of British Columbia',
            'New York University',
            'University of Texas',
            'University of Michigan',
            'Georgia Institute of Technology',
            'Carnegie Mellon University'
        ];

        $positions = [
            'Software Engineer',
            'Product Manager',
            'Data Scientist',
            'Marketing Manager',
            'Sales Director',
            'UX Designer',
            'DevOps Engineer',
            'Business Analyst',
            'Project Manager',
            'Full Stack Developer',
            'Frontend Developer',
            'Backend Developer',
            'Mobile App Developer',
            'Quality Assurance Engineer',
            'System Administrator',
            'Database Administrator',
            'Cybersecurity Specialist',
            'Machine Learning Engineer'
        ];

        $skillSets = [
            'PHP, Laravel, MySQL, JavaScript, HTML, CSS',
            'Python, Django, PostgreSQL, React, Docker',
            'Java, Spring Boot, MongoDB, Angular, Kubernetes',
            'JavaScript, Node.js, Express, Vue.js, Redis',
            'C#, .NET Core, SQL Server, Azure, TypeScript',
            'React Native, iOS, Android, Firebase, Swift',
            'Data Analysis, Python, R, Tableau, SQL',
            'Digital Marketing, SEO, Google Analytics, Social Media',
            'Project Management, Agile, Scrum, Jira, Confluence',
            'UI/UX Design, Figma, Adobe Creative Suite, Prototyping'
        ];

        $locations = [
            'New York, NY',
            'San Francisco, CA',
            'Seattle, WA',
            'Austin, TX',
            'Chicago, IL',
            'Boston, MA',
            'Los Angeles, CA',
            'Denver, CO',
            'Atlanta, GA',
            'Miami, FL',
            'Toronto, ON',
            'Vancouver, BC',
            'London, UK',
            'Berlin, Germany',
            'Amsterdam, Netherlands',
            'Sydney, Australia',
            'Singapore',
            'Tokyo, Japan'
        ];

        $headlines = [
            'Passionate Software Engineer with 5+ years experience',
            'Product Manager driving innovation in tech startups',
            'Data Scientist turning data into actionable insights',
            'Creative UX Designer crafting user-centered experiences',
            'Full-stack developer building scalable web applications',
            'Marketing strategist with proven track record',
            'DevOps engineer optimizing deployment pipelines',
            'Mobile app developer creating seamless user experiences',
            'Cybersecurity expert protecting digital assets',
            'AI/ML engineer developing intelligent solutions'
        ];

        $aboutTexts = [
            'Experienced software engineer with a passion for creating efficient, scalable solutions. Proven track record in full-stack development and team leadership.',
            'Results-driven product manager with expertise in agile methodologies and cross-functional team coordination. Focused on delivering user-centric products.',
            'Data scientist with strong analytical skills and experience in machine learning. Passionate about extracting insights from complex datasets.',
            'Creative UX designer committed to creating intuitive and engaging user experiences. Experienced in user research and design thinking methodologies.',
            'Full-stack developer with expertise in modern web technologies. Dedicated to writing clean, maintainable code and following best practices.',
        ];

        // Get all users
        $users = User::all();

        // Create profiles for roughly 50% of users
        $profileCount = 0;
        $targetProfiles = (int) ($users->count() * 0.5);

        foreach ($users->take($targetProfiles) as $user) {
            Profile::create([
                'user_id' => $user->id,
                'headline' => $headlines[array_rand($headlines)],
                'location' => $locations[array_rand($locations)],
                'website' => fake()->boolean(30) ? 'https://portfolio-' . strtolower(str_replace(' ', '', $user->name)) . '.com' : null,
                'linkedin_url' => fake()->boolean(80) ? 'https://linkedin.com/in/' . strtolower(str_replace(' ', '-', $user->name)) : null,
                'education' => $educationOptions[array_rand($educationOptions)],
                'current_position' => $positions[array_rand($positions)],
                'experience_years' => fake()->numberBetween(1, 15),
                'skills' => $skillSets[array_rand($skillSets)],
                'about' => $aboutTexts[array_rand($aboutTexts)],
                'cv_path' => fake()->boolean(40) ? 'cvs/' . $user->id . '_cv.pdf' : null,
                'created_at' => fake()->dateTimeBetween('-1 year', 'now'),
                'updated_at' => now(),
            ]);

            $profileCount++;
        }

        $this->command->info("Created {$profileCount} user profiles successfully!");
    }
}
