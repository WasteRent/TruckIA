<?php

namespace App\Console\Commands;

use App\Models\Garage;
use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ImportGarages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:garages {file}';

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
            if (($handle = fopen($file, "r")) !== false) {
                while (($data = fgetcsv($handle, 1000, ";")) !== false) {
                    $this->createGarage($data[0], $data[2], $data[1]);
                }
                fclose($handle);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
        }
    }

    private function createGarage($name, $state, $phone)
    {
        $user = User::create([
            'name'      => $name,
            'username'  => str_random(10),
            'email'     => str_random(10),
            'password'  => str_random(10),
            'role'      => 'garage',
            'created_at' => new \DateTime,
            'updated_at' => new \DateTime
        ]);

        $garage = new Garage([
            'name' => $name,
            'state' => $state,
            'garage_phone' => $phone
        ]);
        $garage->user_id = $user->id;
        $garage->save();
    }
}
