<?php

use Illuminate\Database\Migrations\Migration;
use App\Models\InventoryItem;
use App\Models\Supplier;
use App\Models\Purchase;
use App\Models\PurchaseDetail;
use App\Models\Category;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Supplier Setup for Sakib Telecom
        $supplier = Supplier::firstOrCreate(
            ['phone' => '01721120315'],
            [
                'name' => 'Sakib Telecom (সাকিব টেলিকম)',
                'address' => '3/169-170, Gulistan Shopping Complex (4th Floor), Bangabandhu Avenue, Dhaka-1000',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        // Category Map Helper
        $categories = [
            'Cable' => Category::firstOrCreate(['slug' => 'cable'], ['name' => 'Cable', 'status' => 'active'])->id,
            'Earphone' => Category::firstOrCreate(['slug' => 'earphone'], ['name' => 'Earphone', 'status' => 'active'])->id,
            'Charger' => Category::firstOrCreate(['slug' => 'charger'], ['name' => 'Charger', 'status' => 'active'])->id,
            'Charging Port' => Category::firstOrCreate(['slug' => 'charging-port'], ['name' => 'Charging Port', 'status' => 'active'])->id,
            'Cover' => Category::firstOrCreate(['slug' => 'cover'], ['name' => 'Cover', 'status' => 'active'])->id,
        ];

        // 28 Products Extracted from Sakib Telecom Memos (Date: 18.07.26)
        $memoProducts = [
            // Memo 1787
            [
                'name' => 'Type-C to Lightning Fast Cable (C to L)',
                'type' => 'accessory',
                'category' => 'Cable',
                'brand' => 'Generic',
                'purchase_price' => 100.00,
                'sale_price' => 180.00,
                'quantity' => 2,
            ],
            [
                'name' => 'Apple iPhone Wired Handsfree Earphone (iP HP)',
                'type' => 'accessory',
                'category' => 'Earphone',
                'brand' => 'Apple',
                'purchase_price' => 300.00,
                'sale_price' => 500.00,
                'quantity' => 1,
            ],
            [
                'name' => 'Apple Type-C Handsfree Earphone (Apple TE HP)',
                'type' => 'accessory',
                'category' => 'Earphone',
                'brand' => 'Apple',
                'purchase_price' => 220.00,
                'sale_price' => 400.00,
                'quantity' => 1,
            ],
            [
                'name' => 'Goo TE600 Stereo Earphone (Goo TE 600)',
                'type' => 'accessory',
                'category' => 'Earphone',
                'brand' => 'Goo',
                'purchase_price' => 250.00,
                'sale_price' => 450.00,
                'quantity' => 1,
            ],
            [
                'name' => 'Charm Handsfree Earphone (Charm HP)',
                'type' => 'accessory',
                'category' => 'Earphone',
                'brand' => 'Charm',
                'purchase_price' => 45.00,
                'sale_price' => 100.00,
                'quantity' => 10,
            ],
            [
                'name' => 'ABJ High Bass Earphone (ABJ HP)',
                'type' => 'accessory',
                'category' => 'Earphone',
                'brand' => 'ABJ',
                'purchase_price' => 50.00,
                'sale_price' => 120.00,
                'quantity' => 5,
            ],
            [
                'name' => 'OnePlus 65W SuperVooc Fast Charger (1+ 65W)',
                'type' => 'accessory',
                'category' => 'Charger',
                'brand' => 'OnePlus',
                'purchase_price' => 500.00,
                'sale_price' => 850.00,
                'quantity' => 1,
            ],
            [
                'name' => 'OnePlus 80W SuperVooc Fast Charger (1+ 80W)',
                'type' => 'accessory',
                'category' => 'Charger',
                'brand' => 'OnePlus',
                'purchase_price' => 520.00,
                'sale_price' => 900.00,
                'quantity' => 1,
            ],

            // Memo 1788
            [
                'name' => 'iPhone Charging Port Flex Assembly (IP Port)',
                'type' => 'spare_part',
                'category' => 'Charging Port',
                'brand' => 'Apple',
                'purchase_price' => 22.00,
                'sale_price' => 150.00,
                'quantity' => 10,
            ],
            [
                'name' => 'iPhone V8 Micro Charging Port Ribbon (IP Port V8)',
                'type' => 'spare_part',
                'category' => 'Charging Port',
                'brand' => 'Apple',
                'purchase_price' => 18.00,
                'sale_price' => 100.00,
                'quantity' => 20,
            ],
            [
                'name' => 'Type-C Universal Charging Port Socket (TE Port)',
                'type' => 'spare_part',
                'category' => 'Charging Port',
                'brand' => 'Generic',
                'purchase_price' => 12.50,
                'sale_price' => 80.00,
                'quantity' => 20,
            ],
            [
                'name' => 'USB to Type-C Short Fast Cable (USB to TE)',
                'type' => 'accessory',
                'category' => 'Cable',
                'brand' => 'Generic',
                'purchase_price' => 18.00,
                'sale_price' => 80.00,
                'quantity' => 10,
            ],
            [
                'name' => 'Delone V8 Micro USB Fast Charging Cable (Delone Col V8)',
                'type' => 'accessory',
                'category' => 'Cable',
                'brand' => 'Delone',
                'purchase_price' => 55.00,
                'sale_price' => 120.00,
                'quantity' => 5,
            ],
            [
                'name' => 'Delone Type-C Fast Charging Cable (Delone Col TE)',
                'type' => 'accessory',
                'category' => 'Cable',
                'brand' => 'Delone',
                'purchase_price' => 60.00,
                'sale_price' => 130.00,
                'quantity' => 5,
            ],
            [
                'name' => '33W Super Fast Copper Charging Cable (33W Cable)',
                'type' => 'accessory',
                'category' => 'Cable',
                'brand' => 'Generic',
                'purchase_price' => 30.00,
                'sale_price' => 80.00,
                'quantity' => 20,
            ],
            [
                'name' => 'USB to iPhone Lightning Data Cable (USB to IP Cable)',
                'type' => 'accessory',
                'category' => 'Cable',
                'brand' => 'Apple',
                'purchase_price' => 70.00,
                'sale_price' => 150.00,
                'quantity' => 5,
            ],

            // Memo 1789
            [
                'name' => 'OnePlus 100W SuperVooc Power Adapter (1+ 100W)',
                'type' => 'accessory',
                'category' => 'Charger',
                'brand' => 'OnePlus',
                'purchase_price' => 550.00,
                'sale_price' => 950.00,
                'quantity' => 1,
            ],
            [
                'name' => 'OnePlus 120W SuperVooc Ultra Adapter (1+ 120W)',
                'type' => 'accessory',
                'category' => 'Charger',
                'brand' => 'OnePlus',
                'purchase_price' => 550.00,
                'sale_price' => 980.00,
                'quantity' => 1,
            ],
            [
                'name' => 'Universal 33W Fast Charging Adapter (Universal 33W)',
                'type' => 'accessory',
                'category' => 'Charger',
                'brand' => 'Generic',
                'purchase_price' => 250.00,
                'sale_price' => 450.00,
                'quantity' => 5,
            ],
            [
                'name' => 'Vivo 44W FlashCharge Wall Adapter (Vivo 44W)',
                'type' => 'accessory',
                'category' => 'Charger',
                'brand' => 'Vivo',
                'purchase_price' => 400.00,
                'sale_price' => 750.00,
                'quantity' => 1,
            ],
            [
                'name' => 'Oppo 45W SuperVooc Fast Charger (OPPO 45W)',
                'type' => 'accessory',
                'category' => 'Charger',
                'brand' => 'Oppo',
                'purchase_price' => 400.00,
                'sale_price' => 750.00,
                'quantity' => 1,
            ],
            [
                'name' => 'Oppo 33W SuperVooc Fast Charger (OPPO 33W)',
                'type' => 'accessory',
                'category' => 'Charger',
                'brand' => 'Oppo',
                'purchase_price' => 370.00,
                'sale_price' => 680.00,
                'quantity' => 1,
            ],
            [
                'name' => 'Xiaomi Mi 33W SonicCharge Adapter (Mi 33W)',
                'type' => 'accessory',
                'category' => 'Charger',
                'brand' => 'Xiaomi',
                'purchase_price' => 480.00,
                'sale_price' => 850.00,
                'quantity' => 1,
            ],
            [
                'name' => 'Xiaomi Mi 67W SonicCharge Ultra Adapter (Mi 67W)',
                'type' => 'accessory',
                'category' => 'Charger',
                'brand' => 'Xiaomi',
                'purchase_price' => 500.00,
                'sale_price' => 900.00,
                'quantity' => 1,
            ],

            // Memo 1790
            [
                'name' => 'Oraimo 200m Bluetooth Wireless Neckband (Oaimo 200m)',
                'type' => 'accessory',
                'category' => 'Earphone',
                'brand' => 'Oraimo',
                'purchase_price' => 380.00,
                'sale_price' => 650.00,
                'quantity' => 1,
            ],
            [
                'name' => 'Goo Bluetooth Wireless Neckband (Goo Neckband)',
                'type' => 'accessory',
                'category' => 'Earphone',
                'brand' => 'Goo',
                'purchase_price' => 400.00,
                'sale_price' => 700.00,
                'quantity' => 1,
            ],
            [
                'name' => 'Hoco 500m Sports Wireless Neckband (Hoco 500m)',
                'type' => 'accessory',
                'category' => 'Earphone',
                'brand' => 'Hoco',
                'purchase_price' => 450.00,
                'sale_price' => 800.00,
                'quantity' => 1,
            ],

            // Memo 1791
            [
                'name' => 'Nokia 3300 Full Body Housing Casing (3300 Body)',
                'type' => 'spare_part',
                'category' => 'Cover',
                'brand' => 'Nokia',
                'purchase_price' => 120.00,
                'sale_price' => 250.00,
                'quantity' => 4,
            ],
        ];

        // Create Purchase Batch Record if not already created
        $purchase = Purchase::firstOrCreate(
            ['purchase_no' => 'PUR-SAKIB-20260718-001'],
            [
                'supplier_id' => $supplier->id,
                'total_amount' => 13035.00,
                'purchase_date' => '2026-07-18',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        $index = 101;
        foreach ($memoProducts as $prod) {
            $skuPrefix = $prod['type'] === 'spare_part' ? 'PART' : 'ACCS';
            $catCode = strtoupper(substr($prod['category'], 0, 4));
            $sku = "{$skuPrefix}-{$catCode}-" . str_pad($index, 4, '0', STR_PAD_LEFT);
            $barcode = '6940' . str_pad($index, 8, '0', STR_PAD_LEFT);

            $item = InventoryItem::firstOrCreate(
                ['name' => $prod['name']],
                [
                    'sku' => $sku,
                    'barcode' => $barcode,
                    'type' => $prod['type'],
                    'category' => $prod['category'],
                    'category_id' => $categories[$prod['category']] ?? null,
                    'brand' => $prod['brand'],
                    'quantity' => $prod['quantity'],
                    'alert_quantity' => 3,
                    'purchase_price' => $prod['purchase_price'],
                    'sale_price' => $prod['sale_price'],
                    'product_type' => 'single',
                    'supplier_id' => $supplier->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );

            // Create detail record if not present
            PurchaseDetail::firstOrCreate([
                'purchase_id' => $purchase->id,
                'inventory_item_id' => $item->id,
            ], [
                'quantity' => $prod['quantity'],
                'cost_price' => $prod['purchase_price'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $index++;
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No-op for safety
    }
};
