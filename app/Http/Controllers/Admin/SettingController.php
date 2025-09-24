<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
  public function editHomProfile()
  {
    $path = Setting::where('key', 'hom_profile_pdf_path')->value('value');
    return view('admin.settings.hom-profile', compact('path'));
  }

  public function updateHomProfile(Request $request)
  {
    $request->validate([
      'profile_pdf' => ['nullable', 'file', 'mimes:pdf', 'max:10240'],
    ]);

    $path = Setting::firstOrCreate(['key' => 'hom_profile_pdf_path']);

    if ($request->hasFile('profile_pdf')) {
      $stored = $request->file('profile_pdf')->store('hom-profile', 'public');
      $path->value = $stored;
      $path->save();
    }

    return redirect()->route('admin.settings.hom-profile.edit')->with('success', 'HOM Profile PDF updated successfully.');
  }
}
