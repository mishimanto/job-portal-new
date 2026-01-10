<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = SiteSetting::all()->pluck('value', 'key');
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'site_name' => 'required|string|max:255',
            'site_logo' => 'nullable|image|max:2048',
            'contact_email' => 'required|email',
            'contact_phone' => 'nullable|string',
            'contact_address' => 'nullable|string',
            'privacy_policy' => 'nullable|string',
            'terms_conditions' => 'nullable|string',
            'about_us' => 'nullable|string',
        ]);

        foreach ($validated as $key => $value) {
            if ($key === 'site_logo' && $request->hasFile('site_logo')) {
                $path = $request->file('site_logo')->store('site', 'public');
                SiteSetting::setValue($key, $path);
            } elseif ($key !== 'site_logo') {
                SiteSetting::setValue($key, $value);
            }
        }

        return redirect()->back()->with('success', 'Settings updated successfully.');
    }
}