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
        // Disable all event listeners to prevent sending emails
        \Illuminate\Support\Facades\Event::fake();

        $admins = [
            [
                'name' => 'HOM HR Department',
                'email' => 'hr@hom-intl.com',
                'password' => Hash::make('password'),
                'role' => 'super',
                'client_id' => null,
                'is_active' => true,
                'email_verified_at' => now(),
                'last_login_at' => now()->subDays(1),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Normal Admin',
                'email' => 'admin@hom-intl.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'client_id' => null,
                'is_active' => true,
                'email_verified_at' => now(),
                'last_login_at' => now()->subDays(2),
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

        // Create client HR for Bromine Jo
        $client = \App\Models\Client::where('slug', 'bromine-jo')->first();
        if ($client) {
            Admin::updateOrCreate(
                ['email' => 'hr@bromineje.com'],
                [
                    'name' => 'Bromine Jo HR',
                    'email' => 'hr@bromineje.com',
                    'password' => Hash::make('password'),
                    'role' => 'client_hr',
                    'client_id' => $client->id,
                    'is_active' => true,
                    'email_verified_at' => now(),
                    'last_login_at' => now()->subDays(3),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }

        $this->command->info('Created super admin: hr@hom-intl.com');
        $this->command->info('Created normal admin: admin@hom-intl.com');
        if ($client) {
            $this->command->info('Created client HR: hr@bromineje.com (linked to Bromine Jo)');
        }
        $this->command->info('Admin seeder completed successfully!');
        $this->command->info('All admins have password: "password"');
        $this->command->info('No emails were sent during seeding.');
    }
}
