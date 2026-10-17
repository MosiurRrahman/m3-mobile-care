<?php

namespace App\Http\Controllers;

use App\Models\Repair;
use App\Models\Service;
use App\Models\Customer;
use App\Models\InventoryItem;
use App\Models\Setting;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Services\SmsService;

class HomeController extends Controller
{
    /**
     * Show landing page. If ticket_id is provided, show tracking details.
     */
    public function index(Request $request)
    {
        $repair = null;
        $searched = false;

        if ($request->filled('ticket_id')) {
            $searched = true;
            $repair = Repair::with('technician')
                ->where('ticket_id', trim($request->input('ticket_id')))
                ->first();
        }

        // Last 3 days data lookup
        $threeDaysAgo = now()->subDays(3)->startOfDay();
        
        $recentRepairs = Repair::where('created_at', '>=', $threeDaysAgo)
            ->with('customer')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        $repairsByStatus = Repair::where('created_at', '>=', $threeDaysAgo)
            ->selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        // E-Commerce Inventory Products
        $inventoryProducts = InventoryItem::where('quantity', '>', 0)
            ->latest()
            ->take(8)
            ->get();

        // Dynamic Real Shop Settings from Database
        $shopSettings = [
            'shop_name' => Setting::get('shop_name', 'M3 Mobile Care'),
            'shop_slogan' => Setting::get('shop_slogan', 'Trusted Mobile Repair & Accessories Shop'),
            'phone' => Setting::get('phone', '+8801750121196 / +8801353106966'),
            'email' => Setting::get('email', 'support@m3mobilecares.com'),
            'address' => Setting::get('address', '(বিগ বাজার) আব্দুল গফফার মার্কেট রাণীশংকৈল, ঠাকুরগাঁও'),
            'logo' => Setting::get('logo'),
        ];

        $services = Service::all();

        return view('home', compact('repair', 'searched', 'recentRepairs', 'repairsByStatus', 'inventoryProducts', 'services', 'shopSettings'));
    }

    /**
     * Handle track form submission (POST) and redirect to GET route.
     */
    public function track(Request $request)
    {
        $request->validate([
            'ticket_id' => 'required|string',
        ]);

        return redirect()->route('track.form', ['ticket_id' => trim($request->input('ticket_id'))]);
    }

    /**
     * Show booking form.
     */
    public function showBookingForm()
    {
        $services = Service::all();
        return view('book-repair', compact('services'));
    }

    /**
     * AJAX endpoint to lookup existing customer by phone number.
     */
    public function customerLookupAjax(Request $request)
    {
        $phone = trim($request->input('phone', ''));
        if (strlen($phone) < 6) {
            return response()->json(['found' => false]);
        }
        $cleanPhone = preg_replace('/[^\d+]/', '', $phone);
        $customer = Customer::where('phone', $cleanPhone)
            ->orWhere('phone', $phone)
            ->first();

        if ($customer) {
            return response()->json([
                'found' => true,
                'name' => $customer->name,
                'email' => $customer->email,
            ]);
        }

        return response()->json(['found' => false]);
    }

