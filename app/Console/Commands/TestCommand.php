<?php

namespace App\Console\Commands;

use App\Classes\Distromel\DistromelClient;
use App\Classes\Moba\MobaClient;
use App\Classes\WeMob\WeMobClient;
use App\Imports\UsersImport;
use App\Models\RepairOrder;
use App\Models\Vehicle;
use App\Models\VehicleState;
use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Artisan;



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
        $map = [
            ["8673HGT","(FABR) Peugeot Rifter K9 Diésel"],
            ["8740CFD","(FABR) Iveco Eurocargo GNC"],
            ["9349HHN","(FABR) Mercedes-Benz Axor"],
            ["9556MHW","(FABR) Renault D26Wide CNG"],
            ["C9707BWP","(FABR) Scoobic Light"],
            ["E0736BHT","(FABR) Schmidt CleanGo 500 E6c"],
            ["E0740BHT","(FABR) Schmidt CleanGo 500 E6c"],
            ["E0742BHT","(FABR) Schmidt CleanGo 500 E6c"],
            ["E0745BHT","(FABR) Schmidt CleanGo 500 E6c"],
            ["E0746BHT","(FABR) Schmidt CleanGo 500 E6c"],
            ["E2593BHS","(FABR) Tenax Electra 2.0 Evo"],
            ["E3317BFZ","SCHMIDT SWINGO"],
            ["E4337BHR","(FABR) Tenax Electra 2.0 Hydro"],
            ["E4968BHS","(FABR) Tenax Electra 2.0 Hydro"],
            ["E5063BHR","(FABR) Tenax Electra 2.0 Evo"],
            ["E6698BHS","(FABR) Tenax Electra 2.0 Hydro"],
            ["E7118BHR","(FABR) Schmidt eSwingo 200"],
            ["E8470BHR","(FABR) Schmidt CleanGo 500 E6c"],
            ["E8474BHR","(FABR) Schmidt CleanGo 500 E6c"],
        ];

        foreach($map as $item) {
            try {
                $vehicle = Vehicle::where('plate', $item[0])->first();
                $this->info($vehicle->plate);
                Artisan::call("maintenance-plan:import 30 '{$item[0]}' '{$item[1]}'");
            } catch (Exception $e) {
                $this->error($e->getMessage());
            }
        }
    }
}
