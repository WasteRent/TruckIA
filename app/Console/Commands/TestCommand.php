<?php

namespace App\Console\Commands;

use App\Classes\Odoo\OdooClient;
use App\Classes\Odoo\OdooCompany;
use App\Classes\Odoo\OdooReader;
use Illuminate\Console\Command;
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
        $reader = new OdooReader('data.json');

        $sivu = [];
        foreach ($reader->iterate() as $vehicle) {
            if ($vehicle->PropietarioId == OdooCompany::SIVU) {
                $sivu[] = $vehicle;
            }
        }



        // $client = app(OdooClient::class);
        // $data = $client->executeAction('product.template', 'pnt_get_json_data');
        // file_put_contents('data.json', $data);
    }
}
