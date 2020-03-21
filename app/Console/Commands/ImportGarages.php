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
            'name'      => $data[0],
            'username'  => str_random(10),
            'email'     => str_random(10),
            'password'  => str_random(10),
            'role'      => 'garage',
            'created_at' => new \DateTime,
            'updated_at' => new \DateTime
        ]);

        $garage = new Garage([
            'name' => $data[0],
            'state' => $data[2],
            'garage_phone' => $data[1]
        ]);
        $garage->user_id = $user->id;
        $garage->save();

        $specs = [
            1 => (int)$data[3], // Chasis
            2 => (int)$data[4], // Equipos
            3 => (int)$data[5], // Hidrau
        ];

        foreach ($specs as $spec_id => $stars) {
            if ($garage->specialities->pluck('id')->contains($spec_id)) {
                $garage->specialities()->updateExistingPivot($spec_id, ['stars' => $stars]);
            } else {
                $garage->specialities()->attach($spec_id, ['stars' => $stars]);
            }
        }
    }
}
