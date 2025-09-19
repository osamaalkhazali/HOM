<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Database\Seeder;

class SubCategorySeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $subCategories = [
      'Technology & IT' => [
        'Software Development',
        'Web Development',
        'Mobile App Development',
        'Data Science & Analytics',
        'Cybersecurity',
        'Cloud Computing',
        'DevOps',
        'QA & Testing',
        'Database Administration',
        'UI/UX Design',
      ],
      'Healthcare & Medical' => [
        'Nursing',
        'Medical Doctors',
        'Pharmacy',
        'Medical Research',
        'Healthcare Administration',
        'Physical Therapy',
        'Medical Technology',
        'Mental Health',
      ],
      'Finance & Banking' => [
        'Investment Banking',
        'Financial Analysis',
        'Accounting',
        'Risk Management',
        'Insurance',
        'Financial Planning',
        'Credit Analysis',
        'Audit',
      ],
      'Marketing & Sales' => [
        'Digital Marketing',
        'Sales Representative',
        'Content Marketing',
        'SEO/SEM',
        'Social Media Marketing',
        'Brand Management',
        'Market Research',
        'Business Development',
      ],
      'Education & Training' => [
        'Teaching',
        'Corporate Training',
        'Curriculum Development',
        'Educational Technology',
        'Academic Research',
        'Student Services',
      ],
      'Engineering' => [
        'Software Engineering',
        'Mechanical Engineering',
        'Civil Engineering',
        'Electrical Engineering',
        'Chemical Engineering',
        'Industrial Engineering',
      ],
    ];

    foreach ($subCategories as $categoryName => $subs) {
      $category = Category::where('name', $categoryName)->first();

      if ($category) {
        foreach ($subs as $subName) {
          SubCategory::updateOrCreate(
            [
              'name' => $subName,
              'category_id' => $category->id
            ],
            [
              'name' => $subName,
              'category_id' => $category->id,
              'created_at' => now(),
              'updated_at' => now(),
            ]
          );
        }
      }
    }

    $this->command->info('SubCategory seeder completed successfully!');
  }
}
