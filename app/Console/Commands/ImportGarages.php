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
            if (($handle = fopen($file, 'r')) !== false) {
                while (($data = fgetcsv($handle, 3000, ';')) !== false) {
                    $this->createGarage($data);
                }
                fclose($handle);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    private function createGarage($data)
    {
        $user = User::create([
            'name' => $data[0],
            'username' => $data[1],
            'email' => $data[1],
            'password' => bcrypt(str_random(10)),
            'role' => 'garage',
            'created_at' => new \DateTime,
            'updated_at' => new \DateTime,
        ]);

        $garage = new Garage([
            'name' => $data[0],
            'garage_email' => $data[1],
            'garage_phone' => $data[2],
            'opening_hours' => $data[3],
            'address' => $data[4],
            'state' => $data[5],
            'province' => $data[6],
            'zip' => $data[7],
        ]);
        $garage->user_id = $user->id;
        $garage->save();
    }
}
