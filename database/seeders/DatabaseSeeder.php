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

        // Run only the minimal seeders required for the current environment
        $this->call([
            ClientSeeder::class,   // Primary showcase client
            AdminSeeder::class,    // Single super admin account
            SettingSeeder::class,  // Company settings for landing pages
            // CategorySeeder::class,
            // SubCategorySeeder::class,
            // UserSeeder::class,
            // ProfileSeeder::class,
            // JobSeeder::class,
            // ApplicationSeeder::class,
            // EmployeeSeeder::class,
            // SecondClientSeeder::class,
        ]);

        $this->command->info('🎉 Database seeding completed successfully!');
        $this->command->line('');
        $this->command->info('📊 Summary:');
        $this->command->line('   - Admins: Created a single verified super admin (hr@hom-intl.com)');
        $this->command->line('   - Clients: Seeded Bromine Jo showcase client');
        $this->command->line('   - Settings: Populated core company settings');
        $this->command->line('');
        $this->command->info('🔐 Login credentials:');
        $this->command->line('   Super Admin: hr@hom-intl.com / HomAdmin!1');
    }
}
