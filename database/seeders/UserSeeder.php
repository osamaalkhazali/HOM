<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create specific test users
        $users = [
            [
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'phone' => '+1234567890',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'jane@example.com',
                'phone' => '+1234567891',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Michael Johnson',
                'email' => 'michael@example.com',
                'phone' => '+1234567892',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Sarah Wilson',
                'email' => 'sarah@example.com',
                'phone' => '+1234567893',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ],
            [
                'name' => 'David Brown',
                'email' => 'david@example.com',
                'phone' => '+1234567894',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Emily Davis',
                'email' => 'emily@example.com',
                'phone' => '+1234567895',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ],
            [
                'name' => 'James Miller',
                'email' => 'james@example.com',
                'phone' => '+1234567896',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Lisa Anderson',
                'email' => 'lisa@example.com',
                'phone' => '+1234567897',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Robert Taylor',
                'email' => 'robert@example.com',
                'phone' => '+1234567898',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Jennifer White',
                'email' => 'jennifer@example.com',
                'phone' => '+1234567899',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ],
        ];

        foreach ($users as $userData) {
            User::create($userData);
        }

        // Create additional random users using factory
        User::factory(20)->create();

        $this->command->info('Created ' . count($users) . ' test users + 20 factory users successfully!');
        $this->command->info('All users have password: "password"');
    }
}
