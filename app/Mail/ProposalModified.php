<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Proposal;

class ProposalModified extends Mailable
{use Queueable, SerializesModels;

    public $proposal;

    public function __construct(Proposal $proposal)
    {
        $this->proposal = $proposal;
    }

    public function build()
    {
        return $this->subject('Proposal Modification Notification')
                    ->view('emails.proposals.modified');
    }
}
