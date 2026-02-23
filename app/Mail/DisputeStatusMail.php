<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DisputeStatusMail extends Mailable
{
    use Queueable, SerializesModels;

    public $status;
    public $employeeName;

    public function __construct($employeeName, $status)
    {
        $this->employeeName = $employeeName;
        $this->status = $status;
    }

    public function build()
    {
        return $this->subject('Dispute Update')
                    ->view('emails.dispute_status');
    }
}