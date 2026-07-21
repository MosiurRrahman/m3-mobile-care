<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\InventoryItem;
use App\Models\User;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PosCheckoutDueTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create([
            'role' => 'admin',
            'branch' => 'Dhaka Main',
        ]);
    }

    public function test_pos_checkout_fully_paid()
    {
        $category = Category::create([
            'name' => 'Chargers',
            'slug' => 'chargers',
            'status' => 'active'
        ]);
        
        $product = InventoryItem::create([
            'name' => 'Fast Charger',
            'sku' => 'ACCS-CHAR-001',
            'type' => 'accessory',
            'category' => 'Chargers',
            'category_id' => $category->id,
            'quantity' => 10,
            'alert_quantity' => 2,
            'purchase_price' => 100.00,
            'sale_price' => 150.00,
            'product_type' => 'single',
            'branch' => 'Dhaka Main',
        ]);

        $customer = Customer::create([
            'name' => 'Anisur Rahman',
            'phone' => '01711223344',
        ]);

        $payload = [
            'customer_id' => $customer->id,
            'discount' => 10.00,
            'paid_amount' => 140.00, // full payment: 150 - 10 = 140 BDT
            'payment_method' => 'Cash',
            'cart' => [
                [
                    'id' => $product->id,
                    'qty' => 1,
                ]
            ]
        ];

        $response = $this->actingAs($this->user)
            ->postJson(route('admin.pos.checkout'), $payload);

        $response->assertStatus(200);
        $response->assertJsonPath('success', true);

        // Assert database values
        $this->assertDatabaseHas('sales', [
            'customer_id' => $customer->id,
            'total_amount' => 150.00,
            'discount' => 10.00,
            'payable_amount' => 140.00,
            'paid_amount' => 140.00,
            'due_amount' => 0.00,
            'payment_method' => 'Cash',
        ]);

        // Verify stock decremented
        $this->assertEquals(9, $product->fresh()->quantity);
    }

    public function test_pos_checkout_partial_payment_with_remaining_due()
    {
        $category = Category::create([
            'name' => 'Covers',
            'slug' => 'covers',
            'status' => 'active'
        ]);
        
        $product = InventoryItem::create([
            'name' => 'Silicone Cover',
            'sku' => 'ACCS-COV-001',
            'type' => 'accessory',
            'category' => 'Covers',
            'category_id' => $category->id,
            'quantity' => 5,
            'alert_quantity' => 1,
            'purchase_price' => 200.00,
            'sale_price' => 300.00,
            'product_type' => 'single',
            'branch' => 'Dhaka Main',
        ]);

        $customer = Customer::create([
            'name' => 'Fahim Hasan',
            'phone' => '01811223344',
        ]);

        $payload = [
            'customer_id' => $customer->id,
            'discount' => 50.00,
            'paid_amount' => 150.00, // partial payment: 300 - 50 = 250 payable, so 100 due
            'payment_method' => 'bKash',
            'cart' => [
                [
                    'id' => $product->id,
                    'qty' => 1,
                ]
            ]
        ];

        $response = $this->actingAs($this->user)
            ->postJson(route('admin.pos.checkout'), $payload);

        $response->assertStatus(200);
        $response->assertJsonPath('success', true);

        // Assert database values
        $this->assertDatabaseHas('sales', [
            'customer_id' => $customer->id,
            'total_amount' => 300.00,
            'discount' => 50.00,
            'payable_amount' => 250.00,
            'paid_amount' => 150.00,
            'due_amount' => 100.00,
            'payment_method' => 'bKash',
        ]);

        // Verify stock decremented
        $this->assertEquals(4, $product->fresh()->quantity);
    }
}
