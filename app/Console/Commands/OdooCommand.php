<?php

namespace App\Console\Commands;

use App\Classes\Odoo\OdooClient;
use Illuminate\Console\Command;

class OdooCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'odoo';

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
        $client = (new OdooClient(
            config('odoo.base_url'),
            config('odoo.account'),
            config('odoo.username'),
            config('odoo.password')
        ));

        // $data = $client->executeAction('product.template', 'pnt_get_json_data');
        // $vehicle = $data->where('MatriculaChasis', 'E1076BCY')->first();

        $result = $client->executeAction('product.template', 'pnt_trucki_set_data', [
            'id' => 15, //$vehicle['Id'],
            'state' => 'rent',
        ]);

        dd($result);
    }
}
