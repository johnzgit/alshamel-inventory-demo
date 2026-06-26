<?php

namespace Database\Seeders;

use App\Models\Batch;
use App\Models\Product;
use App\Models\Reason;
use App\Models\Warehouse;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Add sample user for testing
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // 1. Create Reasons
        $reasons = [
            ['type' => 'inventory_adjustment', 'code' => 'ADJ_PHYSICAL_COUNT', 'description' => ['en' => 'Physical count correction', 'zh' => '盘点修正', 'ar' => 'تصحيح الجرد الفعلي'], 'is_active' => true],
            ['type' => 'inventory_adjustment', 'code' => 'ADJ_DAMAGED', 'description' => ['en' => 'Damaged items', 'zh' => '物品损坏', 'ar' => 'عناصر تالفة'], 'is_active' => true],
            ['type' => 'inventory_adjustment', 'code' => 'ADJ_MISSING', 'description' => ['en' => 'Missing items', 'zh' => '物品丢失', 'ar' => 'عناصر مفقودة'], 'is_active' => true],
            ['type' => 'inventory_adjustment', 'code' => 'ADJ_DATA_ENTRY', 'description' => ['en' => 'Data entry correction', 'zh' => '数据录入修正', 'ar' => 'تصحيح إدخال البيانات'], 'is_active' => true],
            ['type' => 'inventory_adjustment', 'code' => 'ADJ_EXPIRED', 'description' => ['en' => 'Expired items', 'zh' => '过期物品', 'ar' => 'عناصر منتهية الصلاحية'], 'is_active' => false],
        ];

        foreach ($reasons as $reason) {
            Reason::create($reason);
        }

        // 2. Create Warehouses
        $warehouse1 = Warehouse::create(['name' => ['en' => 'Main Warehouse (Kuwait City)', 'zh' => '主仓库 (科威特城)', 'ar' => 'المستودع الرئيسي (مدينة الكويت)']]);
        $warehouse2 = Warehouse::create(['name' => ['en' => 'Secondary Warehouse (Ahmadi)', 'zh' => '次要仓库 (艾哈迈迪)', 'ar' => 'المستودع الثانوي (الأحمدي)']]);

        // 3. Create Products
        $product1 = Product::create(['name' => ['en' => 'Wheelchair Basic', 'zh' => '基础轮椅', 'ar' => 'كرسي متحرك أساسي'], 'sku' => 'WHL-001']);
        $product2 = Product::create(['name' => ['en' => 'Hospital Bed Electric', 'zh' => '电动病床', 'ar' => 'سرير مستشفى كهربائي'], 'sku' => 'HBE-100']);
        $product3 = Product::create(['name' => ['en' => 'Surgical Masks (Box of 50)', 'zh' => '医用外科口罩 (50只装)', 'ar' => 'كمامات جراحية (علبة 50)'], 'sku' => 'MSK-050']);

        // 4. Create Batches
        Batch::create([
            'warehouse_id' => $warehouse1->id,
            'product_id' => $product1->id,
            'batch_number' => 'B-WHL-' . date('Ym') . '-01',
            'quantity' => 100
        ]);

        Batch::create([
            'warehouse_id' => $warehouse1->id,
            'product_id' => $product3->id,
            'batch_number' => 'B-MSK-' . date('Ym') . '-01',
            'quantity' => 500
        ]);

        Batch::create([
            'warehouse_id' => $warehouse2->id,
            'product_id' => $product2->id,
            'batch_number' => 'B-HBE-' . date('Ym') . '-02',
            'quantity' => 10
        ]);
    }
}
