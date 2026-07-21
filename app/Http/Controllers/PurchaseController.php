<?php

namespace App\Http\Controllers;

use App\Models\InventoryItem;
use App\Models\Purchase;
use App\Models\PurchaseDetail;
use App\Models\Supplier;
use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PurchaseController extends Controller
{
    /**
     * Display listing of purchases & suppliers.
     */
    public function index()
    {
        $purchases = Purchase::with(['supplier', 'details.item'])
            ->orderBy('created_at', 'desc')
            ->get();
            
        $suppliers = Supplier::orderBy('name', 'asc')->get();
        
        // Load all items to restock
        $items = InventoryItem::orderBy('name', 'asc')->get();

        return view('purchases.index', compact('purchases', 'suppliers', 'items'));
    }

    /**
     * Store new stock-in purchase.
     */
    public function store(Request $request)
    {
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'purchase_date' => 'required|date',
            'items' => 'required|array',
            'items.*.inventory_item_id' => 'required|exists:inventory_items,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.cost_price' => 'required|numeric|min:0',
        ]);

        $items = $request->input('items');
        $totalAmount = 0;

        foreach ($items as $detail) {
            $totalAmount += $detail['cost_price'] * $detail['quantity'];
        }

        DB::transaction(function () use ($request, $items, $totalAmount) {
            // Generate purchase number
            do {
                $purchaseNo = 'PUR-' . date('Ymd') . '-' . strtoupper(Str::random(4));
            } while (Purchase::where('purchase_no', $purchaseNo)->exists());

            // Save purchase
            $purchase = Purchase::create([
                'purchase_no' => $purchaseNo,
                'supplier_id' => $request->input('supplier_id'),
                'total_amount' => $totalAmount,
                'purchase_date' => $request->input('purchase_date'),
            ]);

            foreach ($items as $detail) {
                // Record detail
                PurchaseDetail::create([
                    'purchase_id' => $purchase->id,
                    'inventory_item_id' => $detail['inventory_item_id'],
                    'quantity' => $detail['quantity'],
                    'cost_price' => $detail['cost_price'],
                ]);

                // Increment inventory stock
                $item = InventoryItem::findOrFail($detail['inventory_item_id']);
                $item->increment('quantity', $detail['quantity']);
                
                // Update purchase price in item catalog
                $item->update([
                    'purchase_price' => $detail['cost_price']
                ]);
            }

            // Automatically record as an expense
            Expense::create([
                'category' => 'Purchase',
                'amount' => $totalAmount,
                'description' => "Stock-In purchase ledger entry: {$purchaseNo}",
                'expense_date' => $request->input('purchase_date'),
            ]);
        });

        return redirect()->route('admin.purchases.index')->with('success', 'Stock-In purchase logged and quantities updated successfully!');
    }

    /**
     * Store a new supplier profile.
     */
    public function storeSupplier(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'nullable|string',
        ]);

        Supplier::create($request->all());

        return redirect()->route('admin.purchases.index')->with('success', 'Supplier profile registered successfully!');
    }
}
