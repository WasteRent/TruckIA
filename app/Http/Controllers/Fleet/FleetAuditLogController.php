<?php

namespace App\Http\Controllers\Fleet;

use App\Http\Controllers\Controller;
use App\Models\Audit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FleetAuditLogController extends Controller
{

    public function index(Request $request)
    {
        $fleetUserIds = Auth::user()->fleet->users()->pluck('id');

        $audits = Audit::filter($request->all())->with('user')
            ->whereIn('user_id', $fleetUserIds)
            ->latest()
            ->cursorPaginate(50);

        return view('fleet.audits.index', [
            'audits' => $audits,
        ]);
    }

    public function show(Audit $audit)
    {
        $fleetUserIds = Auth::user()->fleet->users()->pluck('id');

        $audit = Audit::with('user')
            ->whereIn('user_id', $fleetUserIds)
            ->findOrFail($audit->id);

        return view('fleet.audits.show', [
            'audit' => $audit,
        ]);
    }
}
