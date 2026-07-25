<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\PaymentLog;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display Online Orders List.
     */
    public function index(Request $request)
    {
        $query = Sale::with(['customer', 'details.item']);

        if ($request->filled('search')) {
            $search = trim($request->input('search'));
            $query->where(function ($q) use ($search) {
                $q->where('invoice_no', 'like', "%{$search}%")
                  ->orWhereHas('customer', function ($cq) use ($search) {
                      $cq->where('name', 'like', "%{$search}%")
                         ->orWhere('phone', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $orders = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();

        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Display Order Details / Invoice.
     */
    public function show($id)
    {
        $order = Sale::with(['customer', 'details.item', 'salesman'])->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Update Order Delivery / Fulfillment Status & Financial Accounting.
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string|in:Pending,Processing,Delivered,Cancelled',
        ]);

        $order = Sale::findOrFail($id);
        $newStatus = $request->input('status');
        $order->status = $newStatus;

        if ($newStatus === 'Delivered' || $newStatus === 'Processing' || $newStatus === 'Pending') {
            $order->paid_amount = $order->payable_amount;
            $order->due_amount = 0;

            // Ensure PaymentLog exists for cash flow ledger
            $logExists = PaymentLog::where('payable_type', 'App\\Models\\Sale')
                ->where('payable_id', $order->id)
                ->exists();

            if (!$logExists) {
                PaymentLog::create([
                    'payable_type' => 'App\\Models\\Sale',
                    'payable_id' => $order->id,
                    'payment_method' => $order->payment_method ?? 'COD',
                    'amount' => $order->payable_amount,
                    'transaction_type' => 'online_order_income',
                ]);
            }
        } elseif ($newStatus === 'Cancelled') {
            $order->paid_amount = 0;
            $order->due_amount = $order->payable_amount;
            
            PaymentLog::where('payable_type', 'App\\Models\\Sale')
                ->where('payable_id', $order->id)
                ->delete();
        }

        $order->save();

        return redirect()->back()->with('success', "Order #{$order->invoice_no} status updated to {$order->status} and financial accounts synced.");
    }
}
