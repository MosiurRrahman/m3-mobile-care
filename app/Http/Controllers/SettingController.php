<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Helpers\Helpers;
use App\Services\SmsService;

class SettingController extends Controller
{
    /**
     * Display settings page.
     */
    public function index()
    {
        $settings = [
            'shop_name' => Setting::get('shop_name', 'M3 Mobile Care'),
            'shop_slogan' => Setting::get('shop_slogan', 'Trusted Mobile Repair & Accessories Shop'),
            'phone' => Setting::get('phone', '+8801353106967 / +8801353106966'),
            'whatsapp' => Setting::get('whatsapp', '+8801353106967'),
            'email' => Setting::get('email', 'support@m3mobilecares.com'),
            'address' => Setting::get('address', '(বিগ বাজার) আব্দুল গফফার মার্কেট রাণীশংকৈল, ঠাকুরগাঁও'),
            'logo' => Setting::get('logo'),
            'receipt_footer' => Setting::get('receipt_footer'),

            // SMS Gateway Configuration
            'sms_enabled' => Setting::get('sms_enabled', '1'),
            'sms_api_key' => Setting::get('sms_api_key', 'JbOhNywIOVzaA71IMVo06'),
            'sms_sender_id' => Setting::get('sms_sender_id', ''),
            'sms_send_on_repair_create' => Setting::get('sms_send_on_repair_create', '1'),
            'sms_send_on_repair_ready' => Setting::get('sms_send_on_repair_ready', '1'),
            'sms_send_on_repair_deliver' => Setting::get('sms_send_on_repair_deliver', '1'),
            'sms_send_on_pos_sale' => Setting::get('sms_send_on_pos_sale', '1'),
            'sms_send_on_due_payment' => Setting::get('sms_send_on_due_payment', '1'),

            // SMS Templates (Bangla)
            'sms_template_repair_create' => Setting::get('sms_template_repair_create', "প্রিয় {customer_name}, আপনার {device} সার্ভিসের জন্য গ্রহণ করা হয়েছে। টিকিট আইডি: {ticket_id}। কাজের অগ্রগতি দেখুন: {track_url} - {shop_name}"),
            'sms_template_repair_ready' => Setting::get('sms_template_repair_ready', "প্রিয় {customer_name}, আপনার {device} মেরামত সম্পন্ন হয়েছে। মোট বিল: {total_bill} টাকা (বকেয়া: {due_amount} টাকা)। হটলাইন: {shop_phone} - {shop_name}"),
            'sms_template_repair_deliver' => Setting::get('sms_template_repair_deliver', "প্রিয় {customer_name}, আপনার {device} (টিকিট: {ticket_id}) ডেলিভারি করা হয়েছে। পরিশোধ: {paid_amount} টাকা, বকেয়া: {due_amount} টাকা। ওয়ারেন্টি: {warranty_days}। ধন্যবাদ - {shop_name}"),
            'sms_template_pos_sale' => Setting::get('sms_template_pos_sale', "প্রিয় {customer_name}, {shop_name}-এ কেনাকাটার জন্য ধন্যবাদ! ইনভয়েস: {invoice_no}, মোট বিল: {total_bill} টাকা, পরিশোধ: {paid_amount} টাকা, বকেয়া: {due_amount} টাকা।"),
            'sms_template_due_payment' => Setting::get('sms_template_due_payment', "প্রিয় {customer_name}, বকেয়া বাবদ {paid_amount} টাকা গ্রহণ করা হয়েছে ({reference_no})। অবশিষ্ট বকেয়া: {due_amount} টাকা। ধন্যবাদ! - {shop_name}"),
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
            'whatsapp' => 'nullable|string|max:100',
            'email' => 'nullable|string|email|max:255',
            'address' => 'nullable|string|max:500',
            'logo' => 'nullable|image|max:10240',
            'receipt_footer' => 'nullable|string',
            'sms_api_key' => 'nullable|string|max:255',
            'sms_sender_id' => 'nullable|string|max:100',
            'sms_template_repair_create' => 'nullable|string',
            'sms_template_repair_ready' => 'nullable|string',
            'sms_template_repair_deliver' => 'nullable|string',
            'sms_template_pos_sale' => 'nullable|string',
            'sms_template_due_payment' => 'nullable|string',
        ]);

        Setting::set('shop_name', $request->input('shop_name'));
        Setting::set('shop_slogan', $request->input('shop_slogan'));
        Setting::set('phone', $request->input('phone'));
        Setting::set('whatsapp', $request->input('whatsapp'));
        Setting::set('email', $request->input('email'));
        Setting::set('address', $request->input('address'));
        Setting::set('receipt_footer', $request->input('receipt_footer'));

        // SMS Gateway Settings
        Setting::set('sms_enabled', $request->has('sms_enabled') ? '1' : '0');
        Setting::set('sms_api_key', $request->input('sms_api_key'));
        Setting::set('sms_sender_id', $request->input('sms_sender_id'));
        Setting::set('sms_send_on_repair_create', $request->has('sms_send_on_repair_create') ? '1' : '0');
        Setting::set('sms_send_on_repair_ready', $request->has('sms_send_on_repair_ready') ? '1' : '0');
        Setting::set('sms_send_on_repair_deliver', $request->has('sms_send_on_repair_deliver') ? '1' : '0');
        Setting::set('sms_send_on_pos_sale', $request->has('sms_send_on_pos_sale') ? '1' : '0');
        Setting::set('sms_send_on_due_payment', $request->has('sms_send_on_due_payment') ? '1' : '0');

        // SMS Templates
        Setting::set('sms_template_repair_create', $request->input('sms_template_repair_create'));
        Setting::set('sms_template_repair_ready', $request->input('sms_template_repair_ready'));
        Setting::set('sms_template_repair_deliver', $request->input('sms_template_repair_deliver'));
        Setting::set('sms_template_pos_sale', $request->input('sms_template_pos_sale'));
        Setting::set('sms_template_due_payment', $request->input('sms_template_due_payment'));

        if ($request->hasFile('logo')) {
            $oldLogo = Setting::get('logo');
            if ($oldLogo) {
                Storage::disk('public')->delete($oldLogo);
            }
            $logoPath = Helpers::compressAndStoreImage($request->file('logo'), 'settings');
            Setting::set('logo', $logoPath);
        }

        return redirect()->back()->with('success', 'Shop and SMS settings updated successfully!');
    }

    /**
     * Send a test SMS to verify gateway configuration
     */
    public function testSms(Request $request)
    {
        $request->validate([
            'test_phone' => 'required|string|min:11|max:15',
            'test_message' => 'required|string|max:300',
        ]);

        $phone = $request->input('test_phone');
        $message = $request->input('test_message');

        $result = SmsService::sendSms($phone, $message, true);

        if ($result['success']) {
            return response()->json([
                'success' => true,
                'message' => 'Test SMS sent successfully to ' . $phone . '! Gateway response: ' . $result['message'],
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Failed to send test SMS: ' . $result['message'],
        ], 422);
    }

    /**
     * Get live SMS balance from BulkSMSBD API
     */
    public function getSmsBalance(Request $request)
    {
        $apiKey = $request->input('api_key');
        $balanceInfo = SmsService::getBalance($apiKey);
        return response()->json($balanceInfo);
    }
}
