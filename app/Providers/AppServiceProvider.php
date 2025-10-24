<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use App\Models\Setting;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);

        // Use Bootstrap pagination views
        Paginator::useBootstrapFive();

        // Share settings with all views
        try {
            if (Schema::hasTable('settings')) {
                $companySettings = [
                    'company_name_en' => Setting::where('key', 'company_name_en')->value('value') ?? 'House of Management',
                    'company_name_ar' => Setting::where('key', 'company_name_ar')->value('value') ?? 'بيت الإدارة',
                    'company_tagline_en' => Setting::where('key', 'company_tagline_en')->value('value') ?? 'for Studies and Consultations',
                    'company_tagline_ar' => Setting::where('key', 'company_tagline_ar')->value('value') ?? 'للدراسات والاستشارات',
                    'office_address_en' => Setting::where('key', 'office_address_en')->value('value') ?? 'Shareef A. Hameed Sharaf Street, Building No. 99, 1st floor, Shemisani, Amman - Jordan',
                    'office_address_ar' => Setting::where('key', 'office_address_ar')->value('value') ?? 'شارع شريف عبد الحميد شرف، مبنى رقم 99، الطابق الأول، الشميساني، عمان - الأردن',
                    'po_box' => Setting::where('key', 'po_box')->value('value') ?? 'P.O.Box: 17651, Amman 11195, Jordan',
                    'phone' => Setting::where('key', 'phone')->value('value') ?? '+962 6 566 2289',
                    'fax' => Setting::where('key', 'fax')->value('value') ?? '+962 6 566 7289',
                    'email' => Setting::where('key', 'email')->value('value') ?? 'info@hom-intl.com',
                    'website' => Setting::where('key', 'website')->value('value') ?? 'www.hom-intl.com',
                ];

                View::share('companySettings', $companySettings);
            }
        } catch (\Exception $e) {
            // In case settings table doesn't exist yet
        }
    }
}

