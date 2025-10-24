<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
  public function index()
  {
    $settings = [
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
      'hom_profile_pdf_path' => Setting::where('key', 'hom_profile_pdf_path')->value('value'),
    ];

    return view('admin.settings.index', compact('settings'));
  }

  public function update(Request $request)
  {
    $request->validate([
      'company_name_en' => ['required', 'string', 'max:255'],
      'company_name_ar' => ['required', 'string', 'max:255'],
      'company_tagline_en' => ['required', 'string', 'max:255'],
      'company_tagline_ar' => ['required', 'string', 'max:255'],
      'office_address_en' => ['required', 'string'],
      'office_address_ar' => ['required', 'string'],
      'po_box' => ['required', 'string', 'max:255'],
      'phone' => ['required', 'string', 'max:255'],
      'fax' => ['nullable', 'string', 'max:255'],
      'email' => ['required', 'email', 'max:255'],
      'website' => ['required', 'string', 'max:255'],
      'profile_pdf' => ['nullable', 'file', 'mimes:pdf', 'max:10240'],
    ]);

    $settingsToUpdate = [
      'company_name_en',
      'company_name_ar',
      'company_tagline_en',
      'company_tagline_ar',
      'office_address_en',
      'office_address_ar',
      'po_box',
      'phone',
      'fax',
      'email',
      'website',
    ];

    foreach ($settingsToUpdate as $key) {
      Setting::updateOrCreate(
        ['key' => $key],
        ['value' => $request->input($key)]
      );
    }

    // Handle PDF upload
    if ($request->hasFile('profile_pdf')) {
      $oldPath = Setting::where('key', 'hom_profile_pdf_path')->value('value');
      if ($oldPath && Storage::disk('public')->exists($oldPath)) {
        Storage::disk('public')->delete($oldPath);
      }

      $stored = $request->file('profile_pdf')->store('hom-profile', 'public');
      Setting::updateOrCreate(
        ['key' => 'hom_profile_pdf_path'],
        ['value' => $stored]
      );
    }

    return redirect()->route('admin.settings.index')->with('success', __('site.flash.settings_saved'));
  }
}
