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
        /*$moba = new MobaClient(
            config('services.moba.acciona_martorell.base_url'),
            config('services.moba.acciona_martorell.username'),
            config('services.moba.acciona_martorell.password')
        );

        $a = $moba->getKms('8425MTC', '20/01/2005 00:00:00', '20/01/2025 23:59:59');*/

        $client = new DistromelClient(
            config('services.distromel.acciona.base_url'),
            config('services.distromel.acciona.username'),
            config('services.distromel.acciona.password'),
            config('services.distromel.acciona_la_eliana.key'),
        );
        dd($client->getResourceStats(6));
    }
}
