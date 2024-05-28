<?php

namespace App\Console\Commands;

use App\Classes\WeMob\WeMobClient;
use App\Models\RepairOrder;
use Illuminate\Console\Command;

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
        foreach (RepairOrder::whereNotNull('assigned_user_id')->cursor() as $order) {
            $order->update(['assigned_user_id' => array_map('intval', $order->assigned_user_id)]);
            $this->info($order->id);
        }


        /*
        $wemob = new WeMobClient(
            config('services.wemob.acciona.base_url'),
            config('services.wemob.acciona.username'),
            config('services.wemob.acciona.password')
        );
        <idCompany>89318</idCompany>
                    <idUser>99402</idUser>
        dd($wemob->getUserData());
        dd(file_put_contents('acciona.json', json_encode($wemob->getData())));*/
    }
}
