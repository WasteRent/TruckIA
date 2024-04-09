<?php

namespace App\Console\Commands;

use App\Classes\Distromel\DistromelClient;
use App\Classes\Odoo\OdooClient;
use App\Classes\Odoo\OdooCompany;
use App\Classes\Odoo\OdooReader;
use App\Classes\WeMob\WeMobClient;
use App\Models\Vehicle;
use App\Models\VehicleState;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use \JsonMachine\Items;

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
        $wemob = new WeMobClient(
            config('wemob.base_url'),
            config('wemob.svat.username'),
            config('wemob.svat.password')
        );

        dd($wemob->getData());
        $client = new WeMobClient(
            'https://ws.wemob.es/WMServices',
            'svatit',
            'sv4t1T0324'
        );
        file_put_contents('webmob.txt', json_encode($client->getData()));
    }

}
