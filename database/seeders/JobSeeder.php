<?php

namespace Database\Seeders;

use App\Models\Job;
use App\Models\User;
use App\Models\SubCategory;
use Illuminate\Database\Seeder;

class JobSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $companies = [
      ['en' => 'Google', 'ar' => 'جوجل'],
      ['en' => 'Microsoft', 'ar' => 'مايكروسوفت'],
      ['en' => 'Apple', 'ar' => 'أبل'],
      ['en' => 'Amazon', 'ar' => 'أمازون'],
      ['en' => 'Meta', 'ar' => 'ميتا'],
      ['en' => 'Netflix', 'ar' => 'نتفلكس'],
      ['en' => 'Tesla', 'ar' => 'تسلا'],
      ['en' => 'Spotify', 'ar' => 'سبوتيفاي'],
      ['en' => 'Uber', 'ar' => 'أوبر'],
      ['en' => 'Airbnb', 'ar' => 'إير بي إن بي'],
      ['en' => 'Stripe', 'ar' => 'سترايب'],
      ['en' => 'Shopify', 'ar' => 'شوبفاي'],
      ['en' => 'Salesforce', 'ar' => 'سيلزفورس'],
      ['en' => 'Adobe', 'ar' => 'أدوبي'],
      ['en' => 'Oracle', 'ar' => 'أوراكل'],
      ['en' => 'Intel', 'ar' => 'إنتل'],
      ['en' => 'NVIDIA', 'ar' => 'إنفيديا'],
      ['en' => 'IBM', 'ar' => 'آي بي إم'],
      ['en' => 'Cisco', 'ar' => 'سيسكو'],
      ['en' => 'Twitter', 'ar' => 'تويتر'],
      ['en' => 'LinkedIn', 'ar' => 'لينكدإن'],
      ['en' => 'GitHub', 'ar' => 'جيت هب'],
      ['en' => 'Slack', 'ar' => 'سلاك'],
      ['en' => 'Zoom', 'ar' => 'زووم'],
      ['en' => 'Dropbox', 'ar' => 'دروب بوكس'],
      ['en' => 'Square', 'ar' => 'سكوير'],
      ['en' => 'PayPal', 'ar' => 'باي بال'],
      ['en' => 'eBay', 'ar' => 'إي باي'],
      ['en' => 'Etsy', 'ar' => 'إتسي'],
      ['en' => 'Pinterest', 'ar' => 'بينتريست'],
      ['en' => 'Snapchat', 'ar' => 'سناب شات'],
      ['en' => 'TikTok', 'ar' => 'تيك توك'],
    ];

    $locations = [
      ['en' => 'San Francisco, CA', 'ar' => 'سان فرانسيسكو، كاليفورنيا'],
      ['en' => 'New York, NY', 'ar' => 'نيويورك، نيويورك'],
      ['en' => 'Seattle, WA', 'ar' => 'سياتل، واشنطن'],
      ['en' => 'Austin, TX', 'ar' => 'أوستن، تكساس'],
      ['en' => 'Chicago, IL', 'ar' => 'شيكاغو، إلينوي'],
      ['en' => 'Boston, MA', 'ar' => 'بوسطن، ماساتشوستس'],
      ['en' => 'Los Angeles, CA', 'ar' => 'لوس أنجلوس، كاليفورنيا'],
      ['en' => 'Denver, CO', 'ar' => 'دنفر، كولورادو'],
      ['en' => 'Atlanta, GA', 'ar' => 'أتلانتا، جورجيا'],
      ['en' => 'Miami, FL', 'ar' => 'ميامي، فلوريدا'],
      ['en' => 'Remote', 'ar' => 'عن بُعد'],
      ['en' => 'Hybrid - New York', 'ar' => 'هجين - نيويورك'],
      ['en' => 'Hybrid - San Francisco', 'ar' => 'هجين - سان فرانسيسكو'],
      ['en' => 'Toronto, ON', 'ar' => 'تورنتو، أونتاريو'],
      ['en' => 'Vancouver, BC', 'ar' => 'فانكوفر، بريتش كولومبيا'],
      ['en' => 'London, UK', 'ar' => 'لندن، المملكة المتحدة'],
      ['en' => 'Berlin, Germany', 'ar' => 'برلين، ألمانيا'],
      ['en' => 'Amsterdam, Netherlands', 'ar' => 'أمستردام، هولندا'],
    ];

    $levels = ['entry', 'mid', 'senior', 'executive'];

    $jobTitles = [
      'Software Development' => [
        ['en' => 'Software Engineer', 'ar' => 'مهندس برمجيات'],
        ['en' => 'Senior Software Engineer', 'ar' => 'مهندس برمجيات أول'],
        ['en' => 'Staff Software Engineer', 'ar' => 'مهندس برمجيات رئيسي'],
        ['en' => 'Principal Software Engineer', 'ar' => 'مهندس برمجيات متميز'],
        ['en' => 'Lead Software Engineer', 'ar' => 'قائد هندسة البرمجيات'],
      ],
      'Web Development' => [
        ['en' => 'Frontend Developer', 'ar' => 'مطور واجهات أمامية'],
        ['en' => 'Backend Developer', 'ar' => 'مطور واجهات خلفية'],
        ['en' => 'Full Stack Developer', 'ar' => 'مطور متكامل'],
        ['en' => 'React Developer', 'ar' => 'مطور React'],
        ['en' => 'Vue.js Developer', 'ar' => 'مطور Vue.js'],
        ['en' => 'Angular Developer', 'ar' => 'مطور Angular'],
      ],
      'Mobile App Development' => [
        ['en' => 'iOS Developer', 'ar' => 'مطور iOS'],
        ['en' => 'Android Developer', 'ar' => 'مطور أندرويد'],
        ['en' => 'React Native Developer', 'ar' => 'مطور React Native'],
        ['en' => 'Flutter Developer', 'ar' => 'مطور Flutter'],
        ['en' => 'Mobile App Developer', 'ar' => 'مطور تطبيقات هاتف'],
      ],
      'Data Science & Analytics' => [
        ['en' => 'Data Scientist', 'ar' => 'عالم بيانات'],
        ['en' => 'Data Analyst', 'ar' => 'محلل بيانات'],
        ['en' => 'Machine Learning Engineer', 'ar' => 'مهندس تعلم آلي'],
        ['en' => 'Data Engineer', 'ar' => 'مهندس بيانات'],
        ['en' => 'Business Intelligence Analyst', 'ar' => 'محلل ذكاء أعمال'],
      ],
      'DevOps' => [
        ['en' => 'DevOps Engineer', 'ar' => 'مهندس DevOps'],
        ['en' => 'Site Reliability Engineer', 'ar' => 'مهندس موثوقية الموقع'],
        ['en' => 'Cloud Engineer', 'ar' => 'مهندس سحابة'],
        ['en' => 'Infrastructure Engineer', 'ar' => 'مهندس بنية تحتية'],
        ['en' => 'Platform Engineer', 'ar' => 'مهندس منصات'],
      ],
      'UI/UX Design' => [
        ['en' => 'UX Designer', 'ar' => 'مصمم تجربة مستخدم'],
        ['en' => 'UI Designer', 'ar' => 'مصمم واجهات مستخدم'],
        ['en' => 'Product Designer', 'ar' => 'مصمم منتجات'],
        ['en' => 'UX Researcher', 'ar' => 'باحث تجربة مستخدم'],
        ['en' => 'Design Lead', 'ar' => 'قائد التصميم'],
      ],
    ];

    $descriptions = [
      [
        'en' => 'Join our dynamic team and help build cutting-edge software solutions that impact millions of users worldwide. We are looking for passionate developers who thrive in collaborative environments.',
        'ar' => 'انضم إلى فريقنا الديناميكي وساعدنا في بناء حلول برمجية متطورة تؤثر على ملايين المستخدمين حول العالم. نبحث عن مطورين شغوفين يزدهرون في بيئات العمل التعاونية.',
      ],
      [
        'en' => 'We are seeking a talented professional to contribute to our innovative projects. This role offers excellent growth opportunities and the chance to work with the latest technologies.',
        'ar' => 'نبحث عن محترف موهوب للمساهمة في مشاريعنا المبتكرة. يقدم هذا الدور فرص نمو ممتازة وفرصة للعمل مع أحدث التقنيات.',
      ],
      [
        'en' => 'Be part of a team that values creativity, innovation, and technical excellence. We offer competitive compensation and a supportive work environment.',
        'ar' => 'كن جزءاً من فريق يقدّر الإبداع والابتكار والتميز التقني. نقدم تعويضات تنافسية وبيئة عمل داعمة.',
      ],
      [
        'en' => 'We are looking for someone who is passionate about technology and eager to make a difference. Join us in building the future of our industry.',
        'ar' => 'نبحث عن شخص شغوف بالتقنية ويتطلع لصناعة فارق حقيقي. انضم إلينا لبناء مستقبل صناعتنا.',
      ],
      [
        'en' => 'This is an exciting opportunity to work on challenging projects with a world-class team. We value diversity, inclusion, and continuous learning.',
        'ar' => 'هذه فرصة مثيرة للعمل على مشاريع تحدٍّ مع فريق عالمي المستوى. نحن نقدر التنوع والشمول والتعلم المستمر.',
      ],
    ];

    // Get all subcategories and users
    $subCategories = SubCategory::all();
    $users = User::all();

    if ($subCategories->isEmpty() || $users->isEmpty()) {
      $this->command->error('Please run Category, SubCategory, and User seeders first!');
      return;
    }

    $jobCount = 0;

    foreach ($subCategories as $subCategory) {
      // Create 1-2 jobs per subcategory
      $jobsToCreate = fake()->numberBetween(1, 2);

      for ($i = 0; $i < $jobsToCreate; $i++) {
        $level = $levels[array_rand($levels)];
        $company = $companies[array_rand($companies)];
        $location = $locations[array_rand($locations)];

        // Get appropriate job titles for this subcategory
        $titleKey = $subCategory->name;
        $availableTitles = $jobTitles[$titleKey] ?? [
          ['en' => 'Specialist', 'ar' => 'أخصائي'],
        ];
        $title = $availableTitles[array_rand($availableTitles)];

        // Salary based on level
        $salaryRanges = [
          'entry' => [40000, 60000],
          'mid' => [80000, 120000],
          'senior' => [120000, 180000],
          'executive' => [180000, 300000],
        ];

        $salaryRange = $salaryRanges[$level];
        $salary = fake()->numberBetween($salaryRange[0], $salaryRange[1]);

        $description = $descriptions[array_rand($descriptions)];

        Job::create([
          'title' => $title['en'],
          'title_ar' => $title['ar'],
          'description' => $description['en'],
          'description_ar' => $description['ar'],
          'sub_category_id' => $subCategory->id,
          'company' => $company['en'],
          'company_ar' => $company['ar'],
          'salary' => $salary,
          'location' => $location['en'],
          'location_ar' => $location['ar'],
          'level' => $level,
          'deadline' => fake()->dateTimeBetween('now', '+3 months'),
          'posted_by' => $users->random()->id,
          'is_active' => fake()->boolean(85), // 85% chance of being active
          'created_at' => fake()->dateTimeBetween('-2 months', 'now'),
          'updated_at' => now(),
        ]);

        $jobCount++;
      }
    }

    $this->command->info("Created {$jobCount} job postings successfully!");
  }
}
