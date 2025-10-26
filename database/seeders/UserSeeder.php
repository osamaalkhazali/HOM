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
        // Disable all event listeners to prevent sending emails
        \Illuminate\Support\Facades\Event::fake();

        // Create specific required user
        $specificUser = User::create([
            'name' => 'Osama Alkhazali',
            'email' => 'o.a.alkhazali.b@gmail.com',
            'phone' => '+962787276821',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        // Create other test users
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
        ];

        foreach ($users as $userData) {
            User::create($userData);
        }

        // Create additional random users using factory
        User::factory(4)->create();

        $this->command->info('Created specific user: o.a.alkhazali.b@gmail.com');
        $this->command->info('Created ' . count($users) . ' test users + 4 factory users successfully!');
        $this->command->info('All users have password: "password"');
        $this->command->info('No emails were sent during seeding.');
    }
}
