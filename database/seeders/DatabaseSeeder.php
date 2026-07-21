<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Customer;
use App\Models\Supplier;
use App\Models\InventoryItem;
use App\Models\Repair;
use App\Models\Purchase;
use App\Models\PurchaseDetail;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\Expense;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed Users (Roles: super_admin, technician, salesman)
        $admin = User::create([
            'name' => 'M3 Super Admin',
            'email' => 'admin@m3mobile.com',
            'password' => Hash::make('admin123'),
            'role' => 'super_admin',
            'phone' => '01700000001',
            'skill_level' => 'Master Technician',
            'experience' => '8 years',
            'branch' => 'Dhaka Main',
        ]);

        $tech1 = User::create([
            'name' => 'John Technician',
            'email' => 'tech@m3mobile.com',
            'password' => Hash::make('tech123'),
            'role' => 'technician',
            'phone' => '01700000002',
            'skill_level' => 'Senior Technician (Level 2)',
            'experience' => '4 years',
            'branch' => 'Dhaka Main',
        ]);

        $tech2 = User::create([
            'name' => 'Abir Tech',
            'email' => 'abir@m3mobile.com',
            'password' => Hash::make('tech123'),
            'role' => 'technician',
            'phone' => '01700000003',
            'skill_level' => 'Junior Technician (Level 1)',
            'experience' => '1.5 years',
            'branch' => 'Dhaka Main',
        ]);

        $sales = User::create([
            'name' => 'Kamal Salesman',
            'email' => 'sales@m3mobile.com',
            'password' => Hash::make('sales123'),
            'role' => 'salesman',
            'phone' => '01700000004',
            'branch' => 'Dhaka Main',
        ]);

        $manager = User::create([
            'name' => 'Manager Admin',
            'email' => 'manager@m3mobile.com',
            'password' => Hash::make('manager123'),
            'role' => 'admin',
            'phone' => '01700000005',
            'branch' => 'Dhaka Main',
        ]);

        // 2. Seed Customers
        $c1 = Customer::create([
            'name' => 'Rahim Ali',
            'phone' => '01711223344',
            'alt_phone' => '01811223344',
            'email' => 'rahim@gmail.com',
            'address' => '12/A, Dhanmondi',
            'district' => 'Dhaka',
        ]);

        $c2 = Customer::create([
            'name' => 'Karim Ahmed',
            'phone' => '01922334455',
            'email' => 'karim@yahoo.com',
            'address' => 'Mirpur 10, Block C',
            'district' => 'Dhaka',
        ]);

        $c3 = Customer::create([
            'name' => 'Sultana Begum',
            'phone' => '01633445566',
            'address' => 'Oxygen, Bayezid Bostami',
            'district' => 'Chittagong',
        ]);

        $c4 = Customer::create([
            'name' => 'Tanvir Rahman',
            'phone' => '01544556677',
            'address' => 'Zindabazar',
            'district' => 'Sylhet',
        ]);

        // 3. Seed Suppliers
        $sup1 = Supplier::create([
            'name' => 'Dhaka Parts Depot',
            'phone' => '01988888888',
            'address' => 'Motijheel C/A, Dhaka',
        ]);

        $sup2 = Supplier::create([
            'name' => 'Smart Accessories Co.',
            'phone' => '01877777777',
            'address' => 'Chawkbazar, Dhaka',
        ]);

        // Create standard categories
        $categoryNames = [
            'Display', 'Battery', 'Charging Port', 'Back Glass', 'IC',
            'Charger', 'Cable', 'Earphone', 'Power Bank', 'Cover', 'Glass Protector'
        ];
        $categoryMap = [];
        foreach ($categoryNames as $catName) {
            $cat = Category::create([
                'name' => $catName,
                'slug' => Str::slug($catName),
                'status' => 'active',
            ]);
            $categoryMap[$catName] = $cat->id;
        }

        // 4. Seed Inventory Items (Spare Parts and Accessories) - 100 Products with variants
        $brands = ['Apple', 'Samsung', 'Google', 'Xiaomi', 'OnePlus', 'Realme', 'Anker', 'Baseus', 'Joyroom', 'Remax'];
        
        $categoriesList = [
            'Display' => [
                'name' => 'OLED Screen Display Assembly',
                'image' => 'inventory/s23u_display_assembly.png',
                'type' => 'spare_part',
                'variations' => [
                    'variation' => 'Quality',
                    'values' => ['Original', 'OEM', 'Copy'],
                    'prices' => [12000, 7500, 4500],
                    'costs' => [9000, 5000, 3000]
                ]
            ],
            'Battery' => [
                'name' => 'Replacement High Capacity Battery',
                'image' => 'inventory/pixel7_pro_battery.png',
                'type' => 'spare_part',
                'variations' => [
                    'variation' => 'Quality',
                    'values' => ['Original', 'Premium Copy'],
                    'prices' => [2800, 1500],
                    'costs' => [1800, 900]
                ]
            ],
            'Back Glass' => [
                'name' => 'Back Glass Housing Cover Panel',
                'image' => 'inventory/iphone15pm_back_glass.png',
                'type' => 'spare_part',
                'variations' => [
                    'variation' => 'Color',
                    'values' => ['Titanium Gray', 'Titanium Black', 'Titanium Silver'],
                    'prices' => [4500, 4500, 4500],
                    'costs' => [3000, 3000, 3000]
                ]
            ],
            'Charging Port' => [
                'name' => 'USB-C Charging Port Flex Ribbon',
                'image' => 'inventory/ipad_pro_charging_port.png',
                'type' => 'spare_part',
                'variations' => [
                    'variation' => 'Quality',
                    'values' => ['Original', 'OEM'],
                    'prices' => [1800, 1000],
                    'costs' => [1100, 600]
                ]
            ],
            'Charger' => [
                'name' => 'PD Fast Charging Wall Adapter',
                'image' => 'inventory/anker_nano_charger.png',
                'type' => 'accessory',
                'variations' => [
                    'variation' => 'Color',
                    'values' => ['White', 'Black'],
                    'prices' => [1850, 1850],
                    'costs' => [1200, 1200]
                ]
            ],
            'Cable' => [
                'name' => 'Super Fast Charging Cable',
                'image' => 'inventory/baseus_typec_cable.png',
                'type' => 'accessory',
                'variations' => [
                    'variation' => 'Length',
                    'values' => ['1 Meter', '2 Meter'],
                    'prices' => [500, 650],
                    'costs' => [300, 400]
                ]
            ],
            'Earphone' => [
                'name' => 'TWS Bluetooth ANC Wireless Earbuds',
                'image' => 'inventory/joyroom_t03s_earbuds.png',
                'type' => 'accessory',
                'variations' => [
                    'variation' => 'Color',
                    'values' => ['White', 'Black'],
                    'prices' => [2450, 2450],
                    'costs' => [1600, 1600]
                ]
            ],
            'Power Bank' => [
                'name' => 'Fast Charging Power Bank',
                'image' => 'inventory/remax_powerbank.png',
                'type' => 'accessory',
                'variations' => [
                    'variation' => 'Capacity',
                    'values' => ['10000mAh', '20000mAh'],
                    'prices' => [1250, 1950],
                    'costs' => [800, 1300]
                ]
            ],
            'Cover' => [
                'name' => 'Premium Silicone Protective Case',
                'image' => 'inventory/remax_powerbank.png',
                'type' => 'accessory',
                'variations' => [
                    'variation' => 'Color',
                    'values' => ['Midnight Black', 'Navy Blue', 'Forest Green'],
                    'prices' => [450, 450, 450],
                    'costs' => [250, 250, 250]
                ]
            ],
            'Glass Protector' => [
                'name' => '9D Tempered Glass Screen Protector',
                'image' => 'inventory/s23u_display_assembly.png',
                'type' => 'accessory',
                'variations' => [
                    'variation' => 'Pack Size',
                    'values' => ['Single Pack', 'Double Pack'],
                    'prices' => [250, 450],
                    'costs' => [120, 200]
                ]
            ],
            'IC' => [
                'name' => 'Power Management IC Chip PM8953',
                'image' => 'inventory/pixel7_pro_battery.png',
                'type' => 'spare_part',
                'variations' => [
                    'variation' => 'Quality',
                    'values' => ['Original', 'OEM'],
                    'prices' => [450, 300],
                    'costs' => [250, 150]
                ]
            ]
        ];

        $models = [
            'iPhone 13', 'iPhone 13 Pro', 'iPhone 14', 'iPhone 14 Pro Max', 'iPhone 15', 'iPhone 15 Pro Max',
            'Galaxy S22', 'Galaxy S22 Ultra', 'Galaxy S23', 'Galaxy S23 Ultra', 'Galaxy S24',
            'Pixel 6 Pro', 'Pixel 7 Pro', 'Pixel 8 Pro', 'Redmi Note 11', 'Redmi Note 12 Pro', 'Realme GT 3'
        ];

        $counter = 0;
        $categoriesKeys = array_keys($categoriesList);

        while ($counter < 100) {
            $brand = $brands[$counter % count($brands)];
            $categoryName = $categoriesKeys[$counter % count($categoriesKeys)];
            $categoryConfig = $categoriesList[$categoryName];
            $modelName = $models[$counter % count($models)];

            if ($categoryConfig['type'] === 'spare_part') {
                $name = "{$brand} {$modelName} {$categoryConfig['name']}";
            } else {
                $name = "{$brand} {$categoryConfig['name']}";
            }

            // Every 3rd product is variable
            $isVariable = ($counter % 3 === 0);
            
            $skuPrefix = $categoryConfig['type'] === 'spare_part' ? 'PART' : 'ACCS';
            $categoryCode = strtoupper(substr($categoryName, 0, 4));
            $sku = "{$skuPrefix}-{$categoryCode}-" . str_pad($counter + 1, 4, '0', STR_PAD_LEFT);
            $barcode = '69402681' . str_pad($counter + 1, 3, '0', STR_PAD_LEFT);

            $purchasePrice = $categoryConfig['variations']['costs'][0];
            $salePrice = $categoryConfig['variations']['prices'][0];

            $itemVariants = null;
            if ($isVariable) {
                $varDef = $categoryConfig['variations'];
                $varList = [];
                foreach ($varDef['values'] as $i => $value) {
                    $varList[] = [
                        'variation' => $varDef['variation'],
                        'value' => $value,
                        'sku' => "{$sku}-" . strtoupper(substr(str_replace(' ', '', $value), 0, 2)),
                        'quantity' => rand(5, 30),
                        'price' => $varDef['prices'][$i]
                    ];
                }
                $itemVariants = $varList;
                $quantity = array_sum(array_column($varList, 'quantity'));
            } else {
                $quantity = rand(10, 50);
            }

            // Build dynamic record
            $itemData = [
                'name' => $name,
                'sku' => $sku,
                'barcode' => $barcode,
                'type' => $categoryConfig['type'],
                'category' => $categoryName,
                'brand' => $brand,
                'quantity' => $quantity,
                'alert_quantity' => 5,
                'purchase_price' => $purchasePrice,
                'sale_price' => $salePrice,
                'product_type' => $isVariable ? 'variable' : 'single',
                'variants' => $itemVariants, // php array will cast correctly to JSON
                'images' => [$categoryConfig['image']], // php array will cast correctly to JSON
                'supplier_id' => $categoryConfig['type'] === 'spare_part' ? $sup1->id : $sup2->id,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            // Map category_id
            if (isset($categoryMap[$categoryName])) {
                $itemData['category_id'] = $categoryMap[$categoryName];
            }

            InventoryItem::create($itemData);

            $counter++;
        }

        // 5. Seed Purchases
        $p1 = Purchase::create([
            'purchase_no' => 'PUR-202607-0001',
            'supplier_id' => $sup1->id,
            'total_amount' => 15800.00,
            'purchase_date' => now()->subDays(10)->toDateString(),
        ]);
        // Samsung Display
        PurchaseDetail::create([
            'purchase_id' => $p1->id,
            'inventory_item_id' => 2,
            'quantity' => 1,
            'cost_price' => 14000.00,
        ]);
        // Pixel Battery
        PurchaseDetail::create([
            'purchase_id' => $p1->id,
            'inventory_item_id' => 3,
            'quantity' => 1,
            'cost_price' => 1800.00,
        ]);

        // 6. Seed Sales
        $s1 = Sale::create([
            'invoice_no' => 'INV-202607-0001',
            'customer_id' => $c1->id,
            'total_amount' => 4300.00,
            'discount' => 300.00,
            'payable_amount' => 4000.00,
            'paid_amount' => 4000.00,
            'due_amount' => 0.00,
            'payment_method' => 'Cash',
            'salesman_id' => $sales->id,
            'created_at' => now()->subDays(3),
        ]);
        // Anker Charger
        SaleDetail::create([
            'sale_id' => $s1->id,
            'inventory_item_id' => 5,
            'quantity' => 1,
            'sale_price' => 1850.00,
        ]);
        // Joyroom Earbuds
        SaleDetail::create([
            'sale_id' => $s1->id,
            'inventory_item_id' => 7,
            'quantity' => 1,
            'sale_price' => 2450.00,
        ]);

        $s2 = Sale::create([
            'invoice_no' => 'INV-202607-0002',
            'customer_id' => null, // Walk-in
            'total_amount' => 1300.00,
            'discount' => 100.00,
            'payable_amount' => 1200.00,
            'paid_amount' => 1200.00,
            'due_amount' => 0.00,
            'payment_method' => 'bKash',
            'salesman_id' => $sales->id,
            'created_at' => now()->subHours(4),
        ]);
        // Baseus Cable
        SaleDetail::create([
            'sale_id' => $s2->id,
            'inventory_item_id' => 6,
            'quantity' => 2,
            'sale_price' => 650.00,
        ]);

        // 7. Seed Repairs (Job Cards)
        $repairs = [
            [
                'ticket_id' => 'M3-202607-0001',
                'customer_id' => $c1->id,
                'device_brand' => 'Apple',
                'device_model' => 'iPhone 13 Pro',
                'serial_imei' => '357283920193847',
                'issue_description' => 'Dropped in water, display flickering, touch not working.',
                'password_pattern' => 'Pattern: L-shape starting top-left, Pin: 4829',
                'status' => 'repairing',
                'estimated_cost' => 6500.00,
                'advance_payment' => 1000.00,
                'actual_cost' => null,
                'technician_notes' => 'Opened phone. Found water residue. Board ultrasonic cleaning complete. Replacing display panel to test screen flicker.',
                'assigned_technician_id' => $tech1->id,
                'expected_delivery_date' => now()->addDays(3)->toDateString(),
                'created_at' => now()->subDays(2),
                'updated_at' => now()->subDays(1),
            ],
            [
                'ticket_id' => 'M3-202607-0002',
                'customer_id' => $c2->id,
                'device_brand' => 'Samsung',
                'device_model' => 'Galaxy S22',
                'serial_imei' => '351938472918374',
                'issue_description' => 'Back glass cracked, battery draining fast.',
                'password_pattern' => 'Pattern: None. Pin: 0000',
                'status' => 'diagnosing',
                'estimated_cost' => 3500.00,
                'advance_payment' => 500.00,
                'actual_cost' => null,
                'technician_notes' => 'Assigned to diagnose battery degradation. Initial battery health reading: 68%. Waiting to approve battery replacement.',
                'assigned_technician_id' => $tech1->id,
                'expected_delivery_date' => now()->addDays(2)->toDateString(),
                'created_at' => now()->subHours(5),
                'updated_at' => now()->subHours(5),
            ],
            [
                'ticket_id' => 'M3-202607-0003',
                'customer_id' => $c3->id,
                'device_brand' => 'Xiaomi',
                'device_model' => 'Redmi Note 10',
                'serial_imei' => '863920193847291',
                'issue_description' => 'USB port broken, doesn\'t charge at all.',
                'password_pattern' => 'No locks on device.',
                'status' => 'delivered',
                'estimated_cost' => 800.00,
                'advance_payment' => 0.00,
                'actual_cost' => 800.00,
                'technician_notes' => 'Replaced charging flex cable assembly. Tested draws 1.8A. Device delivered to customer and paid cash.',
                'assigned_technician_id' => $tech2->id,
                'expected_delivery_date' => now()->subDays(1)->toDateString(),
                'created_at' => now()->subDays(4),
                'updated_at' => now()->subDays(1),
            ],
            [
                'ticket_id' => 'M3-202607-0004',
                'customer_id' => $c4->id,
                'device_brand' => 'Realme',
                'device_model' => 'Realme GT',
                'serial_imei' => null,
                'issue_description' => 'Cracked screen.',
                'password_pattern' => 'Pattern: Diagonal slash top-left to bottom-right.',
                'status' => 'waiting_for_approval',
                'estimated_cost' => 3000.00,
                'advance_payment' => 1500.00,
                'actual_cost' => null,
                'technician_notes' => 'Screen panel is cracked. Customer wants original display, but we only have OEM in stock. Waiting for approval to order original part.',
                'assigned_technician_id' => $tech2->id,
                'expected_delivery_date' => now()->addDays(5)->toDateString(),
                'created_at' => now()->subDays(3),
                'updated_at' => now()->subDays(2),
            ],
        ];

        DB::table('repairs')->insert($repairs);

        // 8. Seed Expenses
        $expenses = [
            [
                'category' => 'Rent',
                'amount' => 15000.00,
                'description' => 'Multiplan Center Shop Rent for June 2026',
                'expense_date' => now()->subDays(7)->toDateString(),
                'created_at' => now()->subDays(7),
                'updated_at' => now()->subDays(7),
            ],
            [
                'category' => 'Salary',
                'amount' => 12000.00,
                'description' => 'Salary advance to Abir Tech',
                'expense_date' => now()->subDays(5)->toDateString(),
                'created_at' => now()->subDays(5),
                'updated_at' => now()->subDays(5),
            ],
            [
                'category' => 'Utility',
                'amount' => 2300.00,
                'description' => 'Electricity bill Shop 14',
                'expense_date' => now()->subDays(4)->toDateString(),
                'created_at' => now()->subDays(4),
                'updated_at' => now()->subDays(4),
            ],
            [
                'category' => 'Purchase',
                'amount' => 12500.00,
                'description' => 'Purchased Display & Battery stock - PUR-202607-0001',
                'expense_date' => now()->subDays(10)->toDateString(),
                'created_at' => now()->subDays(10),
                'updated_at' => now()->subDays(10),
            ]
        ];

        DB::table('expenses')->insert($expenses);

        // 9. Seed Default Settings
        \App\Models\Setting::set('shop_name', 'M3 Mobile Care');
        \App\Models\Setting::set('shop_slogan', 'Premium Mobile Repair & Retail');
        \App\Models\Setting::set('phone', '+880 1712-345678');
        \App\Models\Setting::set('email', 'info@m3mobilecare.com');
        \App\Models\Setting::set('address', 'Shop 14, Level 3, Multiplan Center, Elephant Road, Dhaka');
        \App\Models\Setting::set('receipt_footer', "TERMS & CONDITIONS:\n1. 30 Days warranty on replaced spare parts (Except liquid/physical damage).\n2. No warranty on software flash or touch calibration adjustment.\n3. Please collect device within 30 days of repair completion.\n4. Show repair slip for pickup.");

        // 10. Seed Partner Balances
        DB::table('partner_balances')->insert([
            [
                'partner_name' => 'Monowar Munna',
                'capital_balance' => 450000.00,
                'accumulated_profit' => 0.00,
                'payback_completed_at' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'partner_name' => 'Munna Raihan',
                'capital_balance' => 50000.00,
                'accumulated_profit' => 0.00,
                'payback_completed_at' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'partner_name' => 'Mosiur',
                'capital_balance' => 50000.00,
                'accumulated_profit' => 0.00,
                'payback_completed_at' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
