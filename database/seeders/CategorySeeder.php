<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $categories = [
      'Technology & IT',
      'Healthcare & Medical',
      'Finance & Banking',
      'Marketing & Sales',
      'Education & Training',
      'Engineering',
    ];

    foreach ($categories as $categoryName) {
      Category::updateOrCreate(
        ['name' => $categoryName],
        [
          'name' => $categoryName,
          'created_at' => now(),
          'updated_at' => now(),
        ]
      );
    }

    $this->command->info('Category seeder completed successfully!');
  }
}
