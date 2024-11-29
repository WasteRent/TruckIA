<?php

namespace App\Console\Commands;

use App\Classes\WeMob\WeMobClient;
use App\Imports\UsersImport;
use App\Models\RepairOrder;
use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\VehicleState;
use App\Models\Vehicle;

class TestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $report = [];
        foreach(Vehicle::whereIn('fleet_id', [1])->where('is_service_vehicle', false)->where('created_at', '<', '2024-01-01')->get() as $vehicle) {
            $orders = $vehicle->repairOrders()->where('type', 'preventive')->finished()->get();
            $report[$vehicle->id] = $orders->count();
        }
        dd(collect($report)->filter(function($count) {
            return $count <= 2;
        }));
        
        /*$report = [];
        foreach(range(1, 12) as $month) {
            $vehicles_garage = Vehicle::whereIn('fleet_id', [1])
                ->where(function($query) use ($month) {
                    // Get vehicles that changed state to GARAGE in this month
                    $query->whereHas('stateHistory', function($q) use ($month) {
                        $q->where('state_id', VehicleState::GARAGE)
                          ->whereMonth('created_at', $month)
                          ->whereYear('created_at', 2023);
                    })
                    // Or get vehicles whose last state change before this month was to GARAGE
                    ->orWhereHas('stateHistory', function($q) use ($month) {
                        $q->where('state_id', VehicleState::GARAGE)
                          ->whereDate('created_at', '<', "2023-{$month}-01")
                          ->whereNotExists(function($q2) use ($month) {
                              $q2->from('vehicle_state_histories')
                                 ->whereRaw('vehicle_state_histories.vehicle_id = vehicles.id')
                                 ->whereDate('created_at', '>=', "2023-{$month}-01")
                                 ->whereDate('created_at', '<', "2023-" . ($month + 1) . "-01");
                          });
                    });
                })->count();

            $vehicles_rented = Vehicle::whereIn('fleet_id', [1])
                ->where(function($query) use ($month) {
                    // Get vehicles that changed state to RENTED in this month
                    $query->whereHas('stateHistory', function($q) use ($month) {
                        $q->where('state_id', VehicleState::RENTED)
                          ->whereMonth('created_at', $month)
                          ->whereYear('created_at', 2023);
                    })
                    // Or get vehicles whose last state change before this month was to RENTED
                    ->orWhereHas('stateHistory', function($q) use ($month) {
                        $q->where('state_id', VehicleState::RENTED)
                          ->whereDate('created_at', '<', "2023-{$month}-01")
                          ->whereNotExists(function($q2) use ($month) {
                              $q2->from('vehicle_state_histories')
                                 ->whereRaw('vehicle_state_histories.vehicle_id = vehicles.id')
                                 ->whereDate('created_at', '>=', "2023-{$month}-01")
                                 ->whereDate('created_at', '<', "2023-" . ($month + 1) . "-01");
                          });
                    });
                })->count();


            $report['garage'][$month] = $vehicles_garage;
            $report['rented'][$month] = $vehicles_rented;
        }*/

    }
}
