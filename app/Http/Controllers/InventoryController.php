<?php

namespace App\Http\Controllers;

use App\Models\InventoryItem;
use App\Models\Category;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Helpers\Helpers;

class InventoryController extends Controller
{
    /**
     * Display Spare Parts catalog.
     */
    public function indexParts(Request $request)
    {
        $query = InventoryItem::where('type', 'spare_part')->with(['categoryRelation', 'supplier']);

        if (!auth()->user()->isSuperAdmin() && !auth()->user()->isAdmin()) {
            $query->where(function($q) {
                $q->whereNull('branch')->orWhere('branch', auth()->user()->branch);
            });
        }

        if ($request->filled('search')) {
            $search = trim($request->input('search'));
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%")
                  ->orWhere('brand', 'like', "%{$search}%")
                  ->orWhere('model', 'like', "%{$search}%")
                  ->orWhere('barcode', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->input('category_id'));
        }

        if ($request->filled('supplier_id')) {
            $query->where('supplier_id', $request->input('supplier_id'));
        }

        if ($request->filled('stock_status')) {
            $status = $request->input('stock_status');
            if ($status === 'out') {
                $query->where('quantity', '=', 0);
            } elseif ($status === 'low') {
                $query->whereColumn('quantity', '<=', 'alert_quantity')->where('quantity', '>', 0);
            } elseif ($status === 'in') {
                $query->where('quantity', '>', 0);
            }
        }

        $perPage = (int) $request->input('per_page', 10);
        $perPage = in_array($perPage, [10, 25, 50, 100]) ? $perPage : 10;

        $items = $query->orderBy('created_at', 'desc')->paginate($perPage)->withQueryString();
        
        $categories = Category::where('status', 'active')->orderBy('name', 'asc')->get();
        $suppliers = Supplier::orderBy('name', 'asc')->get();

        return view('inventory.parts', compact('items', 'categories', 'suppliers'));
    }

    /**
     * Display Accessories catalog.
     */
    public function indexAccessories(Request $request)
    {
        $query = InventoryItem::where('type', 'accessory')->with(['categoryRelation', 'supplier']);

        if (!auth()->user()->isSuperAdmin() && !auth()->user()->isAdmin()) {
            $query->where(function($q) {
                $q->whereNull('branch')->orWhere('branch', auth()->user()->branch);
            });
        }

        if ($request->filled('search')) {
            $search = trim($request->input('search'));
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%")
                  ->orWhere('brand', 'like', "%{$search}%")
                  ->orWhere('model', 'like', "%{$search}%")
                  ->orWhere('barcode', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->input('category_id'));
        }

        if ($request->filled('supplier_id')) {
            $query->where('supplier_id', $request->input('supplier_id'));
        }

        if ($request->filled('stock_status')) {
            $status = $request->input('stock_status');
            if ($status === 'out') {
                $query->where('quantity', '=', 0);
            } elseif ($status === 'low') {
                $query->whereColumn('quantity', '<=', 'alert_quantity')->where('quantity', '>', 0);
            } elseif ($status === 'in') {
                $query->where('quantity', '>', 0);
            }
        }

        $perPage = (int) $request->input('per_page', 10);
        $perPage = in_array($perPage, [10, 25, 50, 100]) ? $perPage : 10;

        $items = $query->orderBy('created_at', 'desc')->paginate($perPage)->withQueryString();

        $categories = Category::where('status', 'active')->orderBy('name', 'asc')->get();
        $suppliers = Supplier::orderBy('name', 'asc')->get();

        return view('inventory.accessories', compact('items', 'categories', 'suppliers'));
    }

    /**
     * Show form to create new inventory item.
     */
    public function create(Request $request)
    {
        $type = $request->query('type', 'accessory');
        $categories = Category::where('status', 'active')->orderBy('name', 'asc')->get();
        $suppliers = Supplier::orderBy('name', 'asc')->get();
        
        return view('inventory.create', compact('type', 'categories', 'suppliers'));
    }

