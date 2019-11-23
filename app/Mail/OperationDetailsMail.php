<?php

namespace App\Mail;

use App\Operation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OperationDetailsMail extends Mailable
{
    use Queueable, SerializesModels;

    public $operation;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Operation $operation)
    {
        $this->operation = $operation;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Solicitud de mantenimiento')
                    ->markdown('mails.operation_details');
    }
}
