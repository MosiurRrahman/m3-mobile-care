<?php

namespace App\Http\Controllers;

use App\Models\SpecialOrder;
use App\Models\Customer;
use App\Models\User;
use App\Models\PaymentLog;
use App\Services\SmsService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class SpecialOrderController extends Controller
{
    /**
     * Display a listing of special customer orders.
     */
    public function index(Request $request)
    {
        $query = SpecialOrder::with(['customer', 'creator']);

        // Filter by branch for non-admins
        if (!auth()->user()->isSuperAdmin() && !auth()->user()->isAdmin()) {
            $query->where(function ($q) {
                $q->whereNull('branch')
                  ->orWhere('branch', '')
                  ->orWhere('branch', auth()->user()->branch);
            });
        }

        // Filter by Status
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        // Filter by Month (format Y-m, e.g. "2026-08")
        if ($request->filled('month')) {
            $month = $request->input('month');
            $parts = explode('-', $month);
            if (count($parts) === 2) {
                $query->whereYear('created_at', $parts[0])
                      ->whereMonth('created_at', $parts[1]);
            }
        }

        // Search by Order Number, Customer Name, Phone, Item Name
        if ($request->filled('search')) {
            $search = trim($request->input('search'));
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%")
                  ->orWhere('customer_phone', 'like', "%{$search}%")
                  ->orWhere('item_name', 'like', "%{$search}%")
                  ->orWhere('source_supplier', 'like', "%{$search}%");
            });
        }

        // Stats summary for quick counters
        $stats = [
            'total' => (clone $query)->count(),
            'pending' => (clone $query)->whereIn('status', ['pending', 'ordered_from_dhaka'])->count(),
            'received' => (clone $query)->where('status', 'received_in_shop')->count(),
            'delivered' => (clone $query)->where('status', 'delivered')->count(),
            'total_advance' => (clone $query)->sum('advance_paid'),
            'total_due' => (clone $query)->where('status', '!=', 'delivered')->where('status', '!=', 'cancelled')->sum('due_amount'),
        ];

        $perPage = (int) $request->input('per_page', 15);
        $perPage = in_array($perPage, [10, 15, 25, 50, 100]) ? $perPage : 15;

        $orders = $query->orderBy('created_at', 'desc')->paginate($perPage)->withQueryString();

        return view('special_orders.index', compact('orders', 'stats'));
    }

    /**
     * Show the form for creating a new special order.
     */
    public function create()
    {
        return view('special_orders.create');
    }

    /**
     * Store a newly created special order in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'item_name' => 'required|string|max:255',
            'brand' => 'nullable|string|max:100',
            'device_model' => 'nullable|string|max:100',
            'source_supplier' => 'nullable|string|max:255',
            'estimated_cost' => 'required|numeric|min:0',
            'courier_cost' => 'nullable|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'advance_paid' => 'nullable|numeric|min:0',
            'advance_payment_method' => 'nullable|string|in:Cash,bKash,Nagad,Rocket',
            'expected_delivery_date' => 'nullable|date',
            'notes' => 'nullable|string',
            'status' => 'required|string|in:pending,ordered_from_dhaka,received_in_shop,delivered,cancelled',
        ]);

        try {
            $order = DB::transaction(function () use ($request) {
                // Find or create customer
                $phone = trim($request->input('customer_phone'));
                $customer = Customer::where('phone', $phone)->first();
                if (!$customer) {
                    $customer = Customer::create([
                        'name' => $request->input('customer_name'),
                        'phone' => $phone,
                    ]);
                } else {
                    $customer->update([
                        'name' => $request->input('customer_name'),
                    ]);
                }

                // Generate unique Order Number
                do {
                    $orderNumber = 'SORD-' . date('Ym') . '-' . strtoupper(Str::random(4));
                } while (SpecialOrder::where('order_number', $orderNumber)->exists());

                $sellingPrice = floatval($request->input('selling_price', 0));
                $advancePaid = floatval($request->input('advance_paid', 0));
                $status = $request->input('status');

                $dueAmount = max(0, $sellingPrice - $advancePaid);
                if ($status === 'delivered') {
                    $dueAmount = 0.00;
                }

                $order = SpecialOrder::create([
                    'order_number' => $orderNumber,
                    'customer_id' => $customer->id,
                    'customer_name' => $request->input('customer_name'),
                    'customer_phone' => $phone,
                    'item_name' => $request->input('item_name'),
                    'brand' => $request->input('brand'),
                    'device_model' => $request->input('device_model'),
                    'source_supplier' => $request->input('source_supplier'),
                    'estimated_cost' => floatval($request->input('estimated_cost', 0)),
                    'courier_cost' => floatval($request->input('courier_cost', 0)),
                    'selling_price' => $sellingPrice,
                    'advance_paid' => $advancePaid,
                    'due_amount' => $dueAmount,
                    'advance_payment_method' => $request->input('advance_payment_method', 'Cash'),
                    'status' => $status,
                    'expected_delivery_date' => $request->input('expected_delivery_date'),
                    'notes' => $request->input('notes'),
                    'branch' => auth()->user()->branch,
                    'created_by' => auth()->id(),
                    'received_at' => $status === 'received_in_shop' ? now() : null,
                    'delivered_at' => $status === 'delivered' ? now() : null,
                ]);

                // Record initial advance payment log
                if ($advancePaid > 0) {
                    PaymentLog::create([
                        'payable_type' => 'App\\Models\\SpecialOrder',
                        'payable_id' => $order->id,
                        'payment_method' => $request->input('advance_payment_method', 'Cash'),
                        'amount' => $advancePaid,
                        'transaction_reference' => $order->order_number . '-ADV',
                        'transaction_type' => 'initial',
                    ]);
                }

                return $order;
            });

            // Dispatch SMS Notification
            try {
                SmsService::sendSpecialOrderCreatedSms($order);
            } catch (\Throwable $e) {
                // Ignore SMS errors
            }

            return redirect()->route('admin.special-orders.show', $order->id)
                ->with('success', "স্পেশাল অর্ডার #{$order->order_number} সফলভাবে তৈরি করা হয়েছে!");
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Failed to create special order: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified special order.
     */
    public function show($id)
    {
        $order = SpecialOrder::with(['customer', 'creator'])->findOrFail($id);
        $paymentLogs = PaymentLog::where('payable_type', 'App\\Models\\SpecialOrder')
            ->where('payable_id', $order->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('special_orders.show', compact('order', 'paymentLogs'));
    }

    /**
     * Show the form for editing the specified special order.
     */
    public function edit($id)
    {
        $order = SpecialOrder::findOrFail($id);
        return view('special_orders.edit', compact('order'));
    }

    /**
     * Update the specified special order in storage.
     */
    public function update(Request $request, $id)
    {
        $order = SpecialOrder::findOrFail($id);

        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'item_name' => 'required|string|max:255',
            'brand' => 'nullable|string|max:100',
            'device_model' => 'nullable|string|max:100',
            'source_supplier' => 'nullable|string|max:255',
            'estimated_cost' => 'required|numeric|min:0',
            'courier_cost' => 'nullable|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'advance_paid' => 'nullable|numeric|min:0',
            'advance_payment_method' => 'nullable|string|in:Cash,bKash,Nagad,Rocket',
            'final_payment_method' => 'nullable|string|in:Cash,bKash,Nagad,Rocket',
            'expected_delivery_date' => 'nullable|date',
            'notes' => 'nullable|string',
            'status' => 'required|string|in:pending,ordered_from_dhaka,received_in_shop,delivered,cancelled',
        ]);

        try {
            $oldStatus = $order->status;
            $status = $request->input('status');
            $sellingPrice = floatval($request->input('selling_price', 0));
            $advancePaid = floatval($request->input('advance_paid', 0));

            $dueAmount = max(0, $sellingPrice - $advancePaid);
            if ($status === 'delivered') {
                $dueAmount = 0.00;
            }

            $updateData = [
                'customer_name' => $request->input('customer_name'),
                'customer_phone' => trim($request->input('customer_phone')),
                'item_name' => $request->input('item_name'),
                'brand' => $request->input('brand'),
                'device_model' => $request->input('device_model'),
                'source_supplier' => $request->input('source_supplier'),
                'estimated_cost' => floatval($request->input('estimated_cost', 0)),
                'courier_cost' => floatval($request->input('courier_cost', 0)),
                'selling_price' => $sellingPrice,
                'advance_paid' => $advancePaid,
                'due_amount' => $dueAmount,
                'advance_payment_method' => $request->input('advance_payment_method', 'Cash'),
                'final_payment_method' => $request->input('final_payment_method'),
                'status' => $status,
                'expected_delivery_date' => $request->input('expected_delivery_date'),
                'notes' => $request->input('notes'),
            ];

            if ($status === 'received_in_shop' && !$order->received_at) {
                $updateData['received_at'] = now();
            }
            if ($status === 'delivered' && !$order->delivered_at) {
                $updateData['delivered_at'] = now();
            }

            $order->update($updateData);

            // Auto-trigger SMS when arriving in shop
            if ($oldStatus !== 'received_in_shop' && $status === 'received_in_shop') {
                try {
                    SmsService::sendSpecialOrderArrivedSms($order);
                } catch (\Throwable $e) {}
            }

            return redirect()->route('admin.special-orders.show', $order->id)
                ->with('success', 'স্পেশাল অর্ডার সফলভাবে আপডেট করা হয়েছে!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Failed to update order: ' . $e->getMessage());
        }
    }

    /**
     * Quick Status update from modal or show page.
     */
    public function quickStatus(Request $request, $id)
    {
        $order = SpecialOrder::findOrFail($id);

        $request->validate([
            'status' => 'required|string|in:pending,ordered_from_dhaka,received_in_shop,delivered,cancelled',
            'notes' => 'nullable|string',
            'delivery_payment_method' => 'nullable|string|in:Cash,bKash,Nagad,Rocket',
        ]);

        $oldStatus = $order->status;
        $status = $request->input('status');
        $notes = $request->input('notes');

        $updateData = [
            'status' => $status,
        ];
        if ($notes) {
            $updateData['notes'] = ($order->notes ? $order->notes . "\n" : '') . '[' . date('d M Y') . '] ' . $notes;
        }

        if ($status === 'received_in_shop' && !$order->received_at) {
            $updateData['received_at'] = now();
        }

        if ($status === 'delivered') {
            $updateData['delivered_at'] = now();
            $updateData['due_amount'] = 0.00;
            if ($request->filled('delivery_payment_method')) {
                $updateData['final_payment_method'] = $request->input('delivery_payment_method');
            }

            // If there was remaining due, record payment log
            if ($order->due_amount > 0) {
                PaymentLog::create([
                    'payable_type' => 'App\\Models\\SpecialOrder',
                    'payable_id' => $order->id,
                    'payment_method' => $request->input('delivery_payment_method', 'Cash'),
                    'amount' => $order->due_amount,
                    'transaction_reference' => $order->order_number . '-FINAL',
                    'transaction_type' => 'delivery',
                ]);
            }
        }

        $order->update($updateData);

        // SMS Triggers
        if ($oldStatus !== 'received_in_shop' && $status === 'received_in_shop') {
            try {
                SmsService::sendSpecialOrderArrivedSms($order);
            } catch (\Throwable $e) {}
        } elseif ($status === 'delivered') {
            try {
                SmsService::sendSpecialOrderDeliveredSms($order);
            } catch (\Throwable $e) {}
        }

        return redirect()->back()->with('success', 'অর্ডারের স্ট্যাটাস সফলভাবে আপডেট করা হয়েছে!');
    }

    /**
     * Record a customer due payment for a special order.
     */
    public function payDue(Request $request, $id)
    {
        $order = SpecialOrder::findOrFail($id);

        $request->validate([
            'amount_paid' => 'required|numeric|min:0.01|max:' . $order->due_amount,
            'payment_method' => 'required|string|in:Cash,bKash,Nagad,Rocket',
            'transaction_reference' => 'nullable|string',
        ]);

        $amountPaid = floatval($request->input('amount_paid'));
        $paymentMethod = $request->input('payment_method');
        $txnRef = $request->input('transaction_reference');

        try {
            DB::transaction(function () use ($order, $amountPaid, $paymentMethod, $txnRef) {
                $order->advance_paid += $amountPaid;
                $order->due_amount = max(0, $order->due_amount - $amountPaid);
                if ($order->due_amount <= 0 && $order->status === 'received_in_shop') {
                    $order->status = 'delivered';
                    $order->delivered_at = now();
                    $order->final_payment_method = $paymentMethod;
                }
                $order->save();

                PaymentLog::create([
                    'payable_type' => 'App\\Models\\SpecialOrder',
                    'payable_id' => $order->id,
                    'payment_method' => $paymentMethod,
                    'amount' => $amountPaid,
                    'transaction_reference' => $txnRef ?: ($order->order_number . '-DUE'),
                    'transaction_type' => 'due_payment',
                ]);
            });

            return redirect()->back()->with('success', 'Due payment of ' . number_format($amountPaid, 2) . ' BDT recorded successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to process payment: ' . $e->getMessage());
        }
    }

    /**
     * Print customer order receipt slip.
     */
    public function printSlip($id)
    {
        $order = SpecialOrder::with(['customer', 'creator'])->findOrFail($id);
        return view('special_orders.print-slip', compact('order'));
    }

    /**
     * Delete a special order.
     */
    public function destroy($id)
    {
        if (!auth()->user()->isSuperAdmin() && !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        $order = SpecialOrder::findOrFail($id);
        $order->delete();

        return redirect()->route('admin.special-orders.index')->with('success', 'Special order deleted successfully!');
    }
}
