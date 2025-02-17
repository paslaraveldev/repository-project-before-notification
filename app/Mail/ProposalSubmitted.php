<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

use App\Models\Proposal;


class ProposalSubmitted extends Mailable
{
    use Queueable, SerializesModels;

    public $proposal;

    /**
     * Create a new message instance.
     *
     * @param  Proposal  $proposal
     * @return void
     */
    public function __construct(Proposal $proposal)
    {
        $this->proposal = $proposal;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('New Proposal Submitted')
                    ->view('emails.proposal_submitted');
    }
}
