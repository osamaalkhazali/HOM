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
        ['en' => 'Software Development', 'ar' => 'تطوير البرمجيات'],
        ['en' => 'Web Development', 'ar' => 'تطوير الويب'],
        ['en' => 'Mobile App Development', 'ar' => 'تطوير تطبيقات الهاتف'],
        ['en' => 'Data Science & Analytics', 'ar' => 'علوم البيانات والتحليلات'],
        ['en' => 'Cybersecurity', 'ar' => 'الأمن السيبراني'],
        ['en' => 'Cloud Computing', 'ar' => 'الحوسبة السحابية'],
        ['en' => 'DevOps', 'ar' => 'دعم التطوير والعمليات'],
        ['en' => 'QA & Testing', 'ar' => 'الجودة والاختبار'],
        ['en' => 'Database Administration', 'ar' => 'إدارة قواعد البيانات'],
        ['en' => 'UI/UX Design', 'ar' => 'تصميم واجهات وتجربة المستخدم'],
      ],
      'Healthcare & Medical' => [
        ['en' => 'Nursing', 'ar' => 'التمريض'],
        ['en' => 'Medical Doctors', 'ar' => 'الأطباء'],
        ['en' => 'Pharmacy', 'ar' => 'الصيدلة'],
        ['en' => 'Medical Research', 'ar' => 'البحوث الطبية'],
        ['en' => 'Healthcare Administration', 'ar' => 'إدارة الرعاية الصحية'],
        ['en' => 'Physical Therapy', 'ar' => 'العلاج الطبيعي'],
        ['en' => 'Medical Technology', 'ar' => 'التقنيات الطبية'],
        ['en' => 'Mental Health', 'ar' => 'الصحة النفسية'],
      ],
      'Finance & Banking' => [
        ['en' => 'Investment Banking', 'ar' => 'المصرفية الاستثمارية'],
        ['en' => 'Financial Analysis', 'ar' => 'التحليل المالي'],
        ['en' => 'Accounting', 'ar' => 'المحاسبة'],
        ['en' => 'Risk Management', 'ar' => 'إدارة المخاطر'],
        ['en' => 'Insurance', 'ar' => 'التأمين'],
        ['en' => 'Financial Planning', 'ar' => 'التخطيط المالي'],
        ['en' => 'Credit Analysis', 'ar' => 'تحليل الائتمان'],
        ['en' => 'Audit', 'ar' => 'التدقيق'],
      ],
      'Marketing & Sales' => [
        ['en' => 'Digital Marketing', 'ar' => 'التسويق الرقمي'],
        ['en' => 'Sales Representative', 'ar' => 'مندوب مبيعات'],
        ['en' => 'Content Marketing', 'ar' => 'تسويق المحتوى'],
        ['en' => 'SEO/SEM', 'ar' => 'تحسين محركات البحث والإعلانات'],
        ['en' => 'Social Media Marketing', 'ar' => 'التسويق عبر وسائل التواصل'],
        ['en' => 'Brand Management', 'ar' => 'إدارة العلامة التجارية'],
        ['en' => 'Market Research', 'ar' => 'أبحاث السوق'],
        ['en' => 'Business Development', 'ar' => 'تطوير الأعمال'],
      ],
      'Education & Training' => [
        ['en' => 'Teaching', 'ar' => 'التدريس'],
        ['en' => 'Corporate Training', 'ar' => 'التدريب المؤسسي'],
        ['en' => 'Curriculum Development', 'ar' => 'تطوير المناهج'],
        ['en' => 'Educational Technology', 'ar' => 'التقنيات التعليمية'],
        ['en' => 'Academic Research', 'ar' => 'البحث الأكاديمي'],
        ['en' => 'Student Services', 'ar' => 'خدمات الطلاب'],
      ],
      'Engineering' => [
        ['en' => 'Software Engineering', 'ar' => 'هندسة البرمجيات'],
        ['en' => 'Mechanical Engineering', 'ar' => 'الهندسة الميكانيكية'],
        ['en' => 'Civil Engineering', 'ar' => 'الهندسة المدنية'],
        ['en' => 'Electrical Engineering', 'ar' => 'الهندسة الكهربائية'],
        ['en' => 'Chemical Engineering', 'ar' => 'الهندسة الكيميائية'],
        ['en' => 'Industrial Engineering', 'ar' => 'الهندسة الصناعية'],
      ],
    ];

    foreach ($subCategories as $categoryName => $subs) {
      $category = Category::where('name', $categoryName)->first();

      if ($category) {
        foreach ($subs as $sub) {
          SubCategory::updateOrCreate(
            [
              'name' => $sub['en'],
              'category_id' => $category->id
            ],
            [
              'name' => $sub['en'],
              'name_ar' => $sub['ar'],
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
