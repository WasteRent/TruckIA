<?php

namespace App\Console\Commands;

use App\Models\Fleet;
use App\Models\MaintenancePlan;
use App\Models\MaintenancePlanOperation;
use App\Models\OperationFamily;
use App\Models\Vehicle;
use App\Models\VehicleWorkCounter;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ImportaMaintenancePlanCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'maintenance-plan:import {fleet_id} {prefix_plan_name} {plates} {file}';

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

        $plates = explode(',', $this->argument('plates'));
        $fleet = Fleet::findOrFail($this->argument('fleet_id'));

        try {
            $vehicles = [];
            foreach ($plates as $plate) {
                $vehicles[] = Vehicle::where('plate', $plate)->firstOrFail();
            }

            $operations = $this->readFile();

            foreach ($operations->groupBy('hours') as $chunk) {
                if ($chunk[0]['hours']  < 1) {
                    continue;
                }

                $name = "Acciona {$this->argument('prefix_plan_name')} {$chunk[0]['hours']}h";
                $plan = MaintenancePlan::create([
                    'name' => $name,
                    'work_hours' => $chunk[0]['hours']
                ]);

                foreach ($chunk as $item) {
                    MaintenancePlanOperation::create([
                        'maintenance_plan_id' => $plan->id,
                        'family_id' => OperationFamily::firstOrCreate(['name' => $item['area']])->id,
                        'name' => $item['operation']
                    ]);
                }

                $fleet->customPlans()->attach($plan);

                foreach ($vehicles as $vehicle) {
                    $vehicle->counters()->save(new VehicleWorkCounter([
                        'plan_id' => $plan->id,
                        'type' => 'work_hours',
                        'vehicle_category' => 'chassis',
                        'max' => $plan->work_hours,
                        'description' => "{$fleet->name} - {$name}"
                    ]));
                }

                $this->info("{$fleet->name} - {$name}");
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

                $result->push([
                    'hours' => (int) $data[1],
                    'area' => $data[2],
                    'operation' => $data[3],
                ]);
            }
            fclose($handle);
        }

        return $result;
    }
}
