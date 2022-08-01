<?php

namespace App\Console\Commands;

use App\Classes\Moba\MobaClient;
use App\Jobs\GetVehiclesTrackingMobaJob;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class MobaCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'moba';

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
        (new GetVehiclesTrackingMobaJob)->handle();
    }
}
