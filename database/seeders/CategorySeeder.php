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
      ['en' => 'Technology & IT', 'ar' => 'التكنولوجيا وتقنية المعلومات'],
      ['en' => 'Healthcare & Medical', 'ar' => 'الرعاية الصحية والطب'],
      ['en' => 'Finance & Banking', 'ar' => 'المالية والمصارف'],
      ['en' => 'Marketing & Sales', 'ar' => 'التسويق والمبيعات'],
      ['en' => 'Education & Training', 'ar' => 'التعليم والتدريب'],
      ['en' => 'Engineering', 'ar' => 'الهندسة'],
    ];

    foreach ($categories as $category) {
      Category::updateOrCreate(
        ['name' => $category['en']],
        [
          'name' => $category['en'],
          'name_ar' => $category['ar'],
          'created_at' => now(),
          'updated_at' => now(),
        ]
      );
    }

    $this->command->info('Category seeder completed successfully!');
  }
}
