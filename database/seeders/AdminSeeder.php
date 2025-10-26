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
                'is_super' => true,
                'email_verified_at' => now(),
                'last_login_at' => now()->subDays(1),
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

        $this->command->info('Created super admin: hr@hom-intl.com');
        $this->command->info('Admin seeder completed successfully!');
        $this->command->info('All admins have password: "password"');
        $this->command->info('No emails were sent during seeding.');
    }
}
