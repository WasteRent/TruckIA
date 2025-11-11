<?php

namespace App\Jobs;

use App\Models\File;
use App\Models\RepairOrder;
use App\Models\RepairOrderOperation;
use App\Models\RepairOrderPart;
use App\Services\GeminiService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProcessOCRJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $repairOrder;
    protected $fileModel;

    /**
     * Create a new job instance.
     */
    public function __construct(RepairOrder $repairOrder, File $fileModel)
    {
        $this->repairOrder = $repairOrder;
        $this->fileModel = $fileModel;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            Log::info('Iniciando procesamiento OCR para orden de reparación: ' . $this->repairOrder->id);

            $result = app(GeminiService::class)->extractDataFromOCR($this->fileModel);
            
            DB::beginTransaction();

            if (isset($result['operations'])) {
                foreach ($result['operations'] as $operation) {
                    $this->repairOrder->operations()->save(new RepairOrderOperation([
                        'operation_name' => $operation['description'],
                        'operation_description' => $operation['description'],
                        'estimated_time_in_hours' => $operation['hours'] ?? 0.00,
                        'real_time_in_hours' => $operation['hours'] ?? 0.00,
                        'amount' => $operation['total_price'] ?? 0,
                    ]));
                }
                
                Log::info('Operaciones procesadas: ' . count($result['operations']));
            }

            if (isset($result['parts'])) {
                foreach ($result['parts'] as $part) {
                    $this->repairOrder->parts()->save(new RepairOrderPart([
                        'manufacturer' => $part['manufacturer'],
                        'description' => $part['description'],
                        'quantity' => $part['quantity'] ?? 1,
                        'unit_price' => $part['unit_price'] ?? 0,
                        'total_price' => $part['unit_price'] * $part['quantity'] ?? 0,
                    ]));
                }
                
                Log::info('Repuestos procesados: ' . count($result['parts']));
            }

            DB::commit();
            
            Log::info('Procesamiento OCR completado exitosamente para orden: ' . $this->repairOrder->id);
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error en procesamiento OCR para orden ' . $this->repairOrder->id . ': ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception): void
    {
        Log::error('Job de procesamiento OCR falló para orden ' . $this->repairOrder->id . ': ' . $exception->getMessage());
    }
}
