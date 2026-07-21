<?php

namespace App\Http\Controllers;

use App\Models\Repair;
use App\Models\Service;
use App\Models\User;
use App\Models\Customer;
use App\Models\InventoryItem;
use App\Models\PaymentLog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Helpers\Helpers;
use Illuminate\Support\Facades\DB;

class RepairController extends Controller
{
    /**
     * Display a listing of repair tickets (Job Cards).
     */
    public function index(Request $request)
    {
        $query = Repair::with(['customer', 'technician']);

        // Technician can only see their assigned repairs
        if (auth()->user()->isTechnician()) {
            $query->where('assigned_technician_id', auth()->id());
        }

        // Filter by branch for non-Admins (Technicians, Salesmen)
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

        // Filter by Month (format Y-m, e.g. "2026-07")
        if ($request->filled('month')) {
            $month = $request->input('month');
            $parts = explode('-', $month);
            if (count($parts) === 2) {
                $query->whereYear('created_at', $parts[0])
                      ->whereMonth('created_at', $parts[1]);
            }
        }

        // Search by Ticket ID, Customer Name, Customer Phone
        if ($request->filled('search')) {
            $search = trim($request->input('search'));
            $query->where(function ($q) use ($search) {
                $q->where('ticket_id', 'like', "%{$search}%")
                  ->orWhereHas('customer', function($cQ) use ($search) {
                      $cQ->where('name', 'like', "%{$search}%")
                         ->orWhere('phone', 'like', "%{$search}%");
                  });
            });
        }

        $perPage = (int) $request->input('per_page', 10);
        $perPage = in_array($perPage, [10, 25, 50, 100]) ? $perPage : 10;

        $repairs = $query->orderBy('created_at', 'desc')->paginate($perPage)->withQueryString();

        return view('repairs.index', compact('repairs'));
    }

    /**
     * Show the form for creating a new repair ticket.
     */
    public function create()
    {
        $customers = Customer::orderBy('name', 'asc')->get();
        $technicians = User::where('role', 'technician')->orderBy('name', 'asc')->get();
        $services = Service::all();
        $inventoryItems = \App\Models\InventoryItem::orderBy('name', 'asc')->get();
        return view('repairs.create', compact('customers', 'technicians', 'services', 'inventoryItems'));
    }

