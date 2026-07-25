<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RepairController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\PosController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\FinancialController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SocialMediaController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CashController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\PartnerLedgerController;

// E-Commerce Shop & Saafie Template Routes
Route::get('/', [ShopController::class, 'index'])->name('home');
Route::get('/shop', [ShopController::class, 'shop'])->name('shop.catalog');
Route::get('/shop/product/{id}', [ShopController::class, 'show'])->name('shop.show');
Route::get('/cart', [ShopController::class, 'cart'])->name('shop.cart');
Route::post('/cart/add', [ShopController::class, 'addToCart'])->name('cart.add');
Route::post('/cart/update', [ShopController::class, 'updateCart'])->name('cart.update');
Route::get('/cart/remove/{id}', [ShopController::class, 'removeFromCart'])->name('cart.remove');
Route::get('/wishlist', [ShopController::class, 'wishlist'])->name('shop.wishlist');
Route::post('/wishlist/toggle', [ShopController::class, 'addToWishlist'])->name('wishlist.toggle');
Route::get('/checkout', [ShopController::class, 'checkout'])->name('shop.checkout');
Route::post('/checkout', [ShopController::class, 'processCheckout'])->name('checkout.process');
Route::get('/order-success/{invoice_no}', [ShopController::class, 'orderSuccess'])->name('order.success');
Route::get('/contact', [ShopController::class, 'contact'])->name('shop.contact');
Route::get('/faq', [ShopController::class, 'faq'])->name('shop.faq');
Route::get('/about', [ShopController::class, 'about'])->name('shop.about');
Route::get('/customer/login', [ShopController::class, 'customerLogin'])->name('customer.login');
Route::post('/customer/login', [ShopController::class, 'processCustomerLogin'])->name('customer.login.process');
Route::get('/customer/register', [ShopController::class, 'customerRegister'])->name('customer.register');
Route::post('/customer/register', [ShopController::class, 'processCustomerRegister'])->name('customer.register.process');
Route::get('/customer/logout', [ShopController::class, 'customerLogout'])->name('customer.logout');

