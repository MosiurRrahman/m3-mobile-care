<?php

namespace App\Services;

use App\Models\Setting;
use App\Models\Repair;
use App\Models\Sale;
use App\Models\Customer;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SmsService
{
    /**
     * Format Bangladeshi phone numbers to clean standard format (01XXXXXXXXX or 8801XXXXXXXXX)
     */
    public static function formatNumber(string $phone): string
    {
        // Remove non-numeric characters
        $clean = preg_replace('/[^0-9]/', '', $phone);

        // If starts with 8801, return clean
        if (str_starts_with($clean, '8801') && strlen($clean) === 13) {
            return $clean;
        }

        // If starts with 01 and length is 11, prepend 88
        if (str_starts_with($clean, '01') && strlen($clean) === 11) {
            return '88' . $clean;
        }

        // If 10 digits without leading 0 (e.g. 1712345678)
        if (strlen($clean) === 10 && str_starts_with($clean, '1')) {
            return '880' . $clean;
        }

        return $clean;
    }

    /**
     * Check if message contains non-ASCII (Unicode/Bengali) characters
     */
    public static function isUnicode(string $message): bool
    {
        return strlen($message) !== mb_strlen($message, 'utf-8');
    }

    /**
     * Send an SMS via BulkSMSBD API
     *
     * @param string $phone
     * @param string $message
     * @param bool $force Force send even if global setting is disabled (e.g. for Test SMS)
     * @return array
     */
    public static function sendSms(string $phone, string $message, bool $force = false): array
    {
        $enabled = Setting::get('sms_enabled', '0');
        if (!$enabled && !$force) {
            return [
                'success' => false,
                'message' => 'SMS notifications are currently disabled in shop settings.',
            ];
        }

        $apiKey = Setting::get('sms_api_key', 'JbOhNywIOVzaA71IMVo06');
        $senderId = Setting::get('sms_sender_id', '');

        if (empty($apiKey)) {
            return [
                'success' => false,
                'message' => 'BulkSMSBD API Key is missing in settings.',
            ];
        }

        $formattedPhone = self::formatNumber($phone);

        if (strlen($formattedPhone) < 11) {
            return [
                'success' => false,
                'message' => 'Invalid Bangladeshi phone number provided: ' . $phone,
            ];
        }

        $type = self::isUnicode($message) ? 'unicode' : 'text';

        try {
            $apiUrl = Setting::get('sms_api_url', 'http://bulksmsbd.net/api/smsapi');

            $queryParams = [
                'api_key' => $apiKey,
                'type' => $type,
                'number' => $formattedPhone,
                'senderid' => $senderId,
                'message' => $message,
            ];

            $response = Http::timeout(15)->get($apiUrl, $queryParams);

            $responseBody = $response->body();
            $responseData = json_decode($responseBody, true);

            // BulkSMSBD returns response_code 202 on success
            // e.g. {"response_code": 202, "message_id": 12345, "success_message": "SMS Submitted Successfully"}
            $isSuccess = false;
            $statusMessage = 'Unknown response from SMS gateway.';

            if (is_array($responseData)) {
                $code = $responseData['response_code'] ?? null;
                if ($code == 202 || $code === '202') {
                    $isSuccess = true;
                    $statusMessage = $responseData['success_message'] ?? 'SMS Submitted Successfully';
                } else {
                    $statusMessage = $responseData['error_message'] ?? ($responseData['message'] ?? 'Failed with code: ' . $code);
                }
            } else {
                if (str_contains(strtolower($responseBody), 'success') || str_contains($responseBody, '202')) {
                    $isSuccess = true;
                    $statusMessage = $responseBody;
                } else {
                    $statusMessage = $responseBody;
                }
            }

            Log::info("SMS dispatch result [{$formattedPhone}]: " . ($isSuccess ? 'SUCCESS' : 'FAILED'), [
                'phone' => $formattedPhone,
                'message' => $message,
                'response' => $responseBody,
            ]);

            return [
                'success' => $isSuccess,
                'message' => $statusMessage,
                'raw_response' => $responseBody,
            ];
        } catch (\Throwable $e) {
            Log::error('SMS Dispatch Exception: ' . $e->getMessage(), [
                'phone' => $formattedPhone,
                'message' => $message,
            ]);

            return [
                'success' => false,
                'message' => 'Network error connecting to SMS Gateway: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Check live SMS balance from BulkSMSBD API
     */
    public static function getBalance(?string $overrideApiKey = null): array
    {
        $apiKey = $overrideApiKey ?: Setting::get('sms_api_key', '');

        if (empty($apiKey)) {
            return [
                'success' => false,
                'balance' => '0.00',
                'message' => 'API Key is not configured yet. Please enter your API Key and save.',
            ];
        }

        try {
            $apiUrl = 'http://bulksmsbd.net/api/getBalanceApi';
            $response = Http::timeout(10)->get($apiUrl, ['api_key' => $apiKey]);

            $body = $response->body();
            $data = json_decode($body, true);

            if (is_array($data)) {
                if (isset($data['balance'])) {
                    return [
                        'success' => true,
                        'balance' => $data['balance'],
                        'message' => 'Balance fetched successfully.',
                    ];
                }
                if (isset($data['error_message'])) {
                    return [
                        'success' => false,
                        'balance' => '0.00',
                        'message' => $data['error_message'],
                    ];
                }
            }

            // Fallback for plain number responses
            if (is_numeric(trim($body))) {
                return [
                    'success' => true,
                    'balance' => trim($body),
                    'message' => 'Balance fetched successfully.',
                ];
            }

            return [
                'success' => false,
                'balance' => '0.00',
                'message' => $body ?: 'Unable to parse balance response.',
            ];
        } catch (\Throwable $e) {
            return [
                'success' => false,
                'balance' => '0.00',
                'message' => 'Failed to reach balance API: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Get clean customer display name for SMS (avoiding phone numbers / Walk-in literals)
     */
    public static function getCustomerDisplayName(?Customer $customer): string
    {
        if (!$customer || empty($customer->name)) {
            return 'গ্রাহক';
        }
        $name = trim($customer->name);
        if (strcasecmp($name, 'Walk-in') === 0 || strcasecmp($name, 'Customer') === 0 || preg_match('/^[0-9+() -]+$/', $name)) {
            return 'গ্রাহক';
        }
        return $name;
    }

    /**
     * Replace template placeholder tags with actual values
     */
    public static function formatTemplate(string $template, array $data): string
    {
        foreach ($data as $key => $value) {
            $template = str_replace('{' . $key . '}', (string) $value, $template);
        }
        return trim($template);
    }

    /**
     * Trigger: Repair Job Card Created (Service Tracking SMS)
     */
    public static function sendRepairCreatedSms(Repair $repair): array
    {
        if (!Setting::get('sms_send_on_repair_create', '1')) {
            return ['success' => false, 'message' => 'Repair created notification disabled.'];
        }

        $customer = $repair->customer;
        $phone = $customer ? $customer->phone : null;
        if (empty($phone)) {
            return ['success' => false, 'message' => 'Customer phone number not available.'];
        }

        $shopName = Setting::get('shop_name', 'M3 Mobile Care');
        $shopPhone = Setting::get('phone', '+8801353106967');
        $trackUrl = url('/track?ticket_id=' . $repair->ticket_id);

        $defaultTemplate = "প্রিয় {customer_name}, আপনার {device} সার্ভিসের জন্য গ্রহণ করা হয়েছে। টিকিট আইডি: {ticket_id}। কাজের অগ্রগতি দেখুন: {track_url} - {shop_name}";
        $template = Setting::get('sms_template_repair_create', $defaultTemplate);

        $message = self::formatTemplate($template, [
            'customer_name' => self::getCustomerDisplayName($customer),
            'ticket_id' => $repair->ticket_id,
            'device' => trim($repair->device_brand . ' ' . $repair->device_model),
            'estimated_cost' => number_format($repair->estimated_cost ?? $repair->repair_charge, 2),
            'advance_payment' => number_format($repair->advance_payment ?? 0, 2),
            'track_url' => $trackUrl,
            'shop_name' => $shopName,
            'shop_phone' => $shopPhone,
        ]);

        return self::sendSms($phone, $message);
    }

    /**
     * Trigger: Repair Status Completed / Ready for Delivery SMS
     */
    public static function sendRepairReadySms(Repair $repair): array
    {
        if (!Setting::get('sms_send_on_repair_ready', '1')) {
            return ['success' => false, 'message' => 'Repair ready notification disabled.'];
        }

        $customer = $repair->customer;
        $phone = $customer ? $customer->phone : null;
        if (empty($phone)) {
            return ['success' => false, 'message' => 'Customer phone number not available.'];
        }

        $shopName = Setting::get('shop_name', 'M3 Mobile Care');
        $shopPhone = Setting::get('phone', '+8801353106967');
        $totalBill = $repair->actual_cost ?? $repair->estimated_cost;
        $dueAmount = max(0, floatval($totalBill) - floatval($repair->paid_amount));

        $defaultTemplate = "প্রিয় {customer_name}, আপনার {device} মেরামত সম্পন্ন হয়েছে। মোট বিল: {total_bill} টাকা (বকেয়া: {due_amount} টাকা)। হটলাইন: {shop_phone} - {shop_name}";
        $template = Setting::get('sms_template_repair_ready', $defaultTemplate);

        $message = self::formatTemplate($template, [
            'customer_name' => self::getCustomerDisplayName($customer),
            'ticket_id' => $repair->ticket_id,
            'device' => trim($repair->device_brand . ' ' . $repair->device_model),
            'total_bill' => number_format($totalBill, 2),
            'paid_amount' => number_format($repair->paid_amount, 2),
            'due_amount' => number_format($dueAmount, 2),
            'shop_name' => $shopName,
            'shop_phone' => $shopPhone,
        ]);

        return self::sendSms($phone, $message);
    }

    /**
     * Trigger: Repair Delivered & Payment Completed SMS
     */
    public static function sendRepairDeliveredSms(Repair $repair): array
    {
        if (!Setting::get('sms_send_on_repair_deliver', '1')) {
            return ['success' => false, 'message' => 'Repair delivery notification disabled.'];
        }

        $customer = $repair->customer;
        $phone = $customer ? $customer->phone : null;
        if (empty($phone)) {
            return ['success' => false, 'message' => 'Customer phone number not available.'];
        }

        $shopName = Setting::get('shop_name', 'M3 Mobile Care');
        $shopPhone = Setting::get('phone', '+8801353106967');
        $totalBill = $repair->actual_cost ?? $repair->estimated_cost;
        $paidAmount = $repair->paid_amount;
        $dueAmount = $repair->due_amount;
        $warranty = $repair->warranty_days ? $repair->warranty_days . ' days' : 'N/A';

        $defaultTemplate = "প্রিয় {customer_name}, আপনার {device} (টিকিট: {ticket_id}) ডেলিভারি করা হয়েছে। পরিশোধ: {paid_amount} টাকা, বকেয়া: {due_amount} টাকা। ওয়ারেন্টি: {warranty_days}। ধন্যবাদ - {shop_name}";
        $template = Setting::get('sms_template_repair_deliver', $defaultTemplate);

        $message = self::formatTemplate($template, [
            'customer_name' => self::getCustomerDisplayName($customer),
            'ticket_id' => $repair->ticket_id,
            'device' => trim($repair->device_brand . ' ' . $repair->device_model),
            'total_bill' => number_format($totalBill, 2),
            'paid_amount' => number_format($paidAmount, 2),
            'due_amount' => number_format($dueAmount, 2),
            'warranty_days' => $warranty,
            'shop_name' => $shopName,
            'shop_phone' => $shopPhone,
        ]);

        return self::sendSms($phone, $message);
    }

    /**
     * Trigger: POS Retail Sale Invoice SMS
     */
    public static function sendPosSaleSms(Sale $sale, bool $isManual = false): array
    {
        if (!$isManual && !Setting::get('sms_send_on_pos_sale', '1')) {
            return ['success' => false, 'message' => 'POS sale notification disabled.'];
        }

        $customer = $sale->customer;
        $phone = $customer ? $customer->phone : null;
        if (empty($phone)) {
            return ['success' => false, 'message' => 'Customer phone number not available.'];
        }

        $shopName = Setting::get('shop_name', 'M3 Mobile Care');
        $shopPhone = Setting::get('phone', '+8801353106967');

        $defaultTemplate = "প্রিয় {customer_name}, {shop_name}-এ কেনাকাটার জন্য ধন্যবাদ! ইনভয়েস: {invoice_no}, মোট বিল: {total_bill} টাকা, পরিশোধ: {paid_amount} টাকা, বকেয়া: {due_amount} টাকা।";
        $template = Setting::get('sms_template_pos_sale', $defaultTemplate);

        $message = self::formatTemplate($template, [
            'customer_name' => self::getCustomerDisplayName($customer),
            'invoice_no' => $sale->invoice_no,
            'total_bill' => number_format($sale->payable_amount, 2),
            'paid_amount' => number_format($sale->paid_amount, 2),
            'due_amount' => number_format($sale->due_amount, 2),
            'shop_name' => $shopName,
            'shop_phone' => $shopPhone,
        ]);

        return self::sendSms($phone, $message);
    }

    /**
     * Trigger: Customer Due Payment Receipt SMS
     */
    public static function sendDuePaymentSms($customer, float $paidAmount, float $remainingDue, string $sourceType, string $referenceNo): array
    {
        if (!Setting::get('sms_send_on_due_payment', '1')) {
            return ['success' => false, 'message' => 'Due payment notification disabled.'];
        }

        $phone = is_object($customer) ? $customer->phone : null;
        if (empty($phone)) {
            return ['success' => false, 'message' => 'Customer phone number not available.'];
        }

        $shopName = Setting::get('shop_name', 'M3 Mobile Care');
        $shopPhone = Setting::get('phone', '+8801353106967');

        $defaultTemplate = "প্রিয় {customer_name}, বকেয়া বাবদ {paid_amount} টাকা গ্রহণ করা হয়েছে ({reference_no})। অবশিষ্ট বকেয়া: {due_amount} টাকা। ধন্যবাদ! - {shop_name}";
        $template = Setting::get('sms_template_due_payment', $defaultTemplate);

        $customerObj = is_object($customer) ? $customer : null;

        $message = self::formatTemplate($template, [
            'customer_name' => self::getCustomerDisplayName($customerObj),
            'paid_amount' => number_format($paidAmount, 2),
            'due_amount' => number_format($remainingDue, 2),
            'reference_no' => $referenceNo,
            'source_type' => $sourceType,
            'shop_name' => $shopName,
            'shop_phone' => $shopPhone,
        ]);

        return self::sendSms($phone, $message);
    }

    /**
     * Trigger: Repair Dhaka/External Sourced Parts Arrived in Shop SMS
     */
    public static function sendRepairPartsArrivedSms(Repair $repair): array
    {
        $customer = $repair->customer;
        $phone = $customer ? $customer->phone : null;
        if (empty($phone)) {
            return ['success' => false, 'message' => 'Customer phone number not available.'];
        }

        $shopName = Setting::get('shop_name', 'M3 Mobile Care');
        $shopPhone = Setting::get('phone', '+8801353106967');

        $defaultTemplate = "প্রিয় {customer_name}, আপনার {device} (টিকিট: {ticket_id})-এর প্রয়োজনীয় পার্টস ঢাকা থেকে আমাদের দোকানে এসে পৌঁছেছে। খুব শীঘ্রই সার্ভিস সম্পন্ন করা হবে। - {shop_name}";
        $template = Setting::get('sms_template_repair_parts_arrived', $defaultTemplate);

        $message = self::formatTemplate($template, [
            'customer_name' => self::getCustomerDisplayName($customer),
            'ticket_id' => $repair->ticket_id,
            'device' => trim($repair->device_brand . ' ' . $repair->device_model),
            'shop_name' => $shopName,
            'shop_phone' => $shopPhone,
        ]);

        return self::sendSms($phone, $message, true);
    }

    /**
     * Trigger: Special Order Created SMS
     */
    public static function sendSpecialOrderCreatedSms($order): array
    {
        $phone = $order->customer_phone;
        if (empty($phone)) {
            return ['success' => false, 'message' => 'Customer phone number not available.'];
        }

        $shopName = Setting::get('shop_name', 'M3 Mobile Care');
        $shopPhone = Setting::get('phone', '+8801353106967');

        $deliveryDate = $order->expected_delivery_date ? $order->expected_delivery_date->format('d M, Y') : 'শীঘ্রই';

        $defaultTemplate = "প্রিয় {customer_name}, আপনার স্পেশাল আইটেম '{item_name}' অর্ডার গ্রহণ করা হয়েছে (অর্ডার: {order_number})। অগ্রিম জমা: {advance_paid} টাকা, সম্ভাব্য ডেলিভারি: {delivery_date}। ধন্যবাদ - {shop_name}";
        $template = Setting::get('sms_template_special_order_create', $defaultTemplate);

        $message = self::formatTemplate($template, [
            'customer_name' => $order->customer_name ?: 'গ্রাহক',
            'order_number' => $order->order_number,
            'item_name' => $order->item_name,
            'advance_paid' => number_format($order->advance_paid, 2),
            'selling_price' => number_format($order->selling_price, 2),
            'delivery_date' => $deliveryDate,
            'shop_name' => $shopName,
            'shop_phone' => $shopPhone,
        ]);

        return self::sendSms($phone, $message);
    }

    /**
     * Trigger: Special Order Arrived in Shop SMS
     */
    public static function sendSpecialOrderArrivedSms($order): array
    {
        $phone = $order->customer_phone;
        if (empty($phone)) {
            return ['success' => false, 'message' => 'Customer phone number not available.'];
        }

        $shopName = Setting::get('shop_name', 'M3 Mobile Care');
        $shopPhone = Setting::get('phone', '+8801353106967');

        $defaultTemplate = "প্রিয় {customer_name}, আপনার অর্ডারকৃত '{item_name}' (অর্ডার: {order_number}) ঢাকা থেকে দোকানে পৌঁছেছে। অনুগ্রহ করে দোকানে এসে রিসিভ করুন। অবশিষ্ট বকেয়া: {due_amount} টাকা। - {shop_name}";
        $template = Setting::get('sms_template_special_order_arrived', $defaultTemplate);

        $message = self::formatTemplate($template, [
            'customer_name' => $order->customer_name ?: 'গ্রাহক',
            'order_number' => $order->order_number,
            'item_name' => $order->item_name,
            'due_amount' => number_format($order->due_amount, 2),
            'shop_name' => $shopName,
            'shop_phone' => $shopPhone,
        ]);

        return self::sendSms($phone, $message, true);
    }
}
