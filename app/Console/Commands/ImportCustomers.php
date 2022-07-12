<?php

namespace App\Console\Commands;

use App\Models\Customer;
use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ImportCustomers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:customers {file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $file = $this->argument('file');

        DB::beginTransaction();

        try {
            if (($handle = fopen($file, 'r')) !== false) {
                while (($data = fgetcsv($handle, 3000, ';')) !== false) {
                    $this->createCustomer($data);
                }
                fclose($handle);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    private function createCustomer($data)
    {
        $user = User::create([
            'name' => $data[1],
            'username' => $data[2],
            'email' => $data[2],
            'password' => bcrypt(str_random(10)),
            'role' => 'customer',
            'created_at' => new \DateTime,
            'updated_at' => new \DateTime,
        ]);

        $customer = new Customer([
            'enterprise_group_id' => $data[0],
            'name' => $data[1],
            'email1' => $data[2],
            'phone1' => $data[3],
            'address' => $data[4],
            'state' => $data[5],
            'province' => $data[6],
            'zip' => $data[7],
            'contact1' => $data[8],
        ]);
        $customer->user_id = $user->id;
        $customer->save();
    }
}
