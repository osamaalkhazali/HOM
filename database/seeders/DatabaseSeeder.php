<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->command->info('🌱 Starting database seeding...');

        // Run seeders in proper order to maintain foreign key relationships
        $this->call([
            AdminSeeder::class,           // Independent - no dependencies
            CategorySeeder::class,        // Independent - no dependencies
            SubCategorySeeder::class,     // Depends on Category
            UserSeeder::class,           // Independent - no dependencies
            ProfileSeeder::class,        // Depends on User
            JobSeeder::class,            // Depends on SubCategory and User
            ApplicationSeeder::class,    // Depends on Job and User
        ]);

        $this->command->info('🎉 Database seeding completed successfully!');
        $this->command->line('');
        $this->command->info('📊 Summary:');
        $this->command->line('   - Admins: Created sample admin accounts');
        $this->command->line('   - Categories: Created job categories');
        $this->command->line('   - SubCategories: Created subcategories for each category');
        $this->command->line('   - Users: Created test users + factory users');
        $this->command->line('   - Profiles: Created profiles with education/work data');
        $this->command->line('   - Jobs: Created realistic job postings');
        $this->command->line('   - Applications: Created sample applications');
        $this->command->line('');
        $this->command->info('🔐 Login credentials:');
        $this->command->line('   Admin: admin@jobportal.com / password123');
        $this->command->line('   Users: Various test accounts with password "password"');
    }
}
