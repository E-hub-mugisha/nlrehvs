<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmploymentHistoryAddedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $employeeName;
    public $companyName;

    public function __construct($employeeName, $companyName)
    {
        $this->employeeName = $employeeName;
        $this->companyName = $companyName;
    }

    public function build()
    {
        return $this->subject('Employment History Added')
                    ->view('emails.employment_history_added');
    }
}