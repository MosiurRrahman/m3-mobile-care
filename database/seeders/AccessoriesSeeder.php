<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\InventoryItem;
use App\Models\Category;
use Illuminate\Support\Str;

class AccessoriesSeeder extends Seeder
{
    public function run()
    {
        // 1. Create or find Categories
        $categoriesData = [
            'Chargers & Adapters',
            'Charging Cables',
            'Back Covers & Cases',
            'Tempered Glass & Protectors',
            'Earphones & TWS',
            'Power Banks',
            'Smartwatches & Bands',
            'Car Mounts & Holders',
            'Bluetooth Speakers',
            'Gaming Accessories',
        ];

        $categories = [];
        foreach ($categoriesData as $catName) {
            $categories[$catName] = Category::firstOrCreate(
                ['name' => $catName],
                ['slug' => Str::slug($catName), 'status' => 'active']
            );
        }

        // 2. Sample Unsplash & Template Images
        $localImages = [
            'frontend/img/product-img-1.jpg',
            'frontend/img/product-img-2.jpg',
            'frontend/img/product-img-3.jpg',
            'frontend/img/product-img-4.jpg',
            'frontend/img/product-img-5.jpg',
            'frontend/img/product-img-6.jpg',
            'frontend/img/product-img-sm-1.jpg',
            'frontend/img/product-img-sm-2.jpg',
            'frontend/img/product-img-sm-3.jpg',
            'frontend/img/product-img-sm-4.jpg',
            'frontend/img/product-img-sm-5.jpg',
            'frontend/img/product-img-sm-6.jpg',
        ];

        $unsplashImages = [
            'https://images.unsplash.com/photo-1583394838336-acd977736f90?w=600&auto=format&fit=crop&q=80',
            'https://images.unsplash.com/photo-1546435770-a3e426bf472b?w=600&auto=format&fit=crop&q=80',
            'https://images.unsplash.com/photo-1608156639585-b3a032ef9689?w=600&auto=format&fit=crop&q=80',
            'https://images.unsplash.com/photo-1572569511254-d8f925fe2cbb?w=600&auto=format&fit=crop&q=80',
            'https://images.unsplash.com/photo-1590658268037-6bf12165a8df?w=600&auto=format&fit=crop&q=80',
            'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=600&auto=format&fit=crop&q=80',
            'https://images.unsplash.com/photo-1575695342320-d2d2d2f9b73f?w=600&auto=format&fit=crop&q=80',
            'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=600&auto=format&fit=crop&q=80',
            'https://images.unsplash.com/photo-1563770660941-20978e870e26?w=600&auto=format&fit=crop&q=80',
            'https://images.unsplash.com/photo-1622445268465-843dcb44f9dc?w=600&auto=format&fit=crop&q=80',
        ];

        // 3. 50 Realistic Products Data
        $products = [
            // Chargers & Adapters (1-5)
            ['Anker 20W PowerPort III Nano Fast Charger', 'Chargers & Adapters', 'Anker', 'Nano 20W', 1250, 1500, 'Original 20W USB-C Power Adapter for iPhone and Android.'],
            ['Baseus Super Si Quick Charger 30W', 'Chargers & Adapters', 'Baseus', 'Super Si 30W', 1400, 1750, '30W Type-C Super Fast Wall Charger with Smart Temperature Control.'],
            ['Samsung Original 25W Type-C Super Fast Charger', 'Chargers & Adapters', 'Samsung', 'EP-TA800', 1600, 1950, 'Original Samsung 25W PPS Super Fast Charging Adapter.'],
            ['Apple 20W USB-C Power Adapter', 'Chargers & Adapters', 'Apple', 'MHJE3ZM/A', 2200, 2650, 'Genuine Apple 20W Fast Charger for iPhone 12, 13, 14, 15 series.'],
            ['Joyroom 65W GaN 3-Port Fast Wall Charger', 'Chargers & Adapters', 'Joyroom', 'JR-TCF06', 2800, 3400, '65W GaN Fast Charger with Dual Type-C and USB-A Ports for Laptops & Mobiles.'],

            // Charging Cables (6-10)
            ['Baseus Cafule 100W PD Type-C to Type-C Cable 2m', 'Charging Cables', 'Baseus', '100W PD', 650, 850, 'Nylon Braided 100W Fast Charging & Data Cable for MacBooks & Phones.'],
            ['Anker PowerLine II Lightning Cable 3ft', 'Charging Cables', 'Anker', 'A8432', 850, 1100, 'MFi Certified Heavy Duty Lightning Cable for Apple Devices.'],
            ['Ugreen 60W Type-C to Type-C Fast Charge Cable', 'Charging Cables', 'Ugreen', 'US286', 500, 680, '60W PD Fast Charging Cable with Zinc Alloy Connectors.'],
            ['Remax Lesu 3-in-1 Fast Charging Cable', 'Charging Cables', 'Remax', 'RC-050t', 350, 480, 'Multi-functional 3-in-1 Cable with Type-C, Lightning, and Micro-USB.'],
            ['Hoco X14 Times Speed Type-C Cable 1m', 'Charging Cables', 'Hoco', 'X14', 220, 320, 'Durable Nylon Braided 3A Fast Charging Cable.'],

            // Back Covers & Cases (11-15)
            ['Nillkin CamShield Pro Case for iPhone 15 Pro Max', 'Back Covers & Cases', 'Nillkin', 'iPhone 15 Pro Max', 950, 1250, 'Camera Protection Slide Case with Anti-Scratch PC Material.'],
            ['Baseus Magnetic Magsafe Clear Case for iPhone 14', 'Back Covers & Cases', 'Baseus', 'iPhone 14', 750, 980, 'Crystal Clear Protective Case with Strong Magsafe Magnets.'],
            ['Spigen Tough Armor Case for Samsung S24 Ultra', 'Back Covers & Cases', 'Spigen', 'S24 Ultra', 1800, 2300, 'Dual Layer Shockproof Armor Case with Built-in Kickstand.'],
            ['Xundd Shockproof Airbag Case for Redmi Note 13 Pro', 'Back Covers & Cases', 'Xundd', 'Redmi Note 13 Pro', 550, 750, 'Airbag Technology Drop-Resistant Transparent Back Cover.'],
            ['Devilcase Guardian Case for Samsung A54 5G', 'Back Covers & Cases', 'Devilcase', 'Galaxy A54', 680, 890, 'Matte Finish Heavy Duty Protective Case.'],

            // Tempered Glass & Protectors (16-20)
            ['Nillkin H+Pro 2.5D Arc Edge Tempered Glass', 'Tempered Glass & Protectors', 'Nillkin', 'Universal HD', 450, 650, '9H Hardness Ultra Thin Anti-Explosion Glass Protector.'],
            ['Baseus 0.3mm Full Coverage Privacy Glass', 'Tempered Glass & Protectors', 'Baseus', 'Privacy Shield', 600, 850, 'Anti-Spy Privacy Glass with Oil-Resistant Oleophobic Coating.'],
            ['Remax 11D Full Curved Tempered Glass', 'Tempered Glass & Protectors', 'Remax', '11D Curved', 250, 380, 'Edge to Edge 11D HD Tempered Screen Protector.'],
            ['Joyroom Dust-Proof HD Tempered Glass Pack', 'Tempered Glass & Protectors', 'Joyroom', 'Dust-Proof', 400, 580, 'Easy Installation Tray Glass Protector with Speaker Dust Filter.'],
            ['Gorilla Glass 9H Matte Gaming Screen Guard', 'Tempered Glass & Protectors', 'Gorilla', 'Matte Gaming', 300, 450, 'Anti-Fingerprint Matte Finish Glass for Smooth Gaming Experience.'],

            // Earphones & TWS (21-25)
            ['Realme Buds Air 5 Pro ANC TWS Earbuds', 'Earphones & TWS', 'Realme', 'Air 5 Pro', 4200, 5200, '50dB Active Noise Cancellation with Hi-Res Audio & Dual Drivers.'],
            ['Anker Soundcore Life P2 Mini TWS', 'Earphones & TWS', 'Anker', 'A3944', 2800, 3500, 'Big Bass 10mm Drivers with 32 Hours Playtime & IPX5 Waterproof.'],
            ['Xiaomi Redmi Buds 4 Active Bluetooth Earbuds', 'Earphones & TWS', 'Xiaomi', 'M2232E1', 1650, 2100, '12mm Dynamic Driver with Google Fast Pair & 28H Battery.'],
            ['Joyroom JR-T03S Pro ANC Wireless Earbuds', 'Earphones & TWS', 'Joyroom', 'JR-T03S Pro', 2200, 2750, 'Active Noise Cancelling TWS with Wireless Charging Case.'],
            ['Boat BassHeads 100 In-Ear Wired Earphones', 'Earphones & TWS', 'Boat', 'BassHeads 100', 450, 650, 'Hawk Inspired Design with Super Extra Bass & HD Microphone.'],

            // Power Banks (26-30)
            ['Anker 525 Power Bank 20000mAh 20W PD', 'Power Banks', 'Anker', 'A1363', 3400, 4200, 'High Capacity 20000mAh Power Bank with 20W USB-C Fast Charging.'],
            ['Baseus Adaman 65W Metal Power Bank 20000mAh', 'Power Banks', 'Baseus', 'Adaman 65W', 4800, 5800, '65W Fast Charging Power Bank suitable for Laptops and Smartphones.'],
            ['Xiaomi Mi Power Bank 3 10000mAh 22.5W', 'Power Banks', 'Xiaomi', 'PB100DZM', 1750, 2200, 'Dual Input & Triple Output 22.5W Fast Charging Power Bank.'],
            ['Joyroom 10000mAh 20W Magnetic Wireless Power Bank', 'Power Banks', 'Joyroom', 'JR-W020', 2500, 3100, 'Magsafe Wireless 15W Charging + 20W Wired Fast Output Power Bank.'],
            ['Remax RPP-296 20000mAh Dual USB Power Bank', 'Power Banks', 'Remax', 'RPP-296', 1350, 1750, 'Slim & Portable 20000mAh Battery Pack.'],

            // Smartwatches & Bands (31-35)
            ['Haylou Solar Plus RT3 Smartwatch with AMOLED Display', 'Smartwatches & Bands', 'Haylou', 'RT3', 3400, 4200, '1.43 Inch AMOLED Display with Bluetooth Calling & SpO2 Heart Rate Monitor.'],
            ['Xiaomi Smart Band 8 Fitness Tracker', 'Smartwatches & Bands', 'Xiaomi', 'Band 8', 3600, 4400, '1.62 Inch AMOLED 60Hz Screen with 150+ Sports Modes.'],
            ['Kieslect Ks Pro Bluetooth Calling Smartwatch', 'Smartwatches & Bands', 'Kieslect', 'Ks Pro', 5800, 6900, '2.01 Inch Retina AMOLED Display with AI Voice Assistant.'],
            ['Amofit W26 Plus Smartwatch with Heart Rate Sensor', 'Smartwatches & Bands', 'Amofit', 'W26+', 1450, 1850, 'Full Touch Display with Sleep & Step Counter.'],
            ['Fire-Boltt Ninja Call Pro Plus Smartwatch', 'Smartwatches & Bands', 'Fire-Boltt', 'Ninja Call', 2200, 2800, '1.83 Inch Large Screen with Bluetooth Calling.'],

            // Car Mounts & Holders (36-40)
            ['Baseus Osculum Type Gravity Car Mount Holder', 'Car Mounts & Holders', 'Baseus', 'SUYL-XP01', 750, 950, 'Strong Suction Base Gravity Phone Holder for Dashboard & Windshield.'],
            ['Joyroom Magsafe Car Wireless Charger Mount 15W', 'Car Mounts & Holders', 'Joyroom', 'JR-ZS240', 1650, 2100, '15W Magsafe Fast Charging Air Vent Car Phone Holder.'],
            ['Ugreen Air Vent Gravity Car Phone Mount', 'Car Mounts & Holders', 'Ugreen', 'LP130', 650, 850, 'Auto Lock Gravity Clamp for 4.7 to 7.2 Inch Phones.'],
            ['Remax RM-C50 Flexible Long Arm Phone Holder', 'Car Mounts & Holders', 'Remax', 'RM-C50', 550, 750, '360 Degree Rotating Desk Bed Flexible Gooseneck Clamp.'],
            ['Baseus Steel Cannon Air Vent Mount', 'Car Mounts & Holders', 'Baseus', 'SUGP000001', 450, 600, 'Compact & Minimalist Steel Clamp Air Outlet Holder.'],

            // Bluetooth Speakers (41-45)
            ['JBL GO 3 Portable Waterproof Bluetooth Speaker', 'Bluetooth Speakers', 'JBL', 'GO 3', 3800, 4500, 'Original JBL Pro Sound with IP67 Waterproof & Dustproof.'],
            ['Anker Soundcore Select 2 Portable Speaker 16W', 'Bluetooth Speakers', 'Anker', 'A3125', 3600, 4400, '16W Stereo Sound with BassUp Technology & 20 Hour Playtime.'],
            ['Joyroom Portable Mini Wireless Speaker 5W', 'Bluetooth Speakers', 'Joyroom', 'JR-MS01', 1250, 1600, 'RGB Light Effects Mini Bluetooth Speaker.'],
            ['Xiaomi Mi Compact Bluetooth Speaker 2', 'Bluetooth Speakers', 'Xiaomi', 'VXS4021GL', 1100, 1450, 'Clear Sound & 6 Hours Playtime with Built-in Mic.'],
            ['Hoco BS30 Portable Outdoor Wireless Speaker', 'Bluetooth Speakers', 'Hoco', 'BS30', 950, 1250, 'Compact Fabric Design Speaker with TF Card & AUX Support.'],

            // Gaming Accessories (46-50)
            ['Memo FL05 Mobile Phone Cooling Fan Radiator', 'Gaming Accessories', 'Memo', 'FL05', 850, 1150, 'RGB Light Dual Turbo Fan Cooler for PUBG & FreeFire Mobile.'],
            ['Baseus Winner Cooling Trigger Game Controller', 'Gaming Accessories', 'Baseus', 'ACHAP-01', 650, 850, 'Four Finger Ergonomic Game Controller with Mechanical Buttons.'],
            ['Flydigi Shadow Stinger 2 Mobile Gaming Trigger', 'Gaming Accessories', 'Flydigi', 'Stinger 2', 1450, 1850, 'CapAir Mapping Technology High Frequency Auto Click Triggers.'],
            ['Memo Sweat-Proof Touch Screen Gaming Finger Sleeves (2 Pair)', 'Gaming Accessories', 'Memo', 'Finger Sleeve', 180, 280, 'Silver Fiber Anti-Sweat Breathable Gaming Finger Gloves.'],
            ['Joyroom Gaming Audio & Charging Adapter 2-in-1', 'Gaming Accessories', 'Joyroom', 'JR-CL02', 750, 950, 'Simultaneous Fast Charging and 3.5mm Headphone Jack Converter.']
        ];

        $i = 1;
        foreach ($products as $p) {
            $catName = $p[1];
            $catObj = $categories[$catName] ?? null;

            // Pick local image or Unsplash image
            $imgChoice = ($i % 2 == 0) ? $localImages[($i % count($localImages))] : $unsplashImages[($i % count($unsplashImages))];

            InventoryItem::updateOrCreate(
                ['sku' => 'ACC-' . str_pad($i, 4, '0', STR_PAD_LEFT)],
                [
                    'name' => $p[0],
                    'type' => 'accessory',
                    'category' => $catName,
                    'category_id' => $catObj ? $catObj->id : null,
                    'brand' => $p[2],
                    'model' => $p[3],
                    'purchase_price' => $p[4],
                    'sale_price' => $p[5],
                    'min_sale_price' => $p[4] + 50,
                    'quantity' => rand(15, 60),
                    'alert_quantity' => 5,
                    'branch' => 'Main Shop',
                    'description' => $p[6],
                    'images' => [$imgChoice],
                ]
            );

            $i++;
        }
    }
}
