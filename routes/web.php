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
use App\Http\Controllers\PartnerLedgerController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\ContactMessageController;
use App\Http\Controllers\SpecialOrderController;

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/services', [HomeController::class, 'services'])->name('services');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::post('/contact', [HomeController::class, 'submitContact'])->name('contact.submit');
Route::get('/products', function() { return redirect()->route('home'); })->name('products');
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');
Route::get('/track', [HomeController::class, 'trackView'])->name('track.form');
Route::get('/ert', [HomeController::class, 'trackView'])->name('ert');
Route::post('/track', [HomeController::class, 'track'])->name('track.search');
Route::get('/track-ajax', [HomeController::class, 'trackAjax'])->name('track.ajax');
Route::get('/book', [HomeController::class, 'showBookingForm'])->name('book.form');
Route::post('/book', [HomeController::class, 'book'])->name('book.store');
Route::get('/booking-success/{ticket_id}', [HomeController::class, 'bookingSuccess'])->name('book.success');

// Authentication & Staff Portal Routes
Route::get('/portal', function () {
    return auth()->check() ? redirect()->route('dashboard') : redirect()->route('login');
})->name('portal');
Route::get('/portal/login', function () {
    return redirect()->route('login');
})->name('portal.login');
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
        Route::post('/admin/sales/{id}/send-sms', [PosController::class, 'sendManualSaleSms'])->name('admin.sales.send-sms');
    });

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
        Route::post('/admin/repairs/{id}/send-sms', [RepairController::class, 'sendManualSms'])->name('admin.repairs.send-sms');
        Route::post('/admin/repairs/{id}/quick-status', [RepairController::class, 'quickStatus'])->name('admin.repairs.quick-status');
    });

    // Customer Special Orders / Pre-orders & Dhaka Sourced Items
    Route::get('/admin/special-orders', [SpecialOrderController::class, 'index'])->name('admin.special-orders.index');
    Route::get('/admin/special-orders/create', [SpecialOrderController::class, 'create'])->name('admin.special-orders.create');
    Route::post('/admin/special-orders', [SpecialOrderController::class, 'store'])->name('admin.special-orders.store');
    Route::get('/admin/special-orders/{id}', [SpecialOrderController::class, 'show'])->name('admin.special-orders.show');
    Route::get('/admin/special-orders/{id}/edit', [SpecialOrderController::class, 'edit'])->name('admin.special-orders.edit');
    Route::put('/admin/special-orders/{id}', [SpecialOrderController::class, 'update'])->name('admin.special-orders.update');
    Route::delete('/admin/special-orders/{id}', [SpecialOrderController::class, 'destroy'])->name('admin.special-orders.destroy');
    Route::get('/admin/special-orders/{id}/print', [SpecialOrderController::class, 'printSlip'])->name('admin.special-orders.print');
    Route::post('/admin/special-orders/{id}/quick-status', [SpecialOrderController::class, 'quickStatus'])->name('admin.special-orders.quick-status');
    Route::post('/admin/special-orders/{id}/pay-due', [SpecialOrderController::class, 'payDue'])->name('admin.special-orders.pay-due');

    // Inventory Catalog (Parts & Accessories)
    Route::middleware(['permission:inventory'])->group(function () {
        Route::get('/admin/inventory/parts', [InventoryController::class, 'indexParts'])->name('admin.inventory.parts');
        Route::get('/admin/inventory/accessories', [InventoryController::class, 'indexAccessories'])->name('admin.inventory.accessories');
        // Barcode Generation & Printing
        Route::get('/admin/inventory/barcode/print', [InventoryController::class, 'barcodePrint'])->name('admin.inventory.barcode.print');
        Route::get('/admin/inventory/barcode/generate', [InventoryController::class, 'getGeneratedBarcode'])->name('admin.inventory.barcode.generate');
        
        Route::get('/admin/inventory/salesman-sheet', [InventoryController::class, 'salesmanSheet'])->name('admin.inventory.salesman-sheet');
        Route::get('/admin/inventory/salesman-sheet/print', [InventoryController::class, 'printSalesmanSheet'])->name('admin.inventory.salesman-sheet.print');
        Route::get('/admin/inventory/create', [InventoryController::class, 'create'])->name('admin.inventory.create');
        Route::get('/admin/inventory/{id}/edit', [InventoryController::class, 'edit'])->name('admin.inventory.edit');
        Route::post('/admin/inventory', [InventoryController::class, 'store'])->name('admin.inventory.store');
        Route::put('/admin/inventory/{id}', [InventoryController::class, 'update'])->name('admin.inventory.update');
        Route::delete('/admin/inventory/{id}', [InventoryController::class, 'destroy'])->name('admin.inventory.destroy');
        
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
    });

    // Expense Management (Accessible by users with the expenses permission, which is granted to Super Admin and toggled for Admin Manager)
    Route::middleware(['permission:expenses'])->group(function () {
        Route::get('/admin/expenses', [FinancialController::class, 'indexExpenses'])->name('admin.expenses.index');
        Route::get('/admin/expenses/export/excel', [FinancialController::class, 'exportExcel'])->name('admin.expenses.export.excel');
        Route::get('/admin/expenses/export/pdf', [FinancialController::class, 'exportPdf'])->name('admin.expenses.export.pdf');
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
        Route::post('/admin/cash/inflow', [CashController::class, 'storeInflow'])->name('admin.cash.inflow');
    });

    // Customer Inquiries & Messages
    Route::middleware(['role:super_admin,admin'])->group(function () {
        Route::get('/admin/contact-messages', [ContactMessageController::class, 'index'])->name('admin.contact-messages.index');
        Route::post('/admin/contact-messages/{id}/read', [ContactMessageController::class, 'markAsRead'])->name('admin.contact-messages.read');
        Route::post('/admin/contact-messages/mark-all-read', [ContactMessageController::class, 'markAllAsRead'])->name('admin.contact-messages.mark-all-read');
        Route::post('/admin/contact-messages/{id}/send-sms', [ContactMessageController::class, 'sendReplySms'])->name('admin.contact-messages.send-sms');
        Route::delete('/admin/contact-messages/{id}', [ContactMessageController::class, 'destroy'])->name('admin.contact-messages.destroy');
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
        Route::post('/admin/settings/test-sms', [SettingController::class, 'testSms'])->name('admin.settings.test-sms');
        Route::get('/admin/settings/sms-balance', [SettingController::class, 'getSmsBalance'])->name('admin.settings.sms-balance');

        // System Activity Logs
        Route::get('/admin/activity-logs', [UserController::class, 'activityLogs'])->name('admin.activity-logs.index');

        // Partner Profit & Capital Ledger Management
        Route::get('/admin/partner-ledger', [PartnerLedgerController::class, 'index'])->name('admin.partner-ledger.index');
        Route::post('/admin/partner-ledger/distribute', [PartnerLedgerController::class, 'distributeProfit'])->name('admin.partner-ledger.distribute');
        Route::post('/admin/partner-ledger/deposit', [PartnerLedgerController::class, 'storeDeposit'])->name('admin.partner-ledger.deposit');
        Route::post('/admin/partner-ledger/withdraw', [PartnerLedgerController::class, 'storeWithdrawal'])->name('admin.partner-ledger.withdraw');
        Route::put('/admin/partner-ledger/{id}', [PartnerLedgerController::class, 'update'])->name('admin.partner-ledger.update');
        Route::delete('/admin/partner-ledger/{id}', [PartnerLedgerController::class, 'destroy'])->name('admin.partner-ledger.destroy');
        Route::post('/admin/partner-ledger/rollback', [PartnerLedgerController::class, 'rollbackDistribution'])->name('admin.partner-ledger.rollback');
    });

    // Document & Pad Generator Routes (Accessible by staff/admin)
    Route::middleware(['role:super_admin,admin,salesman,technician'])->group(function () {
        Route::get('/admin/documents', [DocumentController::class, 'index'])->name('admin.documents.index');
        Route::get('/admin/documents/create', [DocumentController::class, 'create'])->name('admin.documents.create');
        Route::post('/admin/documents', [DocumentController::class, 'store'])->name('admin.documents.store');
        Route::get('/admin/documents/{id}', [DocumentController::class, 'show'])->name('admin.documents.show');
        Route::get('/admin/documents/{id}/edit', [DocumentController::class, 'edit'])->name('admin.documents.edit');
        Route::put('/admin/documents/{id}', [DocumentController::class, 'update'])->name('admin.documents.update');
        Route::delete('/admin/documents/{id}', [DocumentController::class, 'destroy'])->name('admin.documents.destroy');
        Route::get('/admin/documents/{id}/print', [DocumentController::class, 'print'])->name('admin.documents.print');
    });
});
