<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TicketSubmittedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $ticketNumber;

    public function __construct($ticketNumber)
    {
        $this->ticketNumber = $ticketNumber;
    }

    public function build()
    {
        return $this->subject('Tiket Anda Telah Diterima')
                    ->view('emails.ticket_submitted');
    }
}