    /**
     * Store a newly created repair ticket in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_address' => 'nullable|string|max:500',
            'device_brand' => 'required|string|max:100',
            'device_model' => 'required|string|max:100',
            'serial_imei' => 'nullable|string|max:100',
            'issue_description' => 'required|string',
            'password_pattern' => 'nullable|string|max:255',
            'repair_charge' => 'required|numeric|min:0',
            'estimated_cost' => 'nullable|numeric|min:0',
            'advance_payment' => 'nullable|numeric|min:0',
            'advance_payment_method' => 'nullable|string|in:Cash,bKash,Nagad,Rocket',
            'advance_payment_ref' => 'nullable|string',
            'status' => 'required|string|in:pending,diagnosing,waiting_for_approval,repairing,quality_check,completed,delivered,cancelled',
            'assigned_technician_id' => 'nullable|exists:users,id',
            'expected_delivery_date' => 'nullable|date',
            'technician_notes' => 'nullable|string',
            'device_checklist' => 'nullable|array',
            'device_photos.*' => 'image|max:20480',
            'commission_type' => 'nullable|string|in:flat,percentage',
            'commission_rate' => 'nullable|numeric|min:0',
            'used_parts' => 'nullable|array',
            'warranty_days' => 'nullable|integer|min:0',
            'pattern_lock_path' => 'nullable|string',
            'data_loss_consent' => 'nullable',
            'used_parts.*.name' => 'required|string|max:255',
            'used_parts.*.buying_price' => 'required|numeric|min:0',
            'used_parts.*.quantity' => 'required|integer|min:1',
        ]);

        try {
            DB::transaction(function () use ($request) {
                // Find or create customer
                $phone = trim($request->input('customer_phone'));
                $customer = Customer::where('phone', $phone)->first();
                if (!$customer) {
                    $customer = Customer::create([
                        'name' => $request->input('customer_name'),
                        'phone' => $phone,
                        'address' => $request->input('customer_address'),
                    ]);
                } else {
                    $customer->update([
                        'name' => $request->input('customer_name'),
                        'address' => $request->input('customer_address') ?? $customer->address,
                    ]);
                }

                // Generate unique Ticket ID
                do {
                    $ticketId = 'M3-' . date('Ym') . '-' . strtoupper(Str::random(4));
                } while (Repair::where('ticket_id', $ticketId)->exists());

                $status = $request->input('status');
                $repairCharge = floatval($request->input('repair_charge', 0));
                $advancePayment = floatval($request->input('advance_payment', 0));

                // Calculate parts cost to subtract from commission base
                $usedParts = $request->input('used_parts', []);
                $totalPartsCost = 0;
                if (is_array($usedParts)) {
                    foreach ($usedParts as $part) {
                        $totalPartsCost += floatval($part['buying_price'] ?? 0) * intval($part['quantity'] ?? 1);
                    }
                }

                // Estimated Cost = Service Fee / Charge + Total Parts Cost
                $estimatedCost = $repairCharge + $totalPartsCost;

                $actualCost = null;
                if (in_array($status, ['completed', 'delivered'])) {
                    $actualCost = $estimatedCost;
                }

                // Calculate technician commission based on service fee (total bill excluding parts cost)
                $commType = $request->input('commission_type');
                $commRate = floatval($request->input('commission_rate', 0));
                $commAmount = 0.00;
                if ($commType === 'flat') {
                    $commAmount = $commRate;
                } elseif ($commType === 'percentage') {
                    $baseCost = ($actualCost !== null) ? ($actualCost - $totalPartsCost) : $repairCharge;
                    if ($baseCost < 0) {
                        $baseCost = 0;
                    }
                    $commAmount = $baseCost * ($commRate / 100);
                }

                // Handle device photos upload
                $photoPaths = [];
                if ($request->hasFile('device_photos')) {
                    foreach ($request->file('device_photos') as $file) {
                        $photoPaths[] = Helpers::compressAndStoreImage($file, 'repairs');
                    }
                }

                // Warranty expiry calculation
                $warrantyDays = intval($request->input('warranty_days', 0));
                $warrantyExpiryDate = null;
                if ($warrantyDays > 0 && in_array($status, ['completed', 'delivered'])) {
                    $warrantyExpiryDate = now()->addDays($warrantyDays)->toDateString();
                }

                $repair = Repair::create([
                    'ticket_id' => $ticketId,
                    'customer_id' => $customer->id,
                    'device_brand' => $request->input('device_brand'),
                    'device_model' => $request->input('device_model'),
                    'serial_imei' => $request->input('serial_imei'),
                    'issue_description' => $request->input('issue_description'),
                    'password_pattern' => $request->input('password_pattern'),
                    'pattern_lock_path' => $request->input('pattern_lock_path'),
                    'data_loss_consent' => $request->has('data_loss_consent') ? 1 : 0,
                    'repair_charge' => $repairCharge,
                    'estimated_cost' => $estimatedCost,
                    'advance_payment' => $advancePayment,
                    'advance_payment_method' => $request->input('advance_payment_method'),
                    'actual_cost' => $actualCost,
                    'paid_amount' => $advancePayment,
                    'due_amount' => 0.00,
                    'status' => $status,
                    'assigned_technician_id' => $request->input('assigned_technician_id'),
                    'expected_delivery_date' => $request->input('expected_delivery_date'),
                    'technician_notes' => $request->input('technician_notes'),
                    'branch' => auth()->user()->branch,
                    'device_checklist' => $request->input('device_checklist'),
                    'device_photos' => $photoPaths,
                    'commission_type' => $commType,
                    'commission_rate' => $commRate,
                    'commission_amount' => $commAmount,
                    'used_parts' => $usedParts,
                    'warranty_days' => $warrantyDays,
                    'warranty_expiry_date' => $warrantyExpiryDate,
                ]);

                if ($advancePayment > 0) {
                    PaymentLog::create([
                        'payable_type' => 'App\\Models\\Repair',
                        'payable_id' => $repair->id,
                        'payment_method' => $request->input('advance_payment_method') ?? 'Cash',
                        'amount' => $advancePayment,
                        'transaction_reference' => $request->input('advance_payment_ref'),
                        'transaction_type' => 'initial',
                    ]);
                }

                // Sync stock deduction
                self::syncStockDeduction($repair, $status, $usedParts);
            });

            return redirect()->route('admin.repairs.index')->with('success', 'Job Card ticket created successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Failed to create repair ticket: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified repair ticket.
     */
    public function show($id)
    {
        $repair = Repair::with(['customer', 'technician'])->findOrFail($id);
        
        // Technicians can only view their assigned repairs
        if (auth()->user()->isTechnician() && $repair->assigned_technician_id !== auth()->id()) {
            abort(403, 'Unauthorized access to this repair job.');
        }

        return view('repairs.show', compact('repair'));
    }

