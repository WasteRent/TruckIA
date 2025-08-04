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
            ["0287MLJ","(FABR) Citröen eBerlingo 100 kW"],
            ["0413MDJ","(FABR) Iveco Daily GNC"],
            ["0786LZD","(FABR) Invicta Metro"],
            ["1009LZD","(FABR) Invicta Metro"],
            ["1138LZD","(FABR) Invicta Metro"],
            ["1212LZD","(FABR) Invicta Metro"],
            ["1748MDY","(FABR) Iveco Daily GNC"],
            ["1749MDY","(FABR) Iveco Daily GNC"],
            ["1750MDY","(FABR) Iveco Daily GNC"],
            ["1751MDY","(FABR) Iveco Daily GNC"],
            ["1753MDY","(FABR) Iveco Daily GNC"],
            ["1829JSP","(FABR) Peugeot Rifter K9 Diésel"],
            ["1835JSP","(FABR) Peugeot Rifter K9 Diésel"],
            ["2227JRN","(FABR) Peugeot Rifter K9 Diésel"],
            ["2794JRJ","(FABR) Peugeot Rifter K9 Diésel"],
            ["3282LYL","(FABR) Renault D15 Diésel"],
            ["3450LZF","(FABR) Invicta Metro"],
            ["3468LZF","(FABR) Invicta Metro"],
            ["3485LZF","(FABR) Invicta Metro"],
            ["4501MJV","(FABR) Iveco Eurocargo GNC"],
            ["4508MJV","(FABR) Iveco Eurocargo GNC"],
            ["4573LZD","(FABR) Renault Master Z.E."],
            ["5127HDT","(FABR) Piaggio Porter 1.2 D120 E5"],
            ["5314LZR","(FABR) Renault D15 Diésel"],
            ["5357NCY","(FABR) Peugeot eExpert 100 kW"],
            ["5679HLF","(FABR) Iveco Daily Diésel"],
            ["5713MDW","(FABR) Iveco Daily GNC"],
            ["5967HGT","(FABR) Peugeot Rifter K9 Diésel"],
            ["5970MHS","(FABR) Iveco S-Way NP - AD260S"],
            ["5971NCY","(FABR) Citröen Jumpy"],
            ["5972HGT","(FABR) Iveco Daily Diésel"],
            ["6027JRM","(FABR) Peugeot Rifter K9 Diésel"],
            ["6286HMH","(FABR) Mercedes-Benz Axor"],
            ["6287HMH","(FABR) Mercedes-Benz Axor"],
            ["7124CDS","(FABR) Iveco Eurocargo GNC"],
            ["7179CDS","(FABR) Iveco Eurocargo GNC"],
            ["7794HGW","(FABR) Iveco Daily Diésel"],
            ["7922LZB","(FABR) Renault Master Z.E."],
            ["8452LZB","(FABR) Renault Master Z.E."],
            ["8578HLP","(FABR) Piaggio Porter 1.3 Multitech E5"],
            ["8653MKR","(FABR) Renault D26Wide CNG"],
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
            $vehicle = Vehicle::where('plate', $item[0])->first();
            $this->info($vehicle->plate);
            Artisan::call("maintenance-plan:import 30 '{$item[0]}' '{$item[1]}'");
        }
    }
}
