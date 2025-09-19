<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admins = [
            [
                'name' => 'Super Admin',
                'email' => 'admin@jobportal.com',
                'password' => Hash::make('password123'),
                'is_super' => true,
                'email_verified_at' => now(),
                'last_login_at' => now()->subDays(1),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'John Manager',
                'email' => 'john.manager@jobportal.com',
                'password' => Hash::make('manager123'),
                'is_super' => false,
                'email_verified_at' => now(),
                'last_login_at' => now()->subDays(3),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Sarah Wilson',
                'email' => 'sarah.wilson@jobportal.com',
                'password' => Hash::make('sarah123'),
                'is_super' => false,
                'email_verified_at' => now(),
                'last_login_at' => now()->subWeek(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Michael Brown',
                'email' => 'michael.brown@jobportal.com',
                'password' => Hash::make('michael123'),
                'is_super' => false,
                'email_verified_at' => null, // Inactive admin
                'last_login_at' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($admins as $admin) {
            Admin::updateOrCreate(
                ['email' => $admin['email']],
                $admin
            );
        }

        $this->command->info('Admin seeder completed successfully!');
    }
}