    /**
     * Show the form for editing the specified repair ticket.
     */
    public function edit($id)
    {
        $repair = Repair::findOrFail($id);

        // Technicians can only edit their assigned repairs
        if (auth()->user()->isTechnician() && $repair->assigned_technician_id !== auth()->id()) {
            abort(403, 'Unauthorized access to this repair job.');
        }

        $customers = Customer::orderBy('name', 'asc')->get();
        $technicians = User::where('role', 'technician')->orderBy('name', 'asc')->get();
        $inventoryItems = \App\Models\InventoryItem::orderBy('name', 'asc')->get();
        
        return view('repairs.edit', compact('repair', 'customers', 'technicians', 'inventoryItems'));
    }

    /**
     * Update the specified repair ticket in storage.
     */
    public function update(Request $request, $id)
    {
        $repair = Repair::findOrFail($id);

        // Technicians can only update their assigned repairs
        if (auth()->user()->isTechnician() && $repair->assigned_technician_id !== auth()->id()) {
            abort(403, 'Unauthorized access to this repair job.');
        }

        // Technicians are only allowed to update status, notes, and used parts
        if (auth()->user()->isTechnician()) {
            $request->validate([
                'status' => 'required|string|in:pending,diagnosing,waiting_for_approval,repairing,quality_check,completed,delivered,cancelled',
                'technician_notes' => 'nullable|string',
                'used_parts' => 'nullable|array',
                'used_parts.*.name' => 'required|string|max:255',
                'used_parts.*.buying_price' => 'required|numeric|min:0',
                'used_parts.*.quantity' => 'required|integer|min:1',
            ]);
        } else {
            // Admin can edit everything
            $request->validate([
                'customer_id' => 'required|exists:customers,id',
                'device_brand' => 'required|string|max:100',
                'device_model' => 'required|string|max:100',
                'serial_imei' => 'nullable|string|max:100',
                'issue_description' => 'required|string',
                'password_pattern' => 'nullable|string|max:255',
                'repair_charge' => 'required|numeric|min:0',
                'estimated_cost' => 'nullable|numeric|min:0',
                'advance_payment' => 'nullable|numeric|min:0',
                'advance_payment_method' => 'nullable|string|in:Cash,bKash,Nagad,Rocket',
                'advance_payment_ref' => 'nullable|string',
                'actual_cost' => 'nullable|numeric|min:0',
                'payment_method' => 'nullable|string|in:Cash,bKash,Nagad,Rocket',
                'delivery_payment' => 'nullable|numeric|min:0',
                'cash_delivery' => 'nullable|numeric|min:0',
                'bkash_delivery' => 'nullable|numeric|min:0',
                'nagad_delivery' => 'nullable|numeric|min:0',
                'rocket_delivery' => 'nullable|numeric|min:0',
                'cash_delivery_ref' => 'nullable|string',
                'bkash_delivery_ref' => 'nullable|string',
                'nagad_delivery_ref' => 'nullable|string',
                'rocket_delivery_ref' => 'nullable|string',
                'cash_received' => 'nullable|numeric|min:0',
                'change_returned' => 'nullable|numeric|min:0',
                'status' => 'required|string|in:pending,diagnosing,waiting_for_approval,repairing,quality_check,completed,delivered,cancelled',
                'assigned_technician_id' => 'nullable|exists:users,id',
                'expected_delivery_date' => 'nullable|date',
                'technician_notes' => 'nullable|string',
                'device_checklist' => 'nullable|array',
                'device_photos.*' => 'image|max:20480',
                'commission_type' => 'nullable|string|in:flat,percentage',
                'commission_rate' => 'nullable|numeric|min:0',
                'used_parts' => 'nullable|array',
                'warranty_days' => 'nullable|integer|min:0',
                'pattern_lock_path' => 'nullable|string',
                'data_loss_consent' => 'nullable',
                'used_parts.*.name' => 'required|string|max:255',
                'used_parts.*.buying_price' => 'required|numeric|min:0',
                'used_parts.*.quantity' => 'required|integer|min:1',
            ]);
        }

        try {
            DB::transaction(function () use ($request, $repair) {
                $status = $request->input('status');

                if (auth()->user()->isTechnician()) {
                    $actualCost = $repair->actual_cost;

                    // Calculate parts cost to subtract from commission base
                    $usedParts = $request->input('used_parts', []);
                    $totalPartsCost = 0;
                    if (is_array($usedParts)) {
                        foreach ($usedParts as $part) {
                            $totalPartsCost += floatval($part['buying_price'] ?? 0) * intval($part['quantity'] ?? 1);
                        }
                    }

                    $estimatedCost = floatval($repair->repair_charge) + $totalPartsCost;
                    if (in_array($status, ['completed', 'delivered']) && $actualCost === null) {
                        $actualCost = $estimatedCost;
                    }

                    $baseCost = floatval($actualCost ?? $estimatedCost) - $totalPartsCost;
                    if ($baseCost < 0) {
                        $baseCost = 0;
                    }

                    $commAmount = 0.00;
                    if ($repair->commission_type === 'flat') {
                        $commAmount = $repair->commission_rate;
                    } elseif ($repair->commission_type === 'percentage') {
                        $commAmount = $baseCost * (floatval($repair->commission_rate) / 100);
                    }

                    $warrantyExpiryDate = $repair->warranty_expiry_date;
                    if (intval($repair->warranty_days) > 0 && in_array($status, ['completed', 'delivered']) && !$warrantyExpiryDate) {
                        $warrantyExpiryDate = now()->addDays(intval($repair->warranty_days))->toDateString();
                    }

                    self::syncStockDeduction($repair, $status, $usedParts);

                    $repair->update([
                        'status' => $status,
                        'technician_notes' => $request->input('technician_notes'),
                        'actual_cost' => $actualCost,
                        'estimated_cost' => $estimatedCost,
                        'commission_amount' => $commAmount,
                        'used_parts' => $usedParts,
                        'warranty_expiry_date' => $warrantyExpiryDate,
                    ]);
                } else {
                    $repairCharge = floatval($request->input('repair_charge', 0));
                    $advancePayment = floatval($request->input('advance_payment', 0));

                    // Calculate parts cost to subtract from commission base
                    $usedParts = $request->input('used_parts', []);
                    $totalPartsCost = 0;
                    if (is_array($usedParts)) {
                        foreach ($usedParts as $part) {
                            $totalPartsCost += floatval($part['buying_price'] ?? 0) * intval($part['quantity'] ?? 1);
                        }
                    }

                    // Estimated Cost = Service Fee / Charge + Total Parts Cost
                    $estimatedCost = $repairCharge + $totalPartsCost;

                    // Use filled() to correctly catch both null AND empty string ""
                    $actualCost = $request->filled('actual_cost') ? floatval($request->input('actual_cost')) : null;
                    if (in_array($status, ['completed', 'delivered']) && $actualCost === null) {
                        $actualCost = $estimatedCost;
                    }

                    // Calculate technician commission based on service fee (total bill excluding parts cost)
                    $commType = $request->input('commission_type');
                    $commRate = floatval($request->input('commission_rate', 0));
                    $commAmount = 0.00;
                    if ($commType === 'flat') {
                        $commAmount = $commRate;
                    } elseif ($commType === 'percentage') {
                        $baseCost = ($actualCost !== null) ? ($actualCost - $totalPartsCost) : $repairCharge;
                        if ($baseCost < 0) {
                            $baseCost = 0;
                        }
                        $commAmount = floatval($baseCost) * ($commRate / 100);
                    }

                    // Handle device photos upload (merge with existing)
                    $photoPaths = $repair->device_photos ?? [];
                    if ($request->hasFile('device_photos')) {
                        foreach ($request->file('device_photos') as $file) {
                            $photoPaths[] = Helpers::compressAndStoreImage($file, 'repairs');
                        }
                    }

                    // Warranty expiry calculation
                    $warrantyDays = intval($request->input('warranty_days', 0));
                    $warrantyExpiryDate = $repair->warranty_expiry_date;
                    if ($warrantyDays > 0 && in_array($status, ['completed', 'delivered'])) {
                        if (!$warrantyExpiryDate || $warrantyDays != $repair->warranty_days || $status != $repair->status) {
                            $warrantyExpiryDate = now()->addDays($warrantyDays)->toDateString();
                        }
                    } elseif ($warrantyDays <= 0) {
                        $warrantyExpiryDate = null;
                    }

                    self::syncStockDeduction($repair, $status, $usedParts);

                    // Set completed_at only when status first transitions to completed/delivered
                    // Never overwrite it on subsequent edits to preserve the original payment date
                    $completedAt = $repair->completed_at;
                    if (in_array($status, ['completed', 'delivered']) && $completedAt === null) {
                        $completedAt = now();
                    } elseif (!in_array($status, ['completed', 'delivered'])) {
                        $completedAt = null; // Reset if reverted to non-complete status
                    }

                    // Calculate paid and due amounts
                    $cashDelivery = floatval($request->input('cash_delivery', 0));
                    $bkashDelivery = floatval($request->input('bkash_delivery', 0));
                    $nagadDelivery = floatval($request->input('nagad_delivery', 0));
                    $rocketDelivery = floatval($request->input('rocket_delivery', 0));

                    if (in_array($status, ['completed', 'delivered'])) {
                        $remaining = max(0, floatval($actualCost) - $advancePayment);
                        if ($cashDelivery == 0 && $bkashDelivery == 0 && $nagadDelivery == 0 && $rocketDelivery == 0) {
                            $cashDelivery = $request->filled('delivery_payment') ? floatval($request->input('delivery_payment')) : $remaining;
                        }
                    }
                    $deliveryPayment = $cashDelivery + $bkashDelivery + $nagadDelivery + $rocketDelivery;

                    $payMethod = 'Cash';
                    $maxAmt = -1;
                    $deliveryMethods = [
                        'Cash' => $cashDelivery,
                        'bKash' => $bkashDelivery,
                        'Nagad' => $nagadDelivery,
                        'Rocket' => $rocketDelivery,
                    ];
                    foreach ($deliveryMethods as $method => $amt) {
                        if ($amt > $maxAmt) {
                            $maxAmt = $amt;
                            $payMethod = $method;
                        }
                    }

                    $paidAmount = $advancePayment + $deliveryPayment;
                    $dueAmount = in_array($status, ['completed', 'delivered']) ? max(0, floatval($actualCost) - $paidAmount) : 0.00;

                    $cashReceived = $request->input('cash_received') !== null ? floatval($request->input('cash_received')) : null;
                    if ($cashReceived === null && $cashDelivery > 0) {
                        $cashReceived = $cashDelivery;
                    }

                    $repair->update([
                        'customer_id' => $request->input('customer_id'),
                        'device_brand' => $request->input('device_brand'),
                        'device_model' => $request->input('device_model'),
                        'serial_imei' => $request->input('serial_imei'),
                        'issue_description' => $request->input('issue_description'),
                        'password_pattern' => $request->input('password_pattern'),
                        'pattern_lock_path' => $request->input('pattern_lock_path'),
                        'data_loss_consent' => $request->has('data_loss_consent') ? 1 : 0,
                        'repair_charge' => $repairCharge,
                        'estimated_cost' => $estimatedCost,
                        'advance_payment' => $advancePayment,
                        'advance_payment_method' => $request->input('advance_payment_method'),
                        'actual_cost' => $actualCost,
                        'payment_method' => $payMethod,
                        'cash_received' => $cashReceived,
                        'change_returned' => $request->input('change_returned') !== null ? floatval($request->input('change_returned')) : null,
                        'status' => $status,
                        'assigned_technician_id' => $request->input('assigned_technician_id'),
                        'expected_delivery_date' => $request->input('expected_delivery_date'),
                        'technician_notes' => $request->input('technician_notes'),
                        'device_checklist' => $request->input('device_checklist'),
                        'device_photos' => $photoPaths,
                        'commission_type' => $commType,
                        'commission_rate' => $commRate,
                        'commission_amount' => $commAmount,
                        'used_parts' => $usedParts,
                        'warranty_days'         => $warrantyDays,
                        'warranty_expiry_date'  => $warrantyExpiryDate,
                        'completed_at'          => $completedAt,
                        'paid_amount'           => $paidAmount,
                        'due_amount'            => $dueAmount,
                    ]);

                    // Sync Payment Logs for Advance Payment
                    PaymentLog::where('payable_type', 'App\\Models\\Repair')->where('payable_id', $repair->id)->where('transaction_type', 'initial')->delete();
                    if ($advancePayment > 0) {
                        PaymentLog::create([
                            'payable_type' => 'App\\Models\\Repair',
                            'payable_id' => $repair->id,
                            'payment_method' => $request->input('advance_payment_method') ?? 'Cash',
                            'amount' => $advancePayment,
                            'transaction_reference' => $request->input('advance_payment_ref'),
                            'transaction_type' => 'initial',
                        ]);
                    }

                    // Sync Payment Logs for Delivery Payment
                    PaymentLog::where('payable_type', 'App\\Models\\Repair')->where('payable_id', $repair->id)->where('transaction_type', 'delivery')->delete();
                    foreach ($deliveryMethods as $method => $amt) {
                        if ($amt > 0) {
                            $refKey = strtolower($method) . '_delivery_ref';
                            $refVal = $request->input($refKey);

                            PaymentLog::create([
                                'payable_type' => 'App\\Models\\Repair',
                                'payable_id' => $repair->id,
                                'payment_method' => $method,
                                'amount' => $amt,
                                'transaction_reference' => $refVal,
                                'transaction_type' => 'delivery',
                            ]);
                        }
                    }
                }
            });

            return redirect()->route('admin.repairs.show', $repair->id)->with('success', 'Repair ticket updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Failed to update repair ticket: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified repair ticket from storage.
     */
    public function destroy($id)
    {
        $repair = Repair::findOrFail($id);

        try {
            DB::transaction(function () use ($repair) {
                // Reverse stock deductions before deleting to prevent permanent inventory leak
                if ($repair->is_stock_deducted) {
                    $oldUsedParts = $repair->used_parts ?? [];
                    foreach ($oldUsedParts as $part) {
                        $inventoryId = $part['inventory_id'] ?? null;
                        $qty = intval($part['quantity'] ?? 1);
                        if ($inventoryId) {
                            $item = InventoryItem::where('id', $inventoryId)->lockForUpdate()->first();
                            if ($item) {
                                $item->increment('quantity', $qty);
                            }
                        }
                    }
                }

                $repair->delete();
            });

            return redirect()->route('admin.repairs.index')->with('success', 'Repair ticket deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete repair ticket: ' . $e->getMessage());
        }
    }

    /**
     * Print the repair job card slip.
     */
    public function printSlip($id)
    {
        $repair = Repair::findOrFail($id);

        // Technicians can only print their assigned repairs
        if (auth()->user()->isTechnician() && $repair->assigned_technician_id !== auth()->id()) {
            abort(403, 'Unauthorized access to this repair job.');
        }

        return view('repairs.print-slip', compact('repair'));
    }

    /**
     * Sync inventory spare parts stock quantities when repair status/parts list changes.
     */
    protected static function syncStockDeduction(Repair $repair, string $newStatus, array $newUsedParts): void
    {
        $workStatuses = ['repairing', 'quality_check', 'completed', 'delivered'];
        $oldUsedParts = $repair->used_parts ?? [];
        $isOldDeducted = (bool) $repair->is_stock_deducted;

        // Determine if target status requires stock deduction
        $shouldBeDeducted = in_array($newStatus, $workStatuses);

        // If it was already deducted, reverse old deductions first to handle parts list edits
        if ($isOldDeducted) {
            foreach ($oldUsedParts as $part) {
                $inventoryId = $part['inventory_id'] ?? null;
                $qty = intval($part['quantity'] ?? 1);
                if ($inventoryId) {
                    $item = InventoryItem::where('id', $inventoryId)->lockForUpdate()->first();
                    if ($item) {
                        $item->increment('quantity', $qty);
                    }
                }
            }
            $repair->is_stock_deducted = false;
            $repair->save();
        }

        // Apply new deductions if needed
        if ($shouldBeDeducted) {
            foreach ($newUsedParts as $part) {
                $inventoryId = $part['inventory_id'] ?? null;
                $qty = intval($part['quantity'] ?? 1);
                if ($inventoryId) {
                    $item = InventoryItem::where('id', $inventoryId)->lockForUpdate()->first();
                    if (!$item) {
                        throw new \Exception("Inventory item with ID '{$inventoryId}' not found.");
                    }
                    if ($item->quantity < $qty) {
                        throw new \Exception("Insufficient stock for item: {$item->name}. Only {$item->quantity} left.");
                    }
                    $item->decrement('quantity', $qty);
                }
            }
            $repair->is_stock_deducted = true;
            $repair->save();
        }
    }

    /**
     * Record a customer due payment for a repair.
     */
    public function payDue(Request $request, $id)
    {
        $repair = Repair::findOrFail($id);

        $request->validate([
            'amount_paid' => 'required|numeric|min:0.01|max:' . $repair->due_amount,
            'payment_method' => 'required|string|in:Cash,bKash,Nagad,Rocket',
            'transaction_reference' => 'nullable|string',
        ]);

        $amountPaid = floatval($request->input('amount_paid'));
        $paymentMethod = $request->input('payment_method');
        $txnRef = $request->input('transaction_reference');

        try {
            DB::transaction(function () use ($repair, $amountPaid, $paymentMethod, $txnRef) {
                $repair->paid_amount += $amountPaid;
                $repair->due_amount = max(0, $repair->due_amount - $amountPaid);
                $repair->save();

                PaymentLog::create([
                    'payable_type' => 'App\\Models\\Repair',
                    'payable_id' => $repair->id,
                    'payment_method' => $paymentMethod,
                    'amount' => $amountPaid,
                    'transaction_reference' => $txnRef,
                    'transaction_type' => 'due_payment',
                ]);
            });

            return redirect()->back()->with('success', 'Due payment of ' . number_format($amountPaid, 2) . ' BDT recorded successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to process due payment: ' . $e->getMessage());
        }
    }
}
