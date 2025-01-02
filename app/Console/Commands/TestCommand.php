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
use App\Classes\Moba\MobaClient;
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
        $moba = new MobaClient(
            config('services.moba.acciona_martorell.base_url'),
            config('services.moba.acciona_martorell.username'),
            config('services.moba.acciona_martorell.password')
        );

        $a = $moba->getData('8340MTC', '01/12/2024 00:00:00', '01/12/2024 23:59:59');

        dd($a);
    }
}
