<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ReasonController;
use App\Http\Controllers\Api\InventoryAdjustmentController;
use App\Http\Controllers\Api\BatchController;

Route::get('/batches', [BatchController::class, 'index']);
Route::get('/reasons', [ReasonController::class, 'index']);
Route::get('/inventory-adjustments', [InventoryAdjustmentController::class, 'index']);
Route::post('/inventory-adjustments', [InventoryAdjustmentController::class, 'store']);
Route::get('/inventory-adjustments/{inventoryAdjustment}', [InventoryAdjustmentController::class, 'show']);

