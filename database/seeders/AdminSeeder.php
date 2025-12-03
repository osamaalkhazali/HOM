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

        Admin::updateOrCreate(
            ['email' => 'hr@hom-intl.com'],
            [
                'name' => 'HOM HR Department',
                'email' => 'hr@hom-intl.com',
                'password' => Hash::make('HomAdmin!1'),
                'role' => 'super',
                'client_id' => null,
                'is_active' => true,
                'email_verified_at' => now(),
                'last_login_at' => now()->subDays(1),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        $this->command->info('Created super admin: hr@hom-intl.com (password: HomAdmin!1)');
        $this->command->info('No additional admin or client HR accounts were seeded.');
        $this->command->info('Admin seeder completed successfully without sending emails.');
    }
}
