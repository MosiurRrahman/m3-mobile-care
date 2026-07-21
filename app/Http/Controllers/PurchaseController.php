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
     * Update an existing purchase.
     */
    public function update(Request $request, $id)
    {
        $purchase = Purchase::with('details')->findOrFail($id);

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

        DB::transaction(function () use ($purchase, $request, $items, $totalAmount) {
            // 1. Revert previous inventory quantities
            foreach ($purchase->details as $oldDetail) {
                $item = InventoryItem::find($oldDetail->inventory_item_id);
                if ($item) {
                    $item->decrement('quantity', min($item->quantity, $oldDetail->quantity));
                }
            }

            // 2. Delete old details
            $purchase->details()->delete();

            // 3. Update main purchase record
            $purchase->update([
                'supplier_id' => $request->input('supplier_id'),
                'total_amount' => $totalAmount,
                'purchase_date' => $request->input('purchase_date'),
            ]);

            // 4. Create new details & add quantities
            foreach ($items as $detail) {
                PurchaseDetail::create([
                    'purchase_id' => $purchase->id,
                    'inventory_item_id' => $detail['inventory_item_id'],
                    'quantity' => $detail['quantity'],
                    'cost_price' => $detail['cost_price'],
                ]);

                $item = InventoryItem::findOrFail($detail['inventory_item_id']);
                $item->increment('quantity', $detail['quantity']);
                $item->update([
                    'purchase_price' => $detail['cost_price']
                ]);
            }

            // 5. Update or create expense log
            $expense = Expense::where('description', 'like', "%{$purchase->purchase_no}%")->first();
            if ($expense) {
                $expense->update([
                    'amount' => $totalAmount,
                    'expense_date' => $request->input('purchase_date'),
                ]);
            } else {
                Expense::create([
                    'category' => 'Purchase',
                    'amount' => $totalAmount,
                    'description' => "Stock-In purchase ledger entry: {$purchase->purchase_no}",
                    'expense_date' => $request->input('purchase_date'),
                ]);
            }
        });

        return redirect()->route('admin.purchases.index')->with('success', 'Purchase record updated successfully!');
    }

    /**
     * Delete a purchase.
     */
    public function destroy($id)
    {
        $purchase = Purchase::with('details')->findOrFail($id);

        DB::transaction(function () use ($purchase) {
            // Revert stock quantities
            foreach ($purchase->details as $detail) {
                $item = InventoryItem::find($detail->inventory_item_id);
                if ($item) {
                    $item->decrement('quantity', min($item->quantity, $detail->quantity));
                }
            }

            // Delete expense entry
            Expense::where('description', 'like', "%{$purchase->purchase_no}%")->delete();

            // Delete purchase and details
            $purchase->details()->delete();
            $purchase->delete();
        });

        return redirect()->route('admin.purchases.index')->with('success', 'Purchase record deleted and stock quantities reverted!');
    }

    /**
     * Store a new supplier profile.
     */
    public function storeSupplier(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required',
            'address' => 'nullable|string',
        ]);

        $phoneInput = $request->input('phone');
        $phoneStr = is_array($phoneInput) 
            ? implode(', ', array_filter(array_map('trim', $phoneInput))) 
            : trim($phoneInput);

        Supplier::create([
            'name' => $request->input('name'),
            'phone' => $phoneStr,
            'address' => $request->input('address'),
        ]);

        return redirect()->route('admin.purchases.index')->with('success', 'Supplier profile registered successfully!');
    }

    /**
     * Update supplier profile.
     */
    public function updateSupplier(Request $request, $id)
    {
        $supplier = Supplier::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required',
            'address' => 'nullable|string',
        ]);

        $phoneInput = $request->input('phone');
        $phoneStr = is_array($phoneInput) 
            ? implode(', ', array_filter(array_map('trim', $phoneInput))) 
            : trim($phoneInput);

        $supplier->update([
            'name' => $request->input('name'),
            'phone' => $phoneStr,
            'address' => $request->input('address'),
        ]);

        return redirect()->route('admin.purchases.index')->with('success', 'Supplier profile updated successfully!');
    }

    /**
     * Delete supplier profile.
     */
    public function destroySupplier($id)
    {
        $supplier = Supplier::findOrFail($id);
        $supplier->delete();

        return redirect()->route('admin.purchases.index')->with('success', 'Supplier profile deleted successfully!');
    }
}
