<?php

namespace App\Console\Commands\Tracking;

use App\Classes\Chip2Chip\Chip2chipClient;
use App\Models\Fleet;
use App\Models\Vehicle;
use App\Models\VehicleTracking;
use Carbon\Carbon;
use Illuminate\Console\Command;

class AccionaChip2chipEngineHoursCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tracking:acciona-chip2chip-engine-hours {--date= : Fecha específica en formato Y-m-d (opcional, por defecto ayer)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Importa las horas de motor de los vehículos de Acciona desde Chip2chip';

    /**
     * Cliente Chip2chip
     * 
     * @var Chip2chipClient
     */
    protected $client;

    /**
     * Fecha a procesar
     * 
     * @var Carbon
     */
    protected $date;

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Obtener la fecha del día anterior (o la fecha especificada)
        $this->date = $this->option('date') 
            ? Carbon::parse($this->option('date')) 
            : Carbon::yesterday();
        
        $date = $this->date;
        $from_date = $date->copy()->startOfDay()->format('YmdHis');
        $to_date = $date->copy()->endOfDay()->format('YmdHis');

        $this->info("Procesando horas de motor para el día: {$date->format('Y-m-d')}");
        $this->info("Rango: {$from_date} - {$to_date}");

        $services = [
            'acciona_chip2chip_alcobendas',
            'acciona_chip2chip_calpe',
            'acciona_chip2chip_amappffl5',
            'acciona_chip2chip_cosladalv',
            'acciona_chip2chip_amapphhl2',
            'acciona_chip2chip_labaneza',
        ];

        foreach ($services as $service) {
            $token_username = config("services.chip2chip.{$service}.token_username");
            $asset_group_id = config("services.chip2chip.{$service}.asset_group_id");
            
            $this->info("Procesando cuenta: {$service} (Token: {$token_username}, Asset Group ID: {$asset_group_id})");
            
            $this->client = new Chip2chipClient(
                config('services.chip2chip.acciona.api_base_url'),
                config('services.chip2chip.acciona.token_base_url'),
                config('services.chip2chip.acciona.client_id'),
                config('services.chip2chip.acciona.client_secret'),
                config('services.chip2chip.acciona.client_name'),
                $token_username,
                config('services.chip2chip.acciona.token_password')
            );

            $assets_ids = $this->fetchData($asset_group_id);
            
            if (empty($assets_ids)) {
                $this->warn("No se encontraron vehículos para la cuenta: {$service}");
                continue;
            }
            
            $this->updateVehicleEngineHours($assets_ids, $from_date, $to_date);
        }

        $this->info('✓ Proceso completado');

        return Command::SUCCESS;
    }

    private function fetchData(int $asset_group_id): array
    {
        $bbdd_vehicles = Vehicle::where('fleet_id', Fleet::ACCIONA)->get();
        $response_vehicles = $this->client->getAssets($asset_group_id) ?? throw new \Exception('No se encontraron vehículos en Chip2chip');
        $assets_ids = [];

        foreach ($bbdd_vehicles as $vehicle) {
            foreach ($response_vehicles as $chip2chip_vehicle) {
                $formatted_registration = str_replace('-', '', $chip2chip_vehicle['RegistrationNumber']);
                if ($vehicle->plate == $formatted_registration) {
                    $assets_ids[$vehicle->id] = $chip2chip_vehicle['AssetId'];
                }
            }
        }

        return $assets_ids;
    }

    private function updateVehicleEngineHours(array $assets_ids, string $from_date, string $to_date)
    {
        $vehicles = Vehicle::whereIn('id', array_keys($assets_ids))->get();
        
        try {
            $events = $this->client->getEngineHoursEvents(array_values($assets_ids), $from_date, $to_date);
            
            if (empty($events)) {
                $this->warn('No se encontraron eventos de horas de motor para este período');
                return;
            }

            $this->info('Eventos encontrados: ' . count($events));

            // Agrupar eventos por AssetId y sumar los TotalTimeSeconds
            $engine_hours_by_asset = [];
            
            foreach ($events as $event) {

                if (!isset($event['TotalTimeSeconds'])) {
                    $this->warn("Evento incompleto, saltando...");
                    continue;
                }

                $asset_id = $event['AssetId'];
                
                if (!isset($engine_hours_by_asset[$asset_id])) {
                    $engine_hours_by_asset[$asset_id] = 0;
                }
                
                $engine_hours_by_asset[$asset_id] += $event['TotalTimeSeconds'];
            }

            // Actualizar cada vehículo
            foreach ($assets_ids as $vehicle_id => $asset_id) {
                $vehicle = $vehicles->firstWhere('id', $vehicle_id);
                
                if (!$vehicle) {
                    $this->warn("Vehículo con ID {$vehicle_id} no encontrado");
                    continue;
                }

                if (!isset($engine_hours_by_asset[$asset_id])) {
                    $this->info("{$vehicle->plate}: Sin eventos de motor para este día");
                    continue;
                }

                $total_seconds = $engine_hours_by_asset[$asset_id];
                $total_hours = $total_seconds / 3600;

                $hours_before = $vehicle->chassis_can_work_hours ?? 0;

                try {
                    // Incrementar las horas de motor TDF del vehículo
                    $vehicle->incrementEquipmentHours($total_hours);
                    $vehicle->refresh();
                    $hours_after = $vehicle->chassis_can_work_hours ?? 0;
                    
                    // Crear registro de tracking con las horas actualizadas
                    $message_uid = md5("{$vehicle->plate}:engine_hours:{$this->date->format('Y-m-d')}");
                    
                    VehicleTracking::updateOrCreate([
                        'message_uid' => $message_uid,
                    ], [
                        'vehicle_id' => $vehicle->id,
                        'message_uid' => $message_uid,
                        'kms' => $vehicle->kms,
                        'fuel_level_percent' => null,
                        'address' => '',
                        'latitude' => '',
                        'longitude' => '',
                        'engine_minutes' => $hours_after * 60,
                        'fired_at' => now(),
                        'created_at' => now()
                    ]);
                    
                    $this->info(sprintf(
                        "%s: ANTES: %.2f hrs | +%.2f hrs nuevas (%.0f seg) | DESPUÉS: %.2f hrs",
                        $vehicle->plate,
                        $hours_before,
                        $total_hours,
                        $total_seconds,
                        $hours_after
                    ));
                } catch (\Exception $e) {
                    $this->error("Error actualizando {$vehicle->plate}: {$e->getMessage()}");
                }
            }
        } catch (\Exception $e) {
            $this->error("Error al obtener eventos: {$e->getMessage()}");
            throw $e;
        }
    }
}

