<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Helpers\Helpers;

class SettingController extends Controller
{
    /**
     * Display settings page.
     */
    public function index()
    {
        $settings = [
            'shop_name' => Setting::get('shop_name', 'M3 Mobile Care'),
            'shop_slogan' => Setting::get('shop_slogan', 'Premium Mobile Repair & Retail'),
            'phone' => Setting::get('phone', '+880 1712-345678'),
            'email' => Setting::get('email', 'info@m3mobilecare.com'),
            'address' => Setting::get('address', 'Shop 14, Level 3, Multiplan Center, Elephant Road, Dhaka'),
            'logo' => Setting::get('logo'),
            'receipt_footer' => Setting::get('receipt_footer'),
        ];

        return view('settings.index', compact('settings'));
    }

    /**
     * Update settings.
     */
    public function update(Request $request)
    {
        $request->validate([
            'shop_name' => 'required|string|max:255',
            'shop_slogan' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:100',
            'email' => 'nullable|string|email|max:255',
            'address' => 'nullable|string|max:500',
            'logo' => 'nullable|image|max:10240',
            'receipt_footer' => 'nullable|string',
        ]);

        Setting::set('shop_name', $request->input('shop_name'));
        Setting::set('shop_slogan', $request->input('shop_slogan'));
        Setting::set('phone', $request->input('phone'));
        Setting::set('email', $request->input('email'));
        Setting::set('address', $request->input('address'));
        Setting::set('receipt_footer', $request->input('receipt_footer'));

        if ($request->hasFile('logo')) {
            $oldLogo = Setting::get('logo');
            if ($oldLogo) {
                Storage::disk('public')->delete($oldLogo);
            }
            $logoPath = Helpers::compressAndStoreImage($request->file('logo'), 'settings');
            Setting::set('logo', $logoPath);
        }

        return redirect()->back()->with('success', 'Shop settings updated successfully!');
    }
}
