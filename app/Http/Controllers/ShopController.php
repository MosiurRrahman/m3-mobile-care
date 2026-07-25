<?php

namespace App\Http\Controllers;

use App\Models\InventoryItem;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Sale;
use App\Models\SaleDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShopController extends Controller
{
    /**
     * E-Commerce Homepage serving Accessories (saafie/index.html)
     */
    public function index()
    {
        $accessories = InventoryItem::where('type', 'accessory')
            ->where('status', 'active')
            ->with('categoryRelation')
            ->orderBy('created_at', 'desc')
            ->take(12)
            ->get();

        $categories = Category::whereHas('items', function ($q) {
            $q->where('type', 'accessory')->where('status', 'active');
        })->get();

        if ($categories->isEmpty()) {
            $categories = Category::all();
        }

        $featuredAccessories = InventoryItem::where('type', 'accessory')
            ->where('status', 'active')
            ->orderBy('sale_price', 'desc')
            ->take(6)
            ->get();

        return view('frontend.index', compact('accessories', 'categories', 'featuredAccessories'));
    }

    /**
     * Accessories Shop Catalog (saafie/shop.html)
     */
    public function shop(Request $request)
    {
        $query = InventoryItem::where('type', 'accessory')->where('status', 'active')->with('categoryRelation');

        if ($request->filled('category')) {
            $query->where('category_id', $request->input('category'));
        }

        if ($request->filled('search')) {
            $search = trim($request->input('search'));
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('brand', 'like', "%{$search}%")
                  ->orWhere('model', 'like', "%{$search}%");
            });
        }

        $accessories = $query->orderBy('created_at', 'desc')->paginate(9);
        $categories = Category::all();

        return view('frontend.shop', compact('accessories', 'categories'));
    }

    /**
     * Single Accessory Product Details (saafie/shop-details.html)
     */
    public function show($id)
    {
        $product = InventoryItem::where('type', 'accessory')->where('status', 'active')->findOrFail($id);
        
        $relatedProducts = InventoryItem::where('type', 'accessory')
            ->where('status', 'active')
            ->where('id', '!=', $id)
            ->where('category_id', $product->category_id)
            ->take(4)
            ->get();

        if ($relatedProducts->isEmpty()) {
            $relatedProducts = InventoryItem::where('type', 'accessory')
                ->where('status', 'active')
                ->where('id', '!=', $id)
                ->take(4)
                ->get();
        }

        return view('frontend.product-details', compact('product', 'relatedProducts'));
    }

    /**
     * Add Item to Cart
     */
    public function addToCart(Request $request)
    {
        $productId = $request->input('product_id');
        $quantity = (int) $request->input('quantity', 1);

        $product = InventoryItem::findOrFail($productId);
        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += $quantity;
        } else {
            $cart[$productId] = [
                'id' => $product->id,
                'name' => $product->name,
                'sale_price' => $product->sale_price,
                'purchase_price' => $product->purchase_price,
                'quantity' => $quantity,
                'image_url' => $product->image_url,
                'sku' => $product->sku,
            ];
        }

        session()->put('cart', $cart);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Product added to cart successfully!',
                'cart_count' => count($cart),
            ]);
        }

        return redirect()->back()->with('success', 'Product added to cart!');
    }

    /**
     * Update Cart Quantity
     */
    public function updateCart(Request $request)
    {
        $productId = $request->input('product_id');
        $quantity = (int) $request->input('quantity', 1);

        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            if ($quantity > 0) {
                $cart[$productId]['quantity'] = $quantity;
            } else {
                unset($cart[$productId]);
            }
            session()->put('cart', $cart);
        }

        return redirect()->route('shop.cart')->with('success', 'Cart updated successfully!');
    }

    /**
     * Remove Item from Cart
     */
    public function removeFromCart($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->route('shop.cart')->with('success', 'Item removed from cart!');
    }

    /**
     * Cart Page (saafie/cart.html)
     */
    public function cart()
    {
        $cartSession = session()->get('cart', []);
        $cartItems = collect($cartSession)->map(function ($item) {
            return (object) $item;
        });

        return view('frontend.cart', compact('cartItems'));
    }

    /**
     * Toggle Wishlist Item
     */
    public function addToWishlist(Request $request)
    {
        $productId = $request->input('product_id');
        $wishlist = session()->get('wishlist', []);

        if (in_array($productId, $wishlist)) {
            $wishlist = array_diff($wishlist, [$productId]);
            $msg = 'Item removed from wishlist!';
        } else {
            $wishlist[] = $productId;
            $msg = 'Item added to wishlist!';
        }

        session()->put('wishlist', $wishlist);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $msg,
                'wishlist_count' => count($wishlist),
            ]);
        }

        return redirect()->back()->with('success', $msg);
    }

    /**
     * Wishlist Page (saafie/wishlist.html)
     */
    public function wishlist()
    {
        $wishlistIds = session()->get('wishlist', []);
        $wishlistItems = InventoryItem::whereIn('id', $wishlistIds)->get();

        return view('frontend.wishlist', compact('wishlistItems'));
    }

    /**
     * Checkout Page (saafie/checkout.html)
     */
    public function checkout()
    {
        $cartSession = session()->get('cart', []);
        
        // Fallback demo item if cart empty for instant preview
        if (empty($cartSession)) {
            $fallback = InventoryItem::where('type', 'accessory')->first();
            if ($fallback) {
                $cartSession[$fallback->id] = [
                    'id' => $fallback->id,
                    'name' => $fallback->name,
                    'sale_price' => $fallback->sale_price,
                    'purchase_price' => $fallback->purchase_price,
                    'quantity' => 1,
                    'image_url' => $fallback->image_url,
                    'sku' => $fallback->sku,
                ];
            }
        }

        $cartItems = collect($cartSession)->map(function ($item) {
            return (object) $item;
        });

        return view('frontend.checkout', compact('cartItems'));
    }

    /**
     * Process Real Checkout Order Placement
     */
    public function processCheckout(Request $request)
    {
        $request->validate([
            'fullname' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address1' => 'required|string',
            'city' => 'required|string',
        ]);

        $cartSession = session()->get('cart', []);

        if (empty($cartSession)) {
            return redirect()->route('shop.catalog')->with('error', 'Your cart is empty.');
        }

        $subtotal = 0;
        foreach ($cartSession as $item) {
            $subtotal += ($item['sale_price'] * $item['quantity']);
        }
        $shipping = 60;
        $totalAmount = $subtotal + $shipping;

        DB::beginTransaction();
        try {
            // 1. Find or create customer
            $customer = Customer::firstOrCreate(
                ['phone' => trim($request->input('phone'))],
                [
                    'name' => trim($request->input('fullname')),
                    'email' => $request->input('email'),
                    'address' => trim($request->input('address1')),
                    'district' => trim($request->input('city')),
                ]
            );

            // 2. Create Sale Record
            $paymentMethod = $request->input('payment_methods', 'COD');
            $invoiceNo = 'INV-ONLINE-' . time();
            $sale = Sale::create([
                'invoice_no' => $invoiceNo,
                'customer_id' => $customer->id,
                'total_amount' => $totalAmount,
                'discount' => 0,
                'payable_amount' => $totalAmount,
                'paid_amount' => $totalAmount,
                'due_amount' => 0,
                'payment_method' => $paymentMethod,
                'branch' => 'Online Store',
                'status' => 'Pending',
            ]);

            // 3. Create Payment Log for Financial & Accounting Ledger
            \App\Models\PaymentLog::create([
                'payable_type' => 'App\\Models\\Sale',
                'payable_id' => $sale->id,
                'payment_method' => $paymentMethod,
                'amount' => $totalAmount,
                'transaction_type' => 'online_order',
            ]);

            // 3. Create Sale Details & Decrement Inventory Stock
            foreach ($cartSession as $item) {
                SaleDetail::create([
                    'sale_id' => $sale->id,
                    'inventory_item_id' => $item['id'],
                    'quantity' => $item['quantity'],
                    'sale_price' => $item['sale_price'],
                    'purchase_price' => $item['purchase_price'] ?? 0,
                ]);

                // Decrement stock in database
                $inventoryItem = InventoryItem::find($item['id']);
                if ($inventoryItem) {
                    $inventoryItem->decrement('quantity', $item['quantity']);
                }
            }

            DB::commit();

            // Clear session cart
            session()->forget('cart');

            return redirect()->route('order.success', $invoiceNo);

        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Could not process order: ' . $e->getMessage());
        }
    }

    /**
     * Order Success Confirmation Page
     */
    public function orderSuccess($invoice_no)
    {
        $sale = Sale::where('invoice_no', $invoice_no)->with(['customer', 'details.item'])->firstOrFail();
        return view('frontend.order-success', compact('sale'));
    }

    /**
     * Contact Us Page
     */
    public function contact()
    {
        return view('frontend.contact');
    }

    /**
     * FAQ Page
     */
    public function faq()
    {
        return view('frontend.faq');
    }

    /**
     * About Us Page
     */
    public function about()
    {
        return view('frontend.about');
    }

    /**
     * Customer Login Page
     */
    public function customerLogin()
    {
        if (auth()->check()) {
            return redirect()->route('home');
        }
        return view('frontend.login');
    }

    /**
     * Process Customer Login
     */
    public function processCustomerLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (\Illuminate\Support\Facades\Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('home'))->with('success', 'Welcome back, ' . auth()->user()->name . '!');
        }

        return redirect()->back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    /**
     * Customer Sign Up Page
     */
    public function customerRegister()
    {
        if (auth()->check()) {
            return redirect()->route('home');
        }
        return view('frontend.signup');
    }

    /**
     * Process Customer Registration
     */
    public function processCustomerRegister(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:6',
        ]);

        $user = \App\Models\User::create([
            'name' => trim($request->input('name')),
            'email' => strtolower(trim($request->input('email'))),
            'phone' => $request->input('phone'),
            'password' => \Illuminate\Support\Facades\Hash::make($request->input('password')),
            'role' => 'customer',
            'is_active' => true,
        ]);

        // Also save to customers registry
        Customer::firstOrCreate(
            ['phone' => $request->input('phone') ?: $user->email],
            [
                'name' => $user->name,
                'email' => $user->email,
            ]
        );

        \Illuminate\Support\Facades\Auth::login($user);

        return redirect()->route('home')->with('success', 'Account created successfully! Welcome to M3 Mobile Care.');
    }

    /**
     * Customer Logout
     */
    public function customerLogout(Request $request)
    {
        \Illuminate\Support\Facades\Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'You have been logged out.');
    }
}
