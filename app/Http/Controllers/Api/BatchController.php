<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Batch;
use App\Http\Resources\BatchResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class BatchController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $batches = Batch::with(['product', 'warehouse'])->get();
        return BatchResource::collection($batches);
    }
}
