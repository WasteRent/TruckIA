<?php

namespace App\Console\Commands;

use App\Classes\Distromel\DistromelClient;
use App\Classes\Odoo\OdooClient;
use App\Classes\Odoo\OdooCompany;
use App\Classes\Odoo\OdooReader;
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
        $plates = ['0032MLP',
'0033MLP',
'0396DDN',
'0398MKX',
'0401MKX',
'0937MKM',
'0953MKM',
'1447DBV',
'1744MLT',
'2211LVX',
'2222BKM',
'2311MKW',
'2913MLZ',
'2952DBR',
'2959DBR',
'2977MLP',
'2983MLP',
'2984MLP',
'2986MLP',
'2988FHL',
'3189MGR',
'3190MGR',
'3191MGR',
'3192MGR',
'3193MGR',
'3194MGR',
'3195MGR',
'3197MGR',
'3497MGV',
'3515DDJ',
'3531DDJ',
'3545DDJ',
'3552DDJ',
'3568DDJ',
'3572DMP',
'3687DDJ',
'3707DDJ',
'3726MMF',
'3900MMF',
'3982DDV',
'4152MLZ',
'4497MKF',
'4498MKF',
'4538DCK',
'4604DGN',
'4625DGN',
'4770DCK',
'4779DCK',
'4782DDM',
'4885DDS',
'4890DDS',
'5003BTS',
'5088MGR',
'5332DNF',
'5412DFP',
'5985JDX',
'6030FDJ',
'6125BJF',
'7883DGF',
'8407CXC',
'8428DFZ',
'8437DFZ',
'8445DFZ',
'8455DFZ',
'8860MJT',
'8890MJT',
'8961JXR',
'9336DFT',
'9469GLS',
'9564MMC',
'9600DDM',
'9948KPZ',
'9963CBB',
'A1160EB',
'A2695EC',
'A6133CF',
'A6780DL',
'A6908DM'];

        foreach ($plates as $plate) {
            $matches = Vehicle::where('plate', $plate)->get();
            if (count($matches) > 1) {
                $r = $matches->map(function($match) {
                    return ['id' => $match->id, 'equipments' => $match->equipments->count()];
                });

                $r->where('equipments', 0)->each->delete();

                $this->info(json_encode($r));
            }
        }
    }

}
