<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            ['key' => 'company_name_en', 'value' => 'House of Management'],
            ['key' => 'company_name_ar', 'value' => 'بيت الإدارة'],
            ['key' => 'company_tagline_en', 'value' => 'for Studies and Consultations'],
            ['key' => 'company_tagline_ar', 'value' => 'للدراسات والاستشارات'],
            ['key' => 'office_address_en', 'value' => 'Shareef A. Hameed Sharaf Street, Building No. 99, 1st floor, Shemisani, Amman - Jordan'],
            ['key' => 'office_address_ar', 'value' => 'شارع شريف عبد الحميد شرف، مبنى رقم 99، الطابق الأول، الشميساني، عمان - الأردن'],
            ['key' => 'po_box', 'value' => 'P.O.Box: 17651, Amman 11195, Jordan'],
            ['key' => 'phone', 'value' => '+962 6 566 2289'],
            ['key' => 'fax', 'value' => '+962 6 566 7289'],
            ['key' => 'email', 'value' => 'info@hom-intl.com'],
            ['key' => 'website', 'value' => 'www.hom-intl.com'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                ['value' => $setting['value']]
            );
        }
    }
}
