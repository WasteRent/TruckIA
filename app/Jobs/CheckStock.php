<?php

namespace App\Jobs;

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
        $spareParts = SparePart::where('stock', '<', 0)->get();
        Alert::warning('Stock insuficiente', 'El stock de las siguientes piezas está insuficiente: ' . $spareParts->pluck('reference')->implode(', '));
    }
}
