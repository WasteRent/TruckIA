<?php

namespace App\Http\Controllers\Fleet;

use App\Http\Controllers\Controller;
use App\Models\ActivityFeed;

class FleetFeedController extends Controller
{
    public function index()
    {
        return view('fleet.feed', [
            'items' => ActivityFeed::where('fleet_id', auth()->user()->fleet->id)->latest()->paginate(40)
        ]);
    }
}
