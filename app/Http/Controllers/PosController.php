<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\InventoryItem;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\PaymentLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PosController extends Controller
{
    /**
     * Display the POS screen.
     */
    public function index()
    {
        $customers = Customer::orderBy('name', 'asc')->get();
        // Load items with stock > 0
        $query = InventoryItem::where('quantity', '>', 0);
        if (!auth()->user()->isSuperAdmin() && !auth()->user()->isAdmin()) {
            $query->where(function($q) {
                $q->whereNull('branch')->orWhere('branch', auth()->user()->branch);
            });
        }
        $items = $query->orderBy('name', 'asc')->get();
        return view('pos.index', compact('customers', 'items'));
    }

    /**
     * Search product for POS (supports scan barcode or search query).
     */
    public function searchProduct(Request $request)
    {
        $search = trim($request->input('q'));
        
        if (blank($search)) {
            return response()->json([]);
        }

        $query = InventoryItem::where('quantity', '>', 0);
        if (!auth()->user()->isSuperAdmin() && !auth()->user()->isAdmin()) {
            $query->where(function($q) {
                $q->whereNull('branch')->orWhere('branch', auth()->user()->branch);
            });
        }
        
        $items = $query->where(function($q) use ($search) {
                $q->where('barcode', $search)
                  ->orWhere('sku', $search)
                  ->orWhere('name', 'like', "%{$search}%");
            })
            ->limit(10)
            ->get();

        return response()->json($items);
    }

    /**
     * Handle POS checkout with Minimum Price Rate Protection.
     */
    public function checkout(Request $request)
    {
        $request->validate([
            'customer_id' => 'nullable|exists:customers,id',
            'discount' => 'required|numeric|min:0',
            'cash_amount' => 'nullable|numeric|min:0',
            'bkash_amount' => 'nullable|numeric|min:0',
            'nagad_amount' => 'nullable|numeric|min:0',
            'rocket_amount' => 'nullable|numeric|min:0',
            'paid_amount' => 'nullable|numeric|min:0',
            'payment_method' => 'nullable|string',
            'cash_received' => 'nullable|numeric|min:0',
            'change_returned' => 'nullable|numeric|min:0',
            'cart' => 'required|array',
            'cart.*.id' => 'required|exists:inventory_items,id',
            'cart.*.qty' => 'required|integer|min:1',
            'cart.*.price' => 'nullable|numeric|min:0',
        ]);

        $cart = $request->input('cart');
        $discount = floatval($request->input('discount', 0));
        
        $cashAmount = floatval($request->input('cash_amount', 0));
        $bkashAmount = floatval($request->input('bkash_amount', 0));
        $nagadAmount = floatval($request->input('nagad_amount', 0));
        $rocketAmount = floatval($request->input('rocket_amount', 0));

        // Legacy compatibility fallback
        if ($cashAmount == 0 && $bkashAmount == 0 && $nagadAmount == 0 && $rocketAmount == 0) {
            $legacyPaid = floatval($request->input('paid_amount', 0));
            $legacyMethod = $request->input('payment_method', 'Cash');
            if ($legacyPaid > 0) {
                if ($legacyMethod === 'Cash') {
                    $cashAmount = $legacyPaid;
                } elseif ($legacyMethod === 'bKash') {
                    $bkashAmount = $legacyPaid;
                } elseif ($legacyMethod === 'Nagad') {
                    $nagadAmount = $legacyPaid;
                } elseif ($legacyMethod === 'Rocket') {
                    $rocketAmount = $legacyPaid;
                }
            }
        }

        $paidAmount = $cashAmount + $bkashAmount + $nagadAmount + $rocketAmount;

        $paymentMethod = 'Cash';
        $maxAmt = -1;
        $methods = [
            'Cash' => $cashAmount,
            'bKash' => $bkashAmount,
            'Nagad' => $nagadAmount,
            'Rocket' => $rocketAmount,
        ];
        foreach ($methods as $method => $amt) {
            if ($amt > $maxAmt) {
                $maxAmt = $amt;
                $paymentMethod = $method;
            }
        }

        // Run transaction
        try {
            $sale = DB::transaction(function () use ($request, $cart, $discount, $paidAmount, $paymentMethod, $methods) {
                $totalAmount = 0;
                $totalMinAllowed = 0;
                $lockedItems = [];

                foreach ($cart as $cartItem) {
                    $item = InventoryItem::where('id', $cartItem['id'])->lockForUpdate()->firstOrFail();
                    if ($item->quantity < $cartItem['qty']) {
                        throw new \Exception("Insufficient stock for item: {$item->name}. Only {$item->quantity} left.");
                    }

                    // Get custom price or fallback to item sale price
                    $unitPrice = isset($cartItem['price']) && floatval($cartItem['price']) > 0
                        ? floatval($cartItem['price'])
                        : floatval($item->sale_price);

                    // Get effective minimum allowed selling price
                    $minPrice = $item->effective_min_price;

                    if ($unitPrice < $minPrice) {
                        throw new \Exception("Unit price for '{$item->name}' cannot be less than minimum rate of " . number_format($minPrice, 2) . " BDT.");
                    }

                    $itemTotal = $unitPrice * $cartItem['qty'];
                    $totalAmount += $itemTotal;
                    $totalMinAllowed += ($minPrice * $cartItem['qty']);

                    $lockedItems[] = [
                        'item' => $item,
                        'qty' => $cartItem['qty'],
                        'unit_price' => $unitPrice,
                    ];
                }

                $payableAmount = max(0, $totalAmount - $discount);

                // Enforce overall minimum price rate protection against discount abuse
                if ($payableAmount < $totalMinAllowed) {
                    throw new \Exception("Discount applied exceeds allowed limit! Total bill cannot be less than minimum rate total of " . number_format($totalMinAllowed, 2) . " BDT.");
                }

                $dueAmount = max(0, $payableAmount - $paidAmount);

                if ($dueAmount > 0 && is_null($request->input('customer_id'))) {
                    throw new \Exception("A registered customer is required to record a remaining due balance.");
                }

                // Generate invoice number
                do {
                    $invoiceNo = 'INV-' . date('Ymd') . '-' . strtoupper(Str::random(4));
                } while (Sale::where('invoice_no', $invoiceNo)->exists());

                $cashReceived = floatval($request->input('cash_received', 0));
                if ($cashReceived <= 0) {
                    $cashReceived = floatval($methods['Cash']);
                }
                $changeReturned = floatval($request->input('change_returned', 0));

                $sale = Sale::create([
                    'invoice_no'       => $invoiceNo,
                    'customer_id'      => $request->input('customer_id'),
                    'total_amount'     => $totalAmount,
                    'discount'         => $discount,
                    'payable_amount'   => $payableAmount,
                    'paid_amount'      => $paidAmount,
                    'due_amount'       => $dueAmount,
                    'cash_received'    => $cashReceived,
                    'change_returned'  => $changeReturned,
                    'payment_method'   => $paymentMethod,
                    'salesman_id'      => auth()->id(),
                    'branch'           => auth()->user()->branch,
                ]);

                // Create payment logs for non-zero amounts
                foreach ($methods as $method => $amt) {
                    if ($amt > 0) {
                        $refKey = strtolower($method) . '_ref';
                        $refVal = $request->input($refKey);

                        PaymentLog::create([
                            'payable_type' => 'App\\Models\\Sale',
                            'payable_id' => $sale->id,
                            'payment_method' => $method,
                            'amount' => $amt,
                            'transaction_reference' => $refVal,
                            'transaction_type' => 'initial',
                        ]);
                    }
                }

                foreach ($lockedItems as $locked) {
                    $item = $locked['item'];
                    $qty = $locked['qty'];
                    $unitPrice = $locked['unit_price'];

                    // Record Sale Detail with custom unit price & purchase_price snapshot for COGS
                    SaleDetail::create([
                        'sale_id'           => $sale->id,
                        'inventory_item_id' => $item->id,
                        'quantity'          => $qty,
                        'sale_price'        => $unitPrice,
                        'purchase_price'    => $item->purchase_price ?? 0,
                    ]);

                    // Decrement quantity
                    $item->decrement('quantity', $qty);
                }

                return $sale;
            });

            return response()->json([
                'success' => true,
                'sale_id' => $sale->id,
                'message' => 'Sale checkout processed successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }

    /**
     * Display printable invoice.
     */
    public function invoice($id)
    {
        $sale = Sale::with(['customer', 'salesman', 'details.item'])->findOrFail($id);
        return view('pos.invoice', compact('sale'));
    }

    /**
     * Record a customer due payment for a sale.
     */
    public function payDue(Request $request, $id)
    {
        $sale = Sale::findOrFail($id);

        $request->validate([
            'amount_paid' => 'required|numeric|min:0.01|max:' . $sale->due_amount,
            'payment_method' => 'required|string|in:Cash,bKash,Nagad,Rocket',
            'transaction_reference' => 'nullable|string',
        ]);

        $amountPaid = floatval($request->input('amount_paid'));
        $paymentMethod = $request->input('payment_method');
        $txnRef = $request->input('transaction_reference');

        try {
            DB::transaction(function () use ($sale, $amountPaid, $paymentMethod, $txnRef) {
                $sale->paid_amount += $amountPaid;
                $sale->due_amount = max(0, $sale->due_amount - $amountPaid);
                if ($paymentMethod === 'Cash') {
                    $sale->cash_received = ($sale->cash_received ?? 0) + $amountPaid;
                }
                $sale->save();

                PaymentLog::create([
                    'payable_type' => 'App\\Models\\Sale',
                    'payable_id' => $sale->id,
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
