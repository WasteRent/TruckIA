<?php

namespace App\Console\Commands;

use App\Classes\WeMob\WeMobClient;
use App\Models\RepairOrder;
use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class TestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:test {filepath}';

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
        $row = 1;
        if (($handle = fopen($this->argument('filepath'), "r")) !== FALSE) {
          while (($data = fgetcsv($handle, 2000, ",")) !== FALSE) {
            $user = User::create([
                'name' => "{$data[2]} {$data[0]} {$data[1]}",
                'username' => $data[3],
                'password' => Hash::make($data[4]),
                'email' => $data[3],
                'is_active' => 1,
                'is_readonly' => 0,
                'job' => 'driver',
                'role' => 'fleet',
                'entity_relation_id' => 30,
                'allowed_schedule' => $data[5],
            ]);
            $user->allowedCustomers()->sync(348);
          }
          fclose($handle);
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
