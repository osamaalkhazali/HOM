<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $name = 'Bromine Jo';
        $slug = Str::slug($name);

        Client::withTrashed()->updateOrCreate(
            ['slug' => $slug],
            [
                'name' => $name,
                'description' => 'Trusted partner highlighted in our client portfolio.',
                'website_url' => null,
                'is_active' => true,
            ]
        );
    }
}
