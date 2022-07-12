<?php

namespace App\Mail;

use App\Models\Vehicle;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AlertMail extends Mailable
{
    use Queueable, SerializesModels;

    public $vehicle;

    public $title;

    public $description;

    public $action_url;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Vehicle $vehicle, string $title, string $description, ?string $action_url)
    {
        $this->vehicle = $vehicle;
        $this->title = $title;
        $this->description = $description;
        $this->action_url = $action_url;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject("{$this->vehicle->plate} - {$this->title}")
                ->markdown('emails.alert');
    }
}