    /**
     * Handle online repair booking submission with multiple devices support.
     */
    public function book(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_email' => 'nullable|email|max:255',
            // Multiple devices array support
            'devices' => 'nullable|array|min:1',
            'devices.*.brand' => 'required_with:devices|string|max:100',
            'devices.*.model' => 'required_with:devices|string|max:100',
            'devices.*.serial_imei' => 'nullable|string|max:100',
            'devices.*.issue_description' => 'required_with:devices|string',
            'devices.*.estimated_cost' => 'nullable|numeric|min:0',
            'devices.*.service_id' => 'nullable',
            // Fallback for single legacy device
            'device_brand' => 'required_without:devices|string|max:100',
            'device_model' => 'required_without:devices|string|max:100',
            'serial_imei' => 'nullable|string|max:100',
            'issue_description' => 'required_without:devices|string',
            'estimated_cost' => 'nullable|numeric|min:0',
        ]);

        $rawDevices = $request->input('devices');
        if (empty($rawDevices) || !is_array($rawDevices)) {
            $rawDevices = [
                [
                    'brand' => $request->input('device_brand'),
                    'model' => $request->input('device_model'),
                    'serial_imei' => $request->input('serial_imei'),
                    'issue_description' => $request->input('issue_description'),
                    'estimated_cost' => $request->input('estimated_cost', 0),
                    'service_id' => $request->input('service_type'),
                ]
            ];
        }

        // Clean customer phone
        $rawPhone = trim($request->input('customer_phone'));
        $cleanPhone = preg_replace('/[^\d+]/', '', $rawPhone);

        // Find or create customer
        $customer = Customer::where('phone', $cleanPhone)
            ->orWhere('phone', $rawPhone)
            ->first();

        if (!$customer) {
            $customer = Customer::create([
                'name' => trim($request->input('customer_name')),
                'phone' => $cleanPhone ?: $rawPhone,
                'email' => trim($request->input('customer_email')) ?: null,
            ]);
        } else {
            $updates = [];
            if ($request->filled('customer_name') && (empty($customer->name) || $customer->name === 'Walk-in Customer')) {
                $updates['name'] = trim($request->input('customer_name'));
            }
            if ($request->filled('customer_email') && empty($customer->email)) {
                $updates['email'] = trim($request->input('customer_email'));
            }
            if (!empty($updates)) {
                $customer->update($updates);
            }
        }

        $createdRepairs = [];
        $ticketIds = [];

        DB::transaction(function () use ($rawDevices, $customer, &$createdRepairs, &$ticketIds) {
            foreach ($rawDevices as $dev) {
                // Generate unique Ticket ID
                do {
                    $ticketId = 'M3-' . date('Ym') . '-' . strtoupper(Str::random(4));
                } while (Repair::where('ticket_id', $ticketId)->exists());

                $estCost = floatval($dev['estimated_cost'] ?? 0);
                if (!$estCost && !empty($dev['service_id'])) {
                    $srv = Service::find($dev['service_id']);
                    if ($srv) {
                        $estCost = $srv->price;
                    }
                }
                if (!$estCost && !empty($dev['model'])) {
                    $matchedService = Service::where('name', 'like', '%' . $dev['model'] . '%')->first();
                    $estCost = $matchedService ? $matchedService->price : 0;
                }

                $repair = Repair::create([
                    'ticket_id' => $ticketId,
                    'customer_id' => $customer->id,
                    'device_brand' => trim($dev['brand'] ?? 'Other'),
                    'device_model' => trim($dev['model'] ?? 'Unknown Model'),
                    'serial_imei' => !empty($dev['serial_imei']) ? trim($dev['serial_imei']) : null,
                    'issue_description' => trim($dev['issue_description'] ?? 'Repair appointment'),
                    'estimated_cost' => $estCost,
                    'status' => 'pending',
                ]);

                $createdRepairs[] = $repair;
                $ticketIds[] = $repair->ticket_id;
            }
        });

        // Dispatch tracking SMS notification for each repair
        try {
            foreach ($createdRepairs as $repair) {
                $repair->load('customer');
                SmsService::sendRepairCreatedSms($repair);
            }
        } catch (\Throwable $smsEx) {
            // Suppress SMS exceptions
        }

        $count = count($ticketIds);
        $primaryTicket = $ticketIds[0];
        $msg = $count > 1 
            ? "{$count}টি মোবাইল সফলভাবে বুকিং সম্পন্ন হয়েছে! প্রতিটির জন্য ট্র্যাকিং কোড তৈরি হয়েছে।"
            : 'Repair request booked successfully and Tracking SMS sent!';

        return redirect()->route('book.success', ['ticket_id' => $primaryTicket, 'tickets' => implode(',', $ticketIds)])
            ->with('all_ticket_ids', $ticketIds)
            ->with('success', $msg);
    }

    /**
     * Show booking success page.
     */
    public function bookingSuccess(Request $request, $ticket_id)
    {
        $allIds = session('all_ticket_ids');
        if (empty($allIds) && $request->filled('tickets')) {
            $allIds = array_filter(explode(',', $request->query('tickets')));
        }
        if (empty($allIds)) {
            $allIds = [$ticket_id];
        }

        $repairs = Repair::with('customer')->whereIn('ticket_id', $allIds)->get();
        if ($repairs->isEmpty()) {
            $repair = Repair::where('ticket_id', $ticket_id)->firstOrFail();
            $repairs = collect([$repair]);
        }

        $repair = $repairs->first();

        return view('booking-success', compact('repair', 'repairs'));
    }

    /**
     * Show Services page.
     */
    public function services()
    {
        $services = Service::all();
        $shopSettings = $this->getShopSettings();
        return view('services', compact('services', 'shopSettings'));
    }

    /**
     * Show About Us page.
     */
    public function about()
    {
        $shopSettings = $this->getShopSettings();
        return view('about', compact('shopSettings'));
    }

    /**
     * Show Contact Us page.
     */
    public function contact()
    {
        $shopSettings = $this->getShopSettings();
        return view('contact', compact('shopSettings'));
    }

    /**
     * Handle public contact form submission.
     */
    public function submitContact(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'message' => 'required|string',
        ]);

        $name = trim($request->input('name'));
        $phone = trim($request->input('phone'));
        $message = trim($request->input('message'));

        // Build WhatsApp direct URL for shop owner
        $shopWa = Setting::get('whatsapp', '+8801750121196');
        $cleanWa = preg_replace('/[^0-9]/', '', $shopWa);
        if (str_starts_with($cleanWa, '01')) {
            $cleanWa = '88' . $cleanWa;
        }

        $waText = "নমস্কার M3 Mobile Care,\n\n👤 নাম: {$name}\n📞 মোবাইল: {$phone}\n💬 বার্তা: {$message}";
        $waUrl = "https://api.whatsapp.com/send?phone={$cleanWa}&text=" . rawurlencode($waText);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'ধন্যবাদ! আপনাকে হোয়াটসঅ্যাপে পাঠানো হচ্ছে...',
                'whatsapp_url' => $waUrl,
            ]);
        }

        return redirect()->back()
            ->with('success', 'ধন্যবাদ! আপনাকে হোয়াটসঅ্যাপে পাঠানো হচ্ছে...')
            ->with('whatsapp_url', $waUrl);
    }

    /**
     * Show E-Commerce Products / Mobikart Storefront page.
     */
     public function products(Request $request)
     {
         $query = InventoryItem::where('quantity', '>', 0);

         // Search Filter
         if ($request->filled('search')) {
             $term = trim($request->input('search'));
             $query->where(function ($q) use ($term) {
                 $q->where('name', 'like', "%{$term}%")
                   ->orWhere('brand', 'like', "%{$term}%")
                   ->orWhere('model', 'like', "%{$term}%")
                   ->orWhere('description', 'like', "%{$term}%")
                   ->orWhere('category', 'like', "%{$term}%");
             });
         }

         // Category Filter
         if ($request->filled('category') && $request->input('category') !== 'all') {
             $query->where('category', $request->input('category'));
         }

         // Brand Filter
         if ($request->filled('brand')) {
             $query->where('brand', $request->input('brand'));
         }

         // Sorting
         $sort = $request->input('sort', 'latest');
         if ($sort === 'price_asc') {
             $query->orderBy('sale_price', 'asc');
         } elseif ($sort === 'price_desc') {
             $query->orderBy('sale_price', 'desc');
         } elseif ($sort === 'name_asc') {
             $query->orderBy('name', 'asc');
         } else {
             $query->latest();
         }

         $products = $query->paginate(24)->withQueryString();
         $shopSettings = $this->getShopSettings();

         // Categories from DB Category model and InventoryItem
         $dbCategories = Category::where('status', 'active')->pluck('name')->toArray();
         $itemCategories = InventoryItem::distinct()->pluck('category')->filter()->toArray();
         $categories = array_values(array_unique(array_merge($dbCategories, $itemCategories)));

         // Brands
         $brands = InventoryItem::distinct()->pluck('brand')->filter()->values()->toArray();

         // Featured Deals & New Arrivals
         $featuredProducts = InventoryItem::where('quantity', '>', 0)->inRandomOrder()->take(8)->get();
         $dealProducts = InventoryItem::where('quantity', '>', 0)->whereNotNull('sale_price')->latest()->take(6)->get();

         return view('products', compact('products', 'shopSettings', 'categories', 'brands', 'featuredProducts', 'dealProducts'));
    }

    /**
     * Show Product Details (Mobikart Product Single page).
     */
    public function productSingle(Request $request, $id = null)
    {
        $product = null;
        if ($id) {
            $product = InventoryItem::find($id);
        }

        // Related Products
        $relatedProducts = InventoryItem::when($id, function($q) use ($id) {
                return $q->where('id', '!=', $id);
            })
            ->where('quantity', '>', 0)
            ->inRandomOrder()
            ->take(4)
            ->get();

        $shopSettings = $this->getShopSettings();

        return view('product-single', compact('product', 'relatedProducts', 'shopSettings'));
    }

    /**
     * Show dedicated ERT (Estimated Repair Tracking) Page.
     */
    public function trackView(Request $request)
    {
        $repair = null;
        $searched = false;

        if ($request->filled('ticket_id')) {
            $searched = true;
            $repair = Repair::with(['technician', 'customer'])
                ->where('ticket_id', trim($request->input('ticket_id')))
                ->first();
        }

        $shopSettings = $this->getShopSettings();
        return view('track-ert', compact('repair', 'searched', 'shopSettings'));
    }

    /**
     * Helper to retrieve shop settings array.
     */
    private function getShopSettings()
    {
        return [
            'shop_name' => Setting::get('shop_name', 'M3 Mobile Care'),
            'shop_slogan' => Setting::get('shop_slogan', 'Trusted Mobile Repair & Accessories Shop'),
            'phone' => Setting::get('phone', '+8801750121196 / +8801353106966'),
            'whatsapp' => Setting::get('whatsapp', '+8801750121196'),
            'email' => Setting::get('email', 'support@m3mobilecares.com'),
            'address' => Setting::get('address', '(বিগ বাজার) আব্দুল গফফার মার্কেট রাণীশংকৈল, ঠাকুরগাঁও'),
            'logo' => Setting::get('logo'),
        ];
    }

    /**
     * AJAX route for live ticket tracking.
     */
    public function trackAjax(Request $request)
    {
        $repair = Repair::with(['technician', 'customer'])
            ->where('ticket_id', trim($request->input('ticket_id')))
            ->first();
            
        return view('_partials.track-modal-body', compact('repair'))->render();
    }
}
