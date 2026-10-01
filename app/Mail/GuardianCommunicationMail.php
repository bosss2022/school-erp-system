<?php

namespace App\Mail;

use App\Models\GuardianCommunication;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class GuardianCommunicationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $communication;

    /**
     * Create a new message instance.
     */
    public function __construct(GuardianCommunication $communication)
    {
        $this->communication = $communication;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject($this->communication->subject)
                    ->view('emails.guardian-communication')
                    ->with([
                        'communication' => $this->communication,
                    ]);
    }
}