    /**
     * Store a newly created item in inventory.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|in:spare_part,accessory',
            'category_id' => 'required|exists:categories,id',
            'sub_category' => 'nullable|string|max:255',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'brand' => 'nullable|string|max:255',
            'model' => 'nullable|string|max:255',
            'barcode' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'product_type' => 'required|string|in:single,variable',
            'warranties' => 'nullable|string|max:255',
            'manufacturer' => 'nullable|string|max:255',
            'expiry' => 'nullable|date',
            
            // Single Product pricing fields
            'quantity' => 'required_if:product_type,single|nullable|integer|min:0',
            'purchase_price' => 'required|numeric|min:0',
            'sale_price' => 'required_if:product_type,single|nullable|numeric|min:0',
            'discount_type' => 'nullable|string|in:flat,percentage',
            'discount_value' => 'nullable|numeric|min:0',
            'alert_quantity' => 'required|integer|min:0',

            // Multiple images upload
            'images.*' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:10240',

            // Variable Product variants definition
            'variants' => 'required_if:product_type,variable|nullable|array',
            'variants.*.variation' => 'required_with:variants|string|max:100',
            'variants.*.value' => 'required_with:variants|string|max:100',
            'variants.*.sku' => 'required_with:variants|string|max:100',
            'variants.*.quantity' => 'required_with:variants|integer|min:0',
            'variants.*.price' => 'required_with:variants|numeric|min:0',
        ]);

        $category = Category::findOrFail($request->input('category_id'));

        // Handle multiple images upload
        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $imageFile) {
                $imagePaths[] = Helpers::compressAndStoreImage($imageFile, 'inventory');
            }
        }

        // Handle pricing and stock logic based on single vs variable type
        $productType = $request->input('product_type');
        $quantity = 0;
        $salePrice = 0;
        $variantsData = null;

        if ($productType === 'single') {
            $quantity = $request->input('quantity', 0);
            $salePrice = $request->input('sale_price', 0);
        } else {
            $variants = $request->input('variants', []);
            $variantsData = $variants;
            foreach ($variants as $index => $variant) {
                $quantity += intval($variant['quantity']);
                if ($index === 0) {
                    $salePrice = floatval($variant['price']);
                }
            }
        }

        // Generate base SKU
        $prefix = $request->input('type') === 'spare_part' ? 'PART-' : 'ACCS-';
        $categoryCode = strtoupper(substr($category->name, 0, 4));
        do {
            $sku = $prefix . $categoryCode . '-' . strtoupper(Str::random(5));
        } while (InventoryItem::where('sku', $sku)->exists());

        InventoryItem::create([
            'name' => $request->input('name'),
            'sku' => $sku,
            'barcode' => $request->input('barcode'),
            'type' => $request->input('type'),
            'category' => $category->name,
            'category_id' => $category->id,
            'sub_category' => $request->input('sub_category'),
            'supplier_id' => $request->input('supplier_id'),
            'brand' => $request->input('brand'),
            'model' => $request->input('model'),
            'description' => $request->input('description'),
            'product_type' => $productType,
            'quantity' => $quantity,
            'alert_quantity' => $request->input('alert_quantity', 5),
            'purchase_price' => $request->input('purchase_price'),
            'sale_price' => $salePrice,
            'discount_type' => $request->input('discount_type'),
            'discount_value' => $request->input('discount_value', 0.00),
            'images' => $imagePaths,
            'warranties' => $request->input('warranties'),
            'manufacturer' => $request->input('manufacturer'),
            'expiry' => $request->input('expiry'),
            'variants' => $variantsData,
            'branch' => auth()->user()->branch,
        ]);

        $route = $request->input('type') === 'spare_part' ? 'admin.inventory.parts' : 'admin.inventory.accessories';
        return redirect()->route($route)->with('success', 'Inventory product added successfully!');
    }

    /**
     * Show form to edit an inventory item.
     */
    public function edit($id)
    {
        $item = InventoryItem::findOrFail($id);
        $categories = Category::where('status', 'active')->orderBy('name', 'asc')->get();
        $suppliers = Supplier::orderBy('name', 'asc')->get();
        
        return view('inventory.edit', compact('item', 'categories', 'suppliers'));
    }

