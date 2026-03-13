<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
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
        $plate = $request->query('plate');

        $normalized_plate = $plate ? strtoupper(preg_replace('/[^A-Za-z0-9]/', '', $plate)) : null;

        $rows = [];
        $service_keys_for_provider = [];

        if ($provider && in_array($provider, $providers, true)) {
            $service = $this->vehicle_tracking_factory->getService($provider);
            $service_keys_for_provider = $service_keys_by_provider[$provider] ?? [];

            if ($normalized_plate && ! $service_key) {
                $rows = $service->getDataByPlate($normalized_plate);
            } elseif ($service_key && in_array($service_key, $service_keys_for_provider, true)) {
                $filters = [];
                if ($normalized_plate) {
                    $filters['plate'] = $normalized_plate;
                }
                $rows = $service->getDataForService($service_key, $filters);
            } else {
                $rows = [];
            }
        }

        return view('tracking.index', [
            'providers' => $providers,
            'service_keys_by_provider' => $service_keys_by_provider,
            'selected_provider' => $provider,
            'service_keys_for_provider' => $service_keys_for_provider,
            'selected_service_key' => $service_key,
            'plate' => $plate,
            'rows' => $rows,
        ]);
    }
}

