<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Meeting;
use App\Models\Guardian;

class MeetingInvitationMail extends Mailable
{
    use Queueable, SerializesModels;

   use Queueable, SerializesModels;

    public $meeting;
    public $guardian;

    public function __construct(Meeting $meeting, Guardian $guardian)
    {
        $this->meeting = $meeting;
        $this->guardian = $guardian;
    }

    public function build()
    {
        return $this
            ->subject('Guardian Meeting Invitation')
            ->view('emails.meeting_invitation');
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Meeting Invitation Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.meeting_invitation',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