    /**
     * Update the specified item in inventory.
     */
    public function update(Request $request, $id)
    {
        $item = InventoryItem::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'sub_category' => 'nullable|string|max:255',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'brand' => 'nullable|string|max:255',
            'model' => 'nullable|string|max:255',
            'barcode' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'product_type' => 'required|string|in:single,variable',
            'warranties' => 'nullable|string|max:255',
            'manufacturer' => 'nullable|string|max:255',
            'expiry' => 'nullable|date',
            
            // Single Product pricing fields
            'quantity' => 'required_if:product_type,single|nullable|integer|min:0',
            'purchase_price' => 'required|numeric|min:0',
            'sale_price' => 'required_if:product_type,single|nullable|numeric|min:0',
            'discount_type' => 'nullable|string|in:flat,percentage',
            'discount_value' => 'nullable|numeric|min:0',
            'alert_quantity' => 'required|integer|min:0',

            // Multiple images upload
            'images.*' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:10240',

            // Variable Product variants definition
            'variants' => 'required_if:product_type,variable|nullable|array',
            'variants.*.variation' => 'required_with:variants|string|max:100',
            'variants.*.value' => 'required_with:variants|string|max:100',
            'variants.*.sku' => 'required_with:variants|string|max:100',
            'variants.*.quantity' => 'required_with:variants|integer|min:0',
            'variants.*.price' => 'required_with:variants|numeric|min:0',
        ]);

        $category = Category::findOrFail($request->input('category_id'));

        // Handle images
        $imagePaths = $item->images ?? [];
        if ($request->hasFile('images')) {
            if (!empty($item->images)) {
                foreach ($item->images as $oldImage) {
                    Storage::disk('public')->delete($oldImage);
                }
            }
            $imagePaths = [];
            foreach ($request->file('images') as $imageFile) {
                $imagePaths[] = Helpers::compressAndStoreImage($imageFile, 'inventory');
            }
        }

        $productType = $request->input('product_type');
        $quantity = 0;
        $salePrice = 0;
        $variantsData = null;

        if ($productType === 'single') {
            $quantity = $request->input('quantity', 0);
            $salePrice = $request->input('sale_price', 0);
        } else {
            $variants = $request->input('variants', []);
            $variantsData = $variants;
            foreach ($variants as $index => $variant) {
                $quantity += intval($variant['quantity']);
                if ($index === 0) {
                    $salePrice = floatval($variant['price']);
                }
            }
        }

        $item->update([
            'name' => $request->input('name'),
            'barcode' => $request->input('barcode'),
            'category' => $category->name,
            'category_id' => $category->id,
            'sub_category' => $request->input('sub_category'),
            'supplier_id' => $request->input('supplier_id'),
            'brand' => $request->input('brand'),
            'model' => $request->input('model'),
            'description' => $request->input('description'),
            'product_type' => $productType,
            'quantity' => $quantity,
            'alert_quantity' => $request->input('alert_quantity', 5),
            'purchase_price' => $request->input('purchase_price'),
            'sale_price' => $salePrice,
            'discount_type' => $request->input('discount_type'),
            'discount_value' => $request->input('discount_value', 0.00),
            'images' => $imagePaths,
            'warranties' => $request->input('warranties'),
            'manufacturer' => $request->input('manufacturer'),
            'expiry' => $request->input('expiry'),
            'variants' => $variantsData,
        ]);

        $route = $item->type === 'spare_part' ? 'admin.inventory.parts' : 'admin.inventory.accessories';
        return redirect()->route($route)->with('success', 'Inventory product updated successfully!');
    }

    /**
     * Remove the specified item from inventory.
     */
    public function destroy($id)
    {
        $item = InventoryItem::findOrFail($id);
        $type = $item->type;

        if (!empty($item->images)) {
            foreach ($item->images as $image) {
                Storage::disk('public')->delete($image);
            }
        }

        $item->delete();

        $route = $type === 'spare_part' ? 'admin.inventory.parts' : 'admin.inventory.accessories';
        return redirect()->route($route)->with('success', 'Inventory product deleted successfully!');
    }
}