// Public Repair Tracking & Booking Routes
Route::get('/track', [HomeController::class, 'index'])->name('track.form');
Route::post('/track', [HomeController::class, 'track'])->name('track.search');
Route::get('/track-ajax', [HomeController::class, 'trackAjax'])->name('track.ajax');
Route::get('/book', [HomeController::class, 'showBookingForm'])->name('book.form');
Route::post('/book', [HomeController::class, 'book'])->name('book.store');
Route::get('/booking-success/{ticket_id}', [HomeController::class, 'bookingSuccess'])->name('book.success');

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:5,1')->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Staff Authed Routes
Route::middleware(['auth'])->group(function () {
    
    // Shared Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // User Profile Custom Override
    Route::get('/user/profile', [UserController::class, 'profile'])->name('profile.show');
    Route::put('/user/profile', [UserController::class, 'updateProfile'])->name('profile.update');

    // POS Terminal
    Route::middleware(['permission:pos'])->group(function () {
        Route::get('/admin/pos', [PosController::class, 'index'])->name('admin.pos.index');
        Route::get('/admin/pos/search', [PosController::class, 'searchProduct'])->name('admin.pos.search');
        Route::post('/admin/pos/checkout', [PosController::class, 'checkout'])->name('admin.pos.checkout');
        Route::get('/admin/pos/invoice/{id}', [PosController::class, 'invoice'])->name('admin.pos.invoice');
        Route::post('/admin/sales/{id}/pay-due', [PosController::class, 'payDue'])->name('admin.sales.pay-due');
    });

    // Online Store Orders Management
    Route::get('/admin/orders', [OrderController::class, 'index'])->name('admin.orders.index');
    Route::get('/admin/orders/{id}', [OrderController::class, 'show'])->name('admin.orders.show');
    Route::post('/admin/orders/{id}/status', [OrderController::class, 'updateStatus'])->name('admin.orders.updateStatus');

    // Repairs (Job Cards)
    Route::middleware(['permission:repairs'])->group(function () {
        Route::get('/admin/repairs', [RepairController::class, 'index'])->name('admin.repairs.index');
        Route::get('/admin/repairs/create', [RepairController::class, 'create'])->name('admin.repairs.create');
        Route::post('/admin/repairs', [RepairController::class, 'store'])->name('admin.repairs.store');
        Route::get('/admin/repairs/{id}', [RepairController::class, 'show'])->name('admin.repairs.show');
        Route::get('/admin/repairs/{id}/edit', [RepairController::class, 'edit'])->name('admin.repairs.edit');
        Route::put('/admin/repairs/{id}', [RepairController::class, 'update'])->name('admin.repairs.update');
        Route::delete('/admin/repairs/{id}', [RepairController::class, 'destroy'])->name('admin.repairs.destroy');
        Route::get('/admin/repairs/{id}/print', [RepairController::class, 'printSlip'])->name('admin.repairs.print');
        Route::post('/admin/repairs/{id}/pay-due', [RepairController::class, 'payDue'])->name('admin.repairs.pay-due');
    });

    // Inventory Catalog (Parts & Accessories)
    Route::middleware(['permission:inventory'])->group(function () {
        Route::get('/admin/inventory', [InventoryController::class, 'indexAccessories'])->name('admin.inventory.index');
        Route::get('/admin/inventory/parts', [InventoryController::class, 'indexParts'])->name('admin.inventory.parts');
        Route::get('/admin/inventory/accessories', [InventoryController::class, 'indexAccessories'])->name('admin.inventory.accessories');
        Route::get('/admin/inventory/create', [InventoryController::class, 'create'])->name('admin.inventory.create');
        Route::get('/admin/inventory/{id}/edit', [InventoryController::class, 'edit'])->name('admin.inventory.edit');
        Route::post('/admin/inventory', [InventoryController::class, 'store'])->name('admin.inventory.store');
        Route::put('/admin/inventory/{id}', [InventoryController::class, 'update'])->name('admin.inventory.update');
        Route::delete('/admin/inventory/{id}', [InventoryController::class, 'destroy'])->name('admin.inventory.destroy');
        Route::post('/admin/inventory/{id}/toggle-status', [InventoryController::class, 'toggleStatus'])->name('admin.inventory.toggleStatus');
        
        // Categories
        Route::get('/admin/categories', [CategoryController::class, 'index'])->name('admin.categories.index');
        Route::post('/admin/categories', [CategoryController::class, 'store'])->name('admin.categories.store');
        Route::put('/admin/categories/{id}', [CategoryController::class, 'update'])->name('admin.categories.update');
        Route::delete('/admin/categories/{id}', [CategoryController::class, 'destroy'])->name('admin.categories.destroy');
    });

    // Purchases & Suppliers
    Route::middleware(['permission:purchases'])->group(function () {
        Route::get('/admin/purchases', [PurchaseController::class, 'index'])->name('admin.purchases.index');
        Route::post('/admin/purchases', [PurchaseController::class, 'store'])->name('admin.purchases.store');
        Route::put('/admin/purchases/{id}', [PurchaseController::class, 'update'])->name('admin.purchases.update');
        Route::delete('/admin/purchases/{id}', [PurchaseController::class, 'destroy'])->name('admin.purchases.destroy');

        Route::post('/admin/purchases/suppliers', [PurchaseController::class, 'storeSupplier'])->name('admin.purchases.suppliers');
        Route::put('/admin/purchases/suppliers/{id}', [PurchaseController::class, 'updateSupplier'])->name('admin.purchases.suppliers.update');
        Route::delete('/admin/purchases/suppliers/{id}', [PurchaseController::class, 'destroySupplier'])->name('admin.purchases.suppliers.destroy');
    });

    // Customers (General lookup accessible if they have POS or Repairs permission)
    Route::middleware(['role:super_admin,admin,salesman,technician'])->group(function () {
        Route::get('/admin/customers', [CustomerController::class, 'index'])->name('admin.customers.index');
        Route::post('/admin/customers', [CustomerController::class, 'store'])->name('admin.customers.store');
        Route::get('/admin/customers/lookup', [CustomerController::class, 'lookup'])->name('admin.customers.lookup');
        Route::get('/admin/customers/{id}', [CustomerController::class, 'show'])->name('admin.customers.show');
        Route::put('/admin/customers/{id}', [CustomerController::class, 'update'])->name('admin.customers.update');
        Route::delete('/admin/customers/{id}', [CustomerController::class, 'destroy'])->name('admin.customers.destroy');
    });

    // Social Media Management
    Route::middleware(['permission:social_media'])->group(function () {
        Route::get('/admin/social', [SocialMediaController::class, 'index'])->name('admin.social.index');
        Route::post('/admin/social', [SocialMediaController::class, 'store'])->name('admin.social.store');
        Route::put('/admin/social/{id}', [SocialMediaController::class, 'update'])->name('admin.social.update');
        Route::delete('/admin/social/{id}', [SocialMediaController::class, 'destroy'])->name('admin.social.destroy');
        Route::post('/admin/social/{id}/publish', [SocialMediaController::class, 'publish'])->name('admin.social.publish');

        // Service Catalog Management
        Route::get('/admin/services', [ServiceController::class, 'index'])->name('admin.services.index');
        Route::post('/admin/services', [ServiceController::class, 'store'])->name('admin.services.store');
        Route::put('/admin/services/{id}', [ServiceController::class, 'update'])->name('admin.services.update');
        Route::delete('/admin/services/{id}', [ServiceController::class, 'destroy'])->name('admin.services.destroy');
    });

    // Expense Management (Accessible by users with the expenses permission, which is granted to Super Admin and toggled for Admin Manager)
    Route::middleware(['permission:expenses'])->group(function () {
        Route::get('/admin/expenses', [FinancialController::class, 'indexExpenses'])->name('admin.expenses.index');
        Route::post('/admin/expenses', [FinancialController::class, 'storeExpense'])->name('admin.expenses.store');
        Route::put('/admin/expenses/{id}', [FinancialController::class, 'updateExpense'])->name('admin.expenses.update');
        Route::delete('/admin/expenses/{id}', [FinancialController::class, 'destroyExpense'])->name('admin.expenses.destroy');
    });

    // Financial Reports (Accessible by users with reports permission, which is granted to Super Admin and toggled for Admin Manager)
    Route::middleware(['permission:reports'])->group(function () {
        Route::get('/admin/reports', [ReportController::class, 'index'])->name('admin.reports.index');
    });

    // Cash Register (Accessible by users with cash permission)
    Route::middleware(['permission:cash'])->group(function () {
        Route::get('/admin/cash', [CashController::class, 'index'])->name('admin.cash.index');
        Route::post('/admin/cash/outflow', [CashController::class, 'storeOutflow'])->name('admin.cash.outflow');
    });

    // Super-Admin Only Operations (Staff Accounts, Settings)
    Route::middleware(['role:super_admin'])->group(function () {
        // Staff Accounts Management
        Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users.index');
        Route::post('/admin/users', [UserController::class, 'store'])->name('admin.users.store');
        Route::put('/admin/users/{id}', [UserController::class, 'update'])->name('admin.users.update');
        Route::delete('/admin/users/{id}', [UserController::class, 'destroy'])->name('admin.users.destroy');
        Route::post('/admin/users/{id}/toggle-status', [UserController::class, 'toggleStatus'])->name('admin.users.toggle-status');

        // Global Shop Settings
        Route::get('/admin/settings', [SettingController::class, 'index'])->name('admin.settings.index');
        Route::put('/admin/settings', [SettingController::class, 'update'])->name('admin.settings.update');

        // System Activity Logs
        Route::get('/admin/activity-logs', [UserController::class, 'activityLogs'])->name('admin.activity-logs.index');

        // Partner Profit & Capital Ledger Management
        Route::get('/admin/partner-ledger', [PartnerLedgerController::class, 'index'])->name('admin.partner-ledger.index');
        Route::post('/admin/partner-ledger/distribute', [PartnerLedgerController::class, 'distributeProfit'])->name('admin.partner-ledger.distribute');
        Route::post('/admin/partner-ledger/deposit', [PartnerLedgerController::class, 'storeDeposit'])->name('admin.partner-ledger.deposit');
        Route::post('/admin/partner-ledger/withdraw', [PartnerLedgerController::class, 'storeWithdrawal'])->name('admin.partner-ledger.withdraw');
        Route::put('/admin/partner-ledger/capital/{id}', [PartnerLedgerController::class, 'updatePartnerCapital'])->name('admin.partner-ledger.update-capital');
        Route::put('/admin/partner-ledger/{id}', [PartnerLedgerController::class, 'update'])->name('admin.partner-ledger.update');
        Route::delete('/admin/partner-ledger/{id}', [PartnerLedgerController::class, 'destroy'])->name('admin.partner-ledger.destroy');
        Route::post('/admin/partner-ledger/rollback', [PartnerLedgerController::class, 'rollbackDistribution'])->name('admin.partner-ledger.rollback');
    });
});
