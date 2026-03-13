<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Jobs\VehicleTrackingDebugJob;
use App\Models\VehicleTrackingDebug;
use App\Services\VehicleTracking\VehicleTrackingFactory;
use Illuminate\Http\Request;

class VehicleTrackingDebugController extends Controller
{
    private VehicleTrackingFactory $vehicle_tracking_factory;

    public function __construct(VehicleTrackingFactory $vehicle_tracking_factory)
    {
        $this->vehicle_tracking_factory = $vehicle_tracking_factory;
    }

    public function index(Request $request)
    {
        $providers = $this->vehicle_tracking_factory->getAvailableServices();
        $service_keys_by_provider = [];

        foreach ($providers as $provider_key) {
            $service = $this->vehicle_tracking_factory->getService($provider_key);
            $service_keys_by_provider[$provider_key] = $service->getAvailableServiceKeys();
        }

        $provider = $request->query('provider');
        $service_key = $request->query('service_key');

        $service_keys_for_provider = [];

        if ($provider && in_array($provider, $providers, true)) {
            $service = $this->vehicle_tracking_factory->getService($provider);
            $service_keys_for_provider = $service_keys_by_provider[$provider] ?? [];
        }

        $debugs = VehicleTrackingDebug::orderByDesc('created_at')->paginate(20);

        return view('tracking.index', [
            'providers' => $providers,
            'service_keys_by_provider' => $service_keys_by_provider,
            'selected_provider' => $provider,
            'service_keys_for_provider' => $service_keys_for_provider,
            'selected_service_key' => $service_key,
            'debugs' => $debugs,
        ]);
    }

    public function store(Request $request)
    {
        $providers = $this->vehicle_tracking_factory->getAvailableServices();

        $request->validate([
            'provider' => 'required|in:'.implode(',', $providers),
            'service_key' => 'required|string',
        ]);

        $provider = $request->input('provider');
        $service_key = $request->input('service_key');

        $debug = VehicleTrackingDebug::create([
            'provider' => $provider,
            'service_key' => $service_key,
            'status' => 'pending',
        ]);

        VehicleTrackingDebugJob::dispatch($debug->id);

        return redirect()->route('tracking.debug.index')->with('success_message', __('Petición de datos de telemetría creada correctamente'));
    }

    public function show(VehicleTrackingDebug $debug)
    {
        $rows = $debug->response ?? [];

        return view('tracking.show', [
            'debug' => $debug,
            'rows' => $rows,
        ]);
    }
}

