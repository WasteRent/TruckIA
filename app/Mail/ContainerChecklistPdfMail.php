<?php

namespace App\Mail;

use App\Models\ContainerChecklist;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContainerChecklistPdfMail extends Mailable
{
    use Queueable, SerializesModels;

    public $container_checklist;

    /** @var string */
    protected $pdf_content;

    /** @var string */
    protected $filename;

    public function __construct(ContainerChecklist $container_checklist, string $to, string $pdf_content)
    {
        $this->container_checklist = $container_checklist;
        $this->to($to);
        $this->pdf_content = $pdf_content;
        $this->filename = 'checklist_' . $container_checklist->container->reference . '_' . $container_checklist->checklist->name . '_' . $container_checklist->date . '.pdf';
        $this->filename = preg_replace('/[^a-zA-Z0-9_\-\.]/', '_', $this->filename);
    }

    public function build()
    {
        return $this->subject(__('Checklist') . ': ' . $this->container_checklist->checklist->name . ' - ' . $this->container_checklist->container->reference)
            ->markdown('mail.container-checklist-pdf')
            ->attachData($this->pdf_content, $this->filename, [
                'mime' => 'application/pdf',
            ]);
    }
}
