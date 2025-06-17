<?php

namespace App\Jobs;

use App\Classes\AlertService;
use App\Models\Alert;
use App\Models\SparePart;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CheckStock implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $spareParts = SparePart::where('stock', '<', SparePart::MIN_STOCK)->allowForUser()->get();
        foreach ($spareParts as $sparePart) {
            dd($sparePart);
            (new AlertService)->to($sparePart->fleet)->notify(
                'Stock insuficiente',
                $sparePart->reference,
                "/fleet/spare-parts?reference={$sparePart->reference}",
            );
        }
    }
}
