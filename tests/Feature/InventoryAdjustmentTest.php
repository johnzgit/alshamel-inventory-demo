<?php

namespace Tests\Feature;

use App\Models\Batch;
use App\Models\Product;
use App\Models\Reason;
use App\Models\Warehouse;
use App\Models\InventoryAdjustment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InventoryAdjustmentTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Setup base data needed for most tests
        $this->warehouse = Warehouse::create(['name' => 'Test Warehouse']);
        $this->product = Product::create(['name' => 'Test Product', 'sku' => 'TEST-001']);
        
        $this->batch = Batch::create([
            'warehouse_id' => $this->warehouse->id,
            'product_id' => $this->product->id,
            'batch_number' => 'B-TEST-001',
            'quantity' => 100
        ]);

        $this->reason = Reason::create([
            'type' => 'inventory_adjustment',
            'code' => 'ADJ_TEST',
            'description' => 'Test Reason',
            'is_active' => true
        ]);
    }

    public function test_can_list_active_inventory_adjustment_reasons()
    {
        Reason::create(['type' => 'inventory_adjustment', 'code' => 'ADJ_INACTIVE', 'description' => 'Inactive Test', 'is_active' => false]);
        Reason::create(['type' => 'other_type', 'code' => 'OTHER', 'description' => 'Other Type', 'is_active' => true]);

        $response = $this->getJson('/api/reasons');

        $response->assertStatus(200)
            // Should only count the 1 active 'inventory_adjustment' reason we created in setUp
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.code', 'ADJ_TEST');
    }

    public function test_can_fetch_all_batches_with_relations()
    {
        $response = $this->getJson('/api/batches');

        $response->assertStatus(200)
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.batch_number', 'B-TEST-001')
            ->assertJsonPath('data.0.product_name', 'Test Product')
            ->assertJsonPath('data.0.warehouse_name', 'Test Warehouse');
    }

    public function test_can_create_inventory_adjustment_and_it_updates_batch_quantity()
    {
        $response = $this->postJson('/api/inventory-adjustments', [
            'batch_id' => $this->batch->id,
            'reason_id' => $this->reason->id,
            'new_quantity' => 92,
            'note' => 'Found 8 missing during physical count'
        ]);

        // 1. Assert API Response
        $response->assertStatus(201)
            ->assertJsonPath('data.old_quantity', 100)
            ->assertJsonPath('data.new_quantity', 92)
            ->assertJsonPath('data.diff_quantity', -8)
            ->assertJsonPath('data.note', 'Found 8 missing during physical count')
            ->assertJsonPath('data.reason.description', 'Test Reason');

        // 2. Assert Database state changed correctly
        $this->assertDatabaseHas('batches', [
            'id' => $this->batch->id,
            'quantity' => 92
        ]);

        $this->assertDatabaseHas('inventory_adjustments', [
            'batch_id' => $this->batch->id,
            'diff_quantity' => -8
        ]);
    }

    public function test_cannot_create_adjustment_with_inactive_reason()
    {
        $inactiveReason = Reason::create([
            'type' => 'inventory_adjustment',
            'code' => 'ADJ_INACTIVE_2',
            'description' => 'Inactive Reason',
            'is_active' => false
        ]);

        $response = $this->postJson('/api/inventory-adjustments', [
            'batch_id' => $this->batch->id,
            'reason_id' => $inactiveReason->id,
            'new_quantity' => 50,
            'note' => 'Should fail'
        ]);

        // Validation should fail because it's not active
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['reason_id']);
            
        // Batch quantity should remain untouched
        $this->assertDatabaseHas('batches', [
            'id' => $this->batch->id,
            'quantity' => 100
        ]);
    }

    public function test_can_fetch_adjustment_history()
    {
        // Create a mock adjustment manually
        InventoryAdjustment::create([
            'batch_id' => $this->batch->id,
            'reason_id' => $this->reason->id,
            'old_quantity' => 100,
            'new_quantity' => 120,
            'diff_quantity' => 20,
            'note' => 'Stock found'
        ]);

        $response = $this->getJson('/api/inventory-adjustments');

        $response->assertStatus(200)
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.diff_quantity', 20)
            ->assertJsonPath('data.0.note', 'Stock found')
            // Assert relations were eager loaded
            ->assertJsonPath('data.0.batch.batch_number', 'B-TEST-001')
            ->assertJsonPath('data.0.batch.product.name', 'Test Product');
    }
}
