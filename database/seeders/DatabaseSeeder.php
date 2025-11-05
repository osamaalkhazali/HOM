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
            CategorySeeder::class,        // Independent - no dependencies
            SubCategorySeeder::class,     // Depends on Category
            ClientSeeder::class,          // Clients available before admins
            AdminSeeder::class,           // Depends on Client for client_hr role
            UserSeeder::class,           // Independent - no dependencies
            ProfileSeeder::class,        // Depends on User
            JobSeeder::class,            // Depends on SubCategory and User
            ApplicationSeeder::class,    // Depends on Job and User
            SettingSeeder::class,        // Independent - no dependencies
            EmployeeSeeder::class,       // Depends on User and Job
            SecondClientSeeder::class,   // Complete second client setup
        ]);

        $this->command->info('🎉 Database seeding completed successfully!');
        $this->command->line('');
        $this->command->info('📊 Summary:');
        $this->command->line('   - Admins: Created sample admin accounts');
        $this->command->line('   - Categories: Created 6 job categories');
        $this->command->line('   - SubCategories: Created subcategories for each category');
        $this->command->line('   - Users: Created 8 test users (4 specific + 4 factory)');
        $this->command->line('   - Profiles: Created profiles for ~50% of users');
        $this->command->line('   - Jobs: Created 1-2 jobs per subcategory (linked to seeded client)');
        $this->command->line('   - Applications: Created 1-3 applications per job');
        $this->command->line('   - Clients: Added 2 showcase clients (Bromine Jo + TechVision Solutions)');
        $this->command->line('   - Employees: Multiple employment records with various statuses');
        $this->command->line('');
        $this->command->info('🔐 Login credentials:');
        $this->command->line('   Super Admin: admin@jobportal.com / password123');
        $this->command->line('   Client HR (Bromine Jo): hr@bromineje.com / password');
        $this->command->line('   Client HR (TechVision): hr@techvision.com / password');
        $this->command->line('   Users: Various test accounts with password "password"');
    }
}
