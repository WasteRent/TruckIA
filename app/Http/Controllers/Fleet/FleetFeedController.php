<?php

namespace App\Http\Controllers\Fleet;

use App\Http\Controllers\Controller;
use App\Models\ActivityFeed;

class FleetFeedController extends Controller
{
    public function index()
    {
        $items = ActivityFeed::query()
                ->whereHas('vehicle', function ($q) {
                    $q->allowForUser();
                })
                ->where('created_at', '>=', now()->subDays(7))
                ->latest()
                ->get();

        return view('fleet.feed', [
            'items' => $items,
        ]);
    }
}
