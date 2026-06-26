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
            ['type' => 'inventory_adjustment', 'code' => 'ADJ_PHYSICAL_COUNT', 'description' => 'Physical count correction', 'is_active' => true],
            ['type' => 'inventory_adjustment', 'code' => 'ADJ_DAMAGED', 'description' => 'Damaged items', 'is_active' => true],
            ['type' => 'inventory_adjustment', 'code' => 'ADJ_MISSING', 'description' => 'Missing items', 'is_active' => true],
            ['type' => 'inventory_adjustment', 'code' => 'ADJ_DATA_ENTRY', 'description' => 'Data entry correction', 'is_active' => true],
            ['type' => 'inventory_adjustment', 'code' => 'ADJ_EXPIRED', 'description' => 'Expired items', 'is_active' => false], // Example inactive reason
        ];

        foreach ($reasons as $reason) {
            Reason::create($reason);
        }

        // 2. Create Warehouses
        $warehouse1 = Warehouse::create(['name' => 'Main Warehouse (Kuwait City)']);
        $warehouse2 = Warehouse::create(['name' => 'Secondary Warehouse (Ahmadi)']);

        // 3. Create Products
        $product1 = Product::create(['name' => 'Wheelchair Basic', 'sku' => 'WHL-001']);
        $product2 = Product::create(['name' => 'Hospital Bed Electric', 'sku' => 'HBE-100']);
        $product3 = Product::create(['name' => 'Surgical Masks (Box of 50)', 'sku' => 'MSK-050']);

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
