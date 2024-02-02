<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ImportAccionaMechanicsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'acciona:import-users {file}';

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
        DB::beginTransaction();

        try {
            $users = $this->readFile();

            foreach ($users as $user) {
                User::create([
                    'name' => $user->name,
                    'username' => $user->user,
                    'password' => Hash::make($user->password),
                    'email' => $user->user,
                    'is_active' => 1,
                    'role' => 'fleet',
                    'entity_relation_id' => 30,
                    'allowed_schedule' => $user->allowed_schedule,
                    'job' => 'mechanic'
                ]);

                $this->info($user->name);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    private function readFile() {
        $result = collect([]);
        if (($handle = fopen($this->argument('file'), 'r')) !== false) {
            $row = 0;
            while (($data = fgetcsv($handle, 10000, ',')) !== false) {
                if ($row == 0) {
                    $row++;
                    continue;
                }

                $result->push((object)[
                    'name' => $data[0],
                    'user' => $data[1],
                    'password' => $data[2],
                    'allowed_schedule' => $data[3]
                ]);
            }
            fclose($handle);
        }

        return $result;
    }
}
