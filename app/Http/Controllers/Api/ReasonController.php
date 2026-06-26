<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Reason;
use App\Http\Resources\ReasonResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ReasonController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $reasons = Reason::where('type', 'inventory_adjustment')
            ->where('is_active', true)
            ->get();

        return ReasonResource::collection($reasons);
    }
}
