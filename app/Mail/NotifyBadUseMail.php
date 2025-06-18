<?php

namespace App\Mail;

use App\Models\RepairOrder;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotifyBadUseMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;

     /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(RepairOrder $order)
    {
        $this->order = $order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject("{$this->order->vehicle->plate} - O.R. Mal uso")->markdown('mail.bad-use-mail');
    }
}