<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Customer;
use App\Models\Repair;
use App\Models\InventoryItem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RepairBusinessImprovementsTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;
    protected $customer;
    protected $sparePart;

    protected function setUp(): void
    {
        parent::setUp();

        // Create user with settings/repairs permissions
        $this->admin = User::create([
            'name' => 'Admin Manager',
            'email' => 'admin@m3mobilecare.com',
            'password' => bcrypt('password123'),
            'role' => 'super_admin',
            'permissions' => ['repairs' => true, 'inventory' => true],
            'branch' => 'Dhaka',
        ]);

        // Create customer
        $this->customer = Customer::create([
            'name' => 'John Doe',
            'phone' => '01711122233',
            'email' => 'johndoe@gmail.com',
            'address' => 'Elephant Road, Dhaka',
        ]);

        // Create inventory spare part
        $this->sparePart = InventoryItem::create([
            'name' => 'iPhone 11 Screen OLED',
            'sku' => 'IP11-SCR-OLED',
            'type' => 'spare_part',
            'category' => 'Display',
            'quantity' => 10,
            'alert_quantity' => 2,
            'purchase_price' => 3000,
            'sale_price' => 4500,
            'branch' => 'Dhaka',
        ]);
    }

    public function test_stock_syncing_flow()
    {
        $this->actingAs($this->admin);

        // 1. Create a Repair Ticket in diagnosing status (non-working status: should NOT decrement stock)
        $payload = [
            'customer_name' => 'John Doe',
            'customer_phone' => '01711122233',
            'device_brand' => 'Apple',
            'device_model' => 'iPhone 11',
            'issue_description' => 'Cracked Screen',
            'repair_charge' => 1000,
            'status' => 'diagnosing',
            'warranty_days' => 90,
            'data_loss_consent' => '1',
            'pattern_lock_path' => '1-5-9',
            'used_parts' => [
                [
                    'inventory_id' => $this->sparePart->id,
                    'name' => $this->sparePart->name,
                    'buying_price' => $this->sparePart->purchase_price,
                    'quantity' => 2,
                ]
            ]
        ];

        $response = $this->post(route('admin.repairs.store'), $payload);
        $response->assertRedirect();

        $repair = Repair::orderBy('created_at', 'desc')->first();
        $this->assertNotNull($repair);
        $this->assertEquals('1-5-9', $repair->pattern_lock_path);
        $this->assertEquals(1, $repair->data_loss_consent);

        // Assert stock has NOT been decremented yet (since diagnosing is not a work status)
        $this->sparePart->refresh();
        $this->assertEquals(10, $this->sparePart->quantity);

        // 2. Transition repair to "repairing" status (work status: should decrement stock)
        $payload['status'] = 'repairing';
        $payload['customer_id'] = $this->customer->id;

        $response = $this->put(route('admin.repairs.update', $repair->id), $payload);
        $response->assertRedirect();

        // Assert stock has been decremented by 2 (quantity = 8)
        $this->sparePart->refresh();
        $this->assertEquals(8, $this->sparePart->quantity);

        // 3. Edit parts list: change quantity to 3 (should adjust stock: quantity = 7)
        $payload['used_parts'][0]['quantity'] = 3;

        $response = $this->put(route('admin.repairs.update', $repair->id), $payload);
        $response->assertRedirect();

        // Assert stock has adjusted (10 - 3 = 7)
        $this->sparePart->refresh();
        $this->assertEquals(7, $this->sparePart->quantity);

        // 4. Cancel repair ticket (status 'cancelled' is not work status: should increment stock back to 10)
        $payload['status'] = 'cancelled';

        $response = $this->put(route('admin.repairs.update', $repair->id), $payload);
        $response->assertRedirect();

        // Assert stock has rolled back completely (quantity = 10)
        $this->sparePart->refresh();
        $this->assertEquals(10, $this->sparePart->quantity);
    }

    public function test_warranty_calculations_on_completion()
    {
        $this->actingAs($this->admin);

        // 1. Create repair in diagnosing
        $repair = Repair::create([
            'ticket_id' => 'M3-202607-9999',
            'customer_id' => $this->customer->id,
            'device_brand' => 'Samsung',
            'device_model' => 'Galaxy S21',
            'issue_description' => 'Charging Port Fault',
            'repair_charge' => 1500,
            'estimated_cost' => 1500,
            'status' => 'diagnosing',
            'warranty_days' => 180,
            'branch' => 'Dhaka',
        ]);

        $this->assertNull($repair->warranty_expiry_date);

        // 2. Update status to completed (should trigger warranty calculation)
        $payload = [
            'customer_id' => $this->customer->id,
            'device_brand' => 'Samsung',
            'device_model' => 'Galaxy S21',
            'serial_imei' => '123456789012345',
            'issue_description' => 'Charging Port Fault',
            'repair_charge' => 1500,
            'status' => 'completed',
            'warranty_days' => 180,
        ];

        $response = $this->put(route('admin.repairs.update', $repair->id), $payload);
        $response->assertRedirect();

        $repair->refresh();
        $this->assertNotNull($repair->warranty_expiry_date);
        $this->assertEquals(now()->addDays(180)->toDateString(), $repair->warranty_expiry_date);
    }

    public function test_failed_stock_sync_rolls_back_transaction()
    {
        $this->actingAs($this->admin);

        // Try to create a repair ticket with status repairing using 15 units (only 10 available)
        $payload = [
            'customer_name' => 'New Temp Customer',
            'customer_phone' => '01999999999',
            'customer_address' => 'Mirpur, Dhaka',
            'device_brand' => 'Apple',
            'device_model' => 'iPhone 11',
            'issue_description' => 'Broken screen',
            'repair_charge' => 1000,
            'status' => 'repairing',
            'used_parts' => [
                [
                    'inventory_id' => $this->sparePart->id,
                    'name' => $this->sparePart->name,
                    'buying_price' => $this->sparePart->purchase_price,
                    'quantity' => 15, // Out of stock!
                ]
            ]
        ];

        $response = $this->post(route('admin.repairs.store'), $payload);
        $response->assertRedirect();
        $response->assertSessionHas('error'); // Assert it redirected back with an error

        // Assert customer was NOT created (transaction rolled back)
        $customerExists = Customer::where('phone', '01999999999')->exists();
        $this->assertFalse($customerExists);

        // Assert repair ticket was NOT created
        $repairExists = Repair::where('device_brand', 'Apple')->where('device_model', 'iPhone 11')->exists();
        $this->assertFalse($repairExists);

        // Assert stock remains 10
        $this->sparePart->refresh();
        $this->assertEquals(10, $this->sparePart->quantity);
    }

    public function test_deleted_customer_does_not_crash_show_page()
    {
        $this->actingAs($this->admin);

        $repair = Repair::create([
            'ticket_id' => 'M3-202607-8888',
            'customer_id' => $this->customer->id,
            'device_brand' => 'Samsung',
            'device_model' => 'Galaxy S21',
            'issue_description' => 'Faulty screen',
            'repair_charge' => 1000,
            'status' => 'pending',
            'branch' => 'Dhaka',
        ]);

        // Delete customer
        $this->customer->delete();

        // Assert customer_id is null on the repair ticket
        $repair->refresh();
        $this->assertNull($repair->customer_id);

        // Call show page
        $response = $this->get(route('admin.repairs.show', $repair->id));
        $response->assertStatus(200);
        $response->assertSee('Walk-in Customer'); // Should display fallback text
        $response->assertSee('N/A'); // Should display fallback for email
    }

    public function test_deleted_inventory_item_sets_foreign_key_to_null_on_sales_details()
    {
        $this->actingAs($this->admin);

        $sale = \App\Models\Sale::create([
            'invoice_no' => 'INV-TEST-1234',
            'payable_amount' => 4500,
            'paid_amount' => 4500,
            'payment_method' => 'Cash',
            'salesman_id' => $this->admin->id,
        ]);

        $detail = \App\Models\SaleDetail::create([
            'sale_id' => $sale->id,
            'inventory_item_id' => $this->sparePart->id,
            'quantity' => 1,
            'sale_price' => 4500,
            'purchase_price' => 3000,
        ]);

        // Delete inventory item
        $this->sparePart->delete();

        // Assert the sales details record is still there
        $detail->refresh();
        $this->assertNotNull($detail);

        // Assert inventory_item_id is set to null
        $this->assertNull($detail->inventory_item_id);
    }

    public function test_pos_cogs_uses_snapshot_price()
    {
        $this->actingAs($this->admin);

        $sale = \App\Models\Sale::create([
            'invoice_no' => 'INV-TEST-COGS',
            'payable_amount' => 5000,
            'paid_amount' => 5000,
            'payment_method' => 'Cash',
            'salesman_id' => $this->admin->id,
            'created_at' => now(),
        ]);

        $detail = \App\Models\SaleDetail::create([
            'sale_id' => $sale->id,
            'inventory_item_id' => $this->sparePart->id,
            'quantity' => 1,
            'sale_price' => 5000,
            'purchase_price' => 2500, // Snapshotted purchase price
            'created_at' => now(),
        ]);

        // Change catalog item purchase price to 4000
        $this->sparePart->update(['purchase_price' => 4000]);

        // Fetch reports index page
        $response = $this->get(route('admin.reports.index', ['timeframe' => 'day']));
        $response->assertStatus(200);

        // Verify the view has the correct COGS (should be 2500, not 4000)
        $response->assertViewHas('posCogs', 2500.0);
    }

    public function test_profit_report_excludes_purchase_expenses()
    {
        $this->actingAs($this->admin);

        // Create a Purchase expense (should be excluded from Net Profit calculation)
        \App\Models\Expense::create([
            'category' => 'Purchase',
            'amount' => 10000,
            'description' => 'Buying stock',
            'expense_date' => now()->toDateString(),
        ]);

        // Create a Rent expense (should be included)
        \App\Models\Expense::create([
            'category' => 'Rent',
            'amount' => 5000,
            'description' => 'Office Rent',
            'expense_date' => now()->toDateString(),
        ]);

        $response = $this->get(route('admin.reports.index', ['timeframe' => 'day']));
        $response->assertStatus(200);

        // View expenses should only show 5000 BDT since Purchase category is excluded from Net Profit expense calculation
        $response->assertViewHas('expenses', 5000.0);
    }

    public function test_cash_register_allows_negative_payments_representing_refunds()
    {
        $this->actingAs($this->admin);

        // Create a repair where actual_cost (800) < advance_payment (1000) -> -200 refund
        $repair = Repair::create([
            'ticket_id' => 'M3-202607-REFUND',
            'customer_id' => $this->customer->id,
            'device_brand' => 'Samsung',
            'device_model' => 'Galaxy S21',
            'issue_description' => 'Broken screen',
            'repair_charge' => 800,
            'estimated_cost' => 800,
            'actual_cost' => 800,
            'advance_payment' => 1000,
            'advance_payment_method' => 'Cash',
            'payment_method' => 'Cash',
            'status' => 'delivered',
            'completed_at' => now(),
            'branch' => 'Dhaka',
        ]);

        $repair->created_at = now()->subDay();
        $repair->save();

        $response = $this->get(route('admin.cash.index', [
            'start_date' => now()->toDateString(),
            'end_date' => now()->toDateString(),
            'payment_method' => 'Cash',
            'register_type' => 'service',
            'include_expenses' => 'false',
        ]));

        $response->assertStatus(200);

        // Check if cash register correctly registers the -200 inflow (refund)
        $response->assertViewHas('totalInflow', -200.0);
    }

    public function test_activity_logs_restricted_to_super_admin()
    {
        // Guest is redirected
        $response = $this->get(route('admin.activity-logs.index'));
        $response->assertRedirect(route('login'));

        // Technician is forbidden (not super_admin)
        $tech = User::create([
            'name' => 'Technician User',
            'email' => 'tech@m3.com',
            'password' => bcrypt('password123'),
            'role' => 'technician',
            'permissions' => []
        ]);
        $this->actingAs($tech);
        $response = $this->get(route('admin.activity-logs.index'));
        $response->assertRedirect(route('dashboard'));

        // Super Admin is allowed
        $this->actingAs($this->admin);
        $response = $this->get(route('admin.activity-logs.index'));
        $response->assertStatus(200);
    }

    public function test_activity_logs_filtering_works()
    {
        $this->actingAs($this->admin);

        // Log an activity log entry manually
        \App\Models\ActivityLog::create([
            'user_id' => $this->admin->id,
            'loggable_type' => 'App\Models\User',
            'loggable_id' => $this->admin->id,
            'action' => 'created',
            'description' => 'created test record log description',
            'ip_address' => '127.0.0.1'
        ]);

        $response = $this->get(route('admin.activity-logs.index', ['search' => 'test record']));
        $response->assertStatus(200);
        $response->assertSee('created test record log description');

        $response = $this->get(route('admin.activity-logs.index', ['search' => 'nonexistent']));
        $response->assertStatus(200);
        $response->assertDontSee('created test record log description');
    }

    public function test_only_super_admin_can_create_custom_expense_category()
    {
        // 1. Admin manager who has expenses permission but is NOT super_admin
        $regularAdmin = User::create([
            'name' => 'Regular Admin Manager',
            'email' => 'regularadmin@m3.com',
            'password' => bcrypt('password123'),
            'role' => 'admin',
            'permissions' => ['expenses' => true]
        ]);

        $this->actingAs($regularAdmin);

        // Try to store standard expense - works fine
        $response = $this->post(route('admin.expenses.store'), [
            'category' => 'Rent',
            'amount' => 1200,
            'description' => 'Test standard rent expense',
            'expense_date' => now()->toDateString(),
        ]);
        $response->assertRedirect(route('admin.expenses.index'));

        // Try to store custom category expense - fails validation/redirects back with error
        $response = $this->post(route('admin.expenses.store'), [
            'category' => '__custom__',
            'custom_category' => 'Catering',
            'amount' => 500,
            'description' => 'Test custom expense',
            'expense_date' => now()->toDateString(),
        ]);
        $response->assertSessionHasErrors(['category']);

        // 2. Super Admin can do both
        $this->actingAs($this->admin); // Super Admin

        $response = $this->post(route('admin.expenses.store'), [
            'category' => '__custom__',
            'custom_category' => 'Catering',
            'amount' => 500,
            'description' => 'Test custom expense',
            'expense_date' => now()->toDateString(),
        ]);
        $response->assertRedirect(route('admin.expenses.index'));

        $this->assertDatabaseHas('expenses', [
            'category' => 'Catering',
            'amount' => 500.0,
        ]);
    }

    public function test_partner_ledger_permissions_and_workflow()
    {
        // 1. Initialize partner balances
        \App\Models\PartnerBalance::create([
            'partner_name' => 'Monowar Munna',
            'capital_balance' => 450000.00,
            'accumulated_profit' => 0.00,
            'payback_completed_at' => null,
        ]);
        \App\Models\PartnerBalance::create([
            'partner_name' => 'Munna Raihan',
            'capital_balance' => 50000.00,
            'accumulated_profit' => 0.00,
            'payback_completed_at' => null,
        ]);
        \App\Models\PartnerBalance::create([
            'partner_name' => 'Mosiur',
            'capital_balance' => 50000.00,
            'accumulated_profit' => 0.00,
            'payback_completed_at' => null,
        ]);

        // Regular admin cannot access Partner Ledger
        $regularAdmin = User::create([
            'name' => 'Regular Admin Manager',
            'email' => 'regularadmin2@m3.com',
            'password' => bcrypt('password123'),
            'role' => 'admin',
        ]);
        $this->actingAs($regularAdmin);
        $response = $this->get(route('admin.partner-ledger.index'));
        $response->assertRedirect(route('dashboard'));

        // Super Admin can access Partner Ledger
        $this->actingAs($this->admin); // Super Admin
        $response = $this->get(route('admin.partner-ledger.index'));
        $response->assertStatus(200);

        // Test profit distribution logic for a selected month
        // Let's seed a test repair with actual cost and commission
        $repair = Repair::create([
            'ticket_id' => 'TEST-REP-01',
            'customer_id' => null,
            'device_brand' => 'Apple',
            'device_model' => 'iPhone 13',
            'issue_description' => 'Test',
            'status' => 'completed',
            'actual_cost' => 20000.00, // Service Income
            'paid_amount' => 20000.00,
            'commission_amount' => 0.00,
            'completed_at' => '2026-07-10 12:00:00',
        ]);

        // Total profit will be 20000 BDT (assuming 0 expenses/COGS in this timeframe)
        // Ratios: Monowar gets (4.5 / 5.5) * 50% = 40.91% (exact ratio: 4.5/5.5 * 0.5)
        // Munna Raihan gets 40%
        // Mosiur gets 60% - Monowar ratio = 19.09%

        $response = $this->post(route('admin.partner-ledger.distribute'), [
            'month' => '2026-07',
        ]);
        $response->assertRedirect(route('admin.partner-ledger.index'));

        // Let's assert database balances have updated correctly
        $monowar = \App\Models\PartnerBalance::where('partner_name', 'Monowar Munna')->first();
        $raihan = \App\Models\PartnerBalance::where('partner_name', 'Munna Raihan')->first();
        $mosiur = \App\Models\PartnerBalance::where('partner_name', 'Mosiur')->first();

        // Monowar's share: 20000 * (4.5 / 5.5) * 0.5 = 8181.82
        $this->assertEquals(8181.82, round($monowar->accumulated_profit, 2));
        // Munna Raihan's share: 20000 * 0.40 = 8000
        $this->assertEquals(8000.00, round($raihan->accumulated_profit, 2));
        // Mosiur's share: 20000 * (1 - 0.40 - (4.5/5.5*0.5)) = 3818.18
        $this->assertEquals(3818.18, round($mosiur->accumulated_profit, 2));

        // Let's test cash withdrawal from Profit
        $response = $this->post(route('admin.partner-ledger.withdraw'), [
            'partner_name' => 'Monowar Munna',
            'account_type' => 'profit',
            'amount' => 5000.00,
            'description' => 'Munnar profit withdrawal',
        ]);
        $response->assertRedirect(route('admin.partner-ledger.index'));

        $monowar->refresh();
        $this->assertEquals(3181.82, round($monowar->accumulated_profit, 2));

        // Check that an expense was logged in the shop books
        $this->assertDatabaseHas('expenses', [
            'category' => 'Other',
            'amount' => 5000.00,
            'register_type' => 'withdraw',
        ]);

        // Let's test capital withdrawal (payback)
        $response = $this->post(route('admin.partner-ledger.withdraw'), [
            'partner_name' => 'Monowar Munna',
            'account_type' => 'capital',
            'amount' => 450000.00, // Complete payback
            'description' => 'Full capital payback',
        ]);
        $response->assertRedirect(route('admin.partner-ledger.index'));

        $monowar->refresh();
        $this->assertEquals(0.00, $monowar->capital_balance);
        $this->assertNotNull($monowar->payback_completed_at); // pay back completion logged!

        // Now that Monowar's capital is 0 BDT, let's distribute profit for next month: August 2026.
        // It should trigger the 3-year minimum 10% guarantee!
        // We will seed another repair in August 2026.
        $repair2 = Repair::create([
            'ticket_id' => 'TEST-REP-02',
            'customer_id' => null,
            'device_brand' => 'Apple',
            'device_model' => 'iPhone 13',
            'issue_description' => 'Test',
            'status' => 'completed',
            'actual_cost' => 10000.00,
            'paid_amount' => 10000.00,
            'commission_amount' => 0.00,
            'completed_at' => '2026-08-10 12:00:00',
        ]);

        $response = $this->post(route('admin.partner-ledger.distribute'), [
            'month' => '2026-08',
        ]);

        $monowar->refresh();
        $raihan->refresh();
        $mosiur->refresh();

        // Monowar should get 10% of 10000 = 1000 BDT
        // Munna Raihan gets 40% of 10000 = 4000 BDT
        // Mosiur gets remaining 50% of 10000 = 5000 BDT
        $this->assertEquals(3181.82 + 1000.00, round($monowar->accumulated_profit, 2));
        $this->assertEquals(8000.00 + 4000.00, round($raihan->accumulated_profit, 2));
        $this->assertEquals(3818.18 + 5000.00, round($mosiur->accumulated_profit, 2));

        // Test rollback / unlock of August 2026 distribution
        $response = $this->post(route('admin.partner-ledger.rollback'), [
            'month' => '2026-08',
        ]);
        $response->assertRedirect(route('admin.partner-ledger.index'));

        $monowar->refresh();
        $raihan->refresh();
        $mosiur->refresh();

        // Balances should be reverted back to prior values (before August distribution)
        $this->assertEquals(3181.82, round($monowar->accumulated_profit, 2));
        $this->assertEquals(8000.00, round($raihan->accumulated_profit, 2));
        $this->assertEquals(3818.18, round($mosiur->accumulated_profit, 2));

        $this->assertDatabaseMissing('partner_ledger_entries', [
            'month' => '2026-08',
            'account_type' => 'profit',
        ]);
    }
}